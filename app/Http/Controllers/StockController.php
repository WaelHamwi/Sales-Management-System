<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\branch;
use App\Models\company;
use App\Models\stock;
use App\Traits\ImageUploadTrait;
use App\Models\User;


class StockController extends Controller
{
    public function index()
    {
        $pageTitle = 'Stock Page';
        $user = auth()->user();
        $stocks = Stock::with('branch')->get();
        $serializedStocks = $stocks->map(function ($stock) {
            $productIds = Product::where('id', $stock->id)->pluck('id')->toArray();
            return [
                'id' => $stock->id,
                'branch_id' => $stock->branch->id,
                'product_ids' => $productIds
            ];
        });
        return view('admin.stocks.index', compact('serializedStocks', 'user', 'pageTitle'));
    }

    use ImageUploadTrait;

    public function create()
    {
        $user = auth()->user();
        $branches = Branch::all();
        $products = Product::all();
        return view('admin.stocks.create', ['user' => $user, 'branches' => $branches, 'products' => $products]);
    }



    /********check the products existing****/
    public function checkProductsExist(Request $request)
    {
        $productIds = $request->input('productIds');
        $branchId = $request->input('branchId');
        $products = Product::whereIn('id', $productIds)->get();

        $productData = [];
        foreach ($products as $product) {
            $exists = Stock::where('product_id', $product->id)->where('branch_id', $branchId)->exists();
            $productData[] = [
                'id' => $product->id,
                'name' => $product->name,
                'exists' => $exists
            ];
        }

        return response()->json([
            'products' => $productData
        ]);
    }


    /********check the products existing****/


    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'stock_quantity' => 'required|array',
            'stock_quantity.*' => 'integer|min:1',
        ]);
    
        $branchId = $request->input('branch_id');
        $productIds = $request->input('product_id');
        $stockQuantities = $request->input('stock_quantity');
    
        $this->processStock($branchId, $productIds, $stockQuantities);
    
        return redirect()->route('stocks.index')->with('success', __('s.stock_created_successfully'));
    }
    private function processStock($branchId, $productIds, $stockQuantities, $oldBranchId = null,$oldProductID=null)
    {
        $branchId = intval($branchId);
        try {
            if ($oldBranchId !== null) {
                $productIds = intval($productIds); 
                $existingStock = Stock::where('branch_id', $oldBranchId)
                    ->where('product_id', $oldProductID)
                    ->first();
    
                if ($existingStock) {
                    $stockQuantities = intval($stockQuantities);
                    $existingStock->update([
                        'branch_id' => $branchId,
                        'product_id' => $productIds,
                        'quantity' => $stockQuantities
                    ]);
                  
                }
            }
    
            if (is_array($productIds)) {
                foreach ($productIds as $index => $productId) {
                    $quantity = $stockQuantities[$index];
                    $productId = intval($productId);
                    $stock = new Stock([
                        'branch_id' => $branchId,
                        'product_id' => $productId,
                        'quantity' => $quantity
                    ]);
                    $stock->save();
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('Error occurred while processing stock.'));
        }
    
        return redirect()->route('stocks.index')->with('success', __('s.stock_updated_successfully'));
    }
    
    




    public function show(stock $stock)
    {
        return view('stocks.show', compact('stock'));
    }
    public function edit($id)
    {
        $pageTitle = __('s.edit_stock_page');
        $user = auth()->user();
        $stocks = stock::all();
        $branches = Branch::all();
        $products = Product::all();
        $stock = stock::findOrFail($id);

        return view('admin.stocks.edit', ['stocks' => $stocks, 'user' => $user, 'pageTitle' => $pageTitle, 'stock' => $stock, 'branches' => $branches, 'products' => $products]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'stock_quantity' => 'required|integer|min:1',
        ]);


        try {
            $stock = stock::find($id);
            $stock->quantity = $request->input('stock_quantity');


            $stock->save();

            return redirect()->route('stocks.index')->with('success', __('s.stock_updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('s.stock_updated_fail'));
        }
    }

    
public function updateAll(Request $request, $id)
{
   $stock=stock::findOrFail($id);
   $oldBranchId=$stock->branch_id;
   $oldProductID=$stock->product_id;
    $branchId = $request->input('branch_id');
    $productIds = $request->input('product_id');
    $stockQuantities = $request->input('stock_quantity');


    $this->processStock($branchId, $productIds, $stockQuantities,$oldBranchId,$oldProductID);

    return redirect()->route('stocks.index')->with('success', __('s.stock_updated_successfully'));
}

    public function getAllStocks()
    {
        // Retrieve stocks with related branch and product data
        $stocks = Stock::with('branch:id,name,company_id', 'product:id,name')->get(['id', 'quantity', 'branch_id', 'product_id']);
        $formattedStocks = [];

        foreach ($stocks as $stock) {
            $formattedStocks[] = [
                'id' => $stock->id,
                'quantity' => $stock->quantity,
                'company_id' => $stock->branch->company->name,
                'branch_id' => $stock->branch->name,
                'product_id' => $stock->product->name,
            ];
        }

        return response()->json($formattedStocks);
    }
    public function getStockDetails()
    {
        $user = auth()->user();
        $branches = Branch::all();
        $companies = Company::all();
        return View('admin.dashboard.inventoryDetails', ['user' => $user, 'branches' => $branches, 'companies' => $companies]);
    }
    public function getCompanyProductsDetails($companyId)
    {
        $branches = Branch::where('company_id', $companyId)->pluck('id');
        $productsInStock = stock::where('quantity', '>', 0)->whereIn('branch_id', $branches)->with('product')->get();
        $products = $productsInStock->pluck('product');

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found for the company.']);
        }

        return response()->json(['products' => $products]);
    }
    public function getBranchProductsDetails($branchId)
    {
        if (empty($branchId)) {
            return response()->json(['error' => 'Branch ID is required'], 400);
        }

        try {
            $productsInStock = Stock::where('quantity', '>', 0)
                ->whereIn('branch_id', (array)$branchId)
                ->with('product')
                ->get();

            $products = $productsInStock->pluck('product');

            return response()->json(['products' => $products]);
        } catch (\Exception $e) {
            \Log::error('Error fetching branch product details: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching product details'], 500);
        }
    }

    public function getAllCompanyProductsDetails()
    {
        $productsInStock = Stock::where('quantity', '>', 0)->with('product')->get();

        $products = $productsInStock->pluck('product');

        return response()->json(['products' => $products]);
    }
    public function showProduct($id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();
        if ($product) {
            return view('admin.dashboard.productShow', ['product' => $product, 'user' => $user]);
        }
    }
    /***************num of products for the dashboard**************/
    public function getNumOfProductsForCompany($companyId)
    {
        $numOfProducts = Stock::where('quantity', '>', 0)
            ->whereHas('product', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->sum('quantity');

        return response()->json(['numOfProducts' => $numOfProducts]);
    }

    public function getNumOfProductsForAllCompanies()
    {
        $numOfProducts = Stock::where('quantity', '>', 0)
            ->whereHas('product')
            ->sum('quantity');

        return response()->json(['numOfProducts' => $numOfProducts]);
    }

    public function getNumOfProductsForBranch($branchId)
    {
        $numOfProducts = Stock::where('quantity', '>', 0)
            ->whereHas('product', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })
            ->sum('quantity');

        return response()->json(['numOfProducts' => $numOfProducts]);
    }

    public function countOfBranchProductsInDaterange($branchId, Request $request)
    {
        if (empty($branchId)) {
            return response()->json(['error' => 'Branch ID are missing or invalid'], 400);
        }

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if (!$startDate || !$endDate) {
            return response()->json(['error' => 'Start date and end date are required'], 400);
        }

        if ($startDate === $endDate) {
            $endDate = date('Y-m-d', strtotime($endDate . ' +1 day'));
        }

        $stock = Stock::where('branch_id', $branchId)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->sum('quantity');

        return response()->json([
            'numOfProducts' => $stock
        ]);
    }

    public function countOfCompanyProductsInDaterange($companyId, Request $request)
    {
        if (empty($companyId)) {
            return response()->json(['error' => 'Branch ID are missing or invalid'], 400);
        }

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if (!$startDate || !$endDate) {
            return response()->json(['error' => 'Start date and end date are required'], 400);
        }

        if ($startDate === $endDate) {
            $endDate = date('Y-m-d', strtotime($endDate . ' +1 day'));
        }
        $company = Company::findOrFail($companyId);
        $branchIds = $company->branches->pluck('id');
        $stock = Stock::whereIn('branch_id', $branchIds)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->sum('quantity');

        return response()->json([
            'numOfProducts' => $stock
        ]);
    }
    public function countOfAllCompaniesProductsInDaterange(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if (!$startDate || !$endDate) {
            return response()->json(['error' => 'Start date and end date are required'], 400);
        }

        if ($startDate === $endDate) {
            $endDate = date('Y-m-d', strtotime($endDate . ' +1 day'));
        }

        $stock = Stock::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->sum('quantity');

        return response()->json([
            'numOfProducts' => $stock
        ]);
    }

    public function destroy($id)
    {
        $stock = stock::findOrFail($id);
        $stock->delete();
        return response()->json(['message' => 'stock deleted successfully']);
    }
}

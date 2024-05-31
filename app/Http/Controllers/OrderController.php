<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;
use App\Models\orderItem;
use App\Models\branch;
use App\Models\product;
use App\Models\company;
use App\Models\Currency;
use App\Models\stock;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\alert;

class OrderController extends Controller
{
  public function index()
  {
    $pageTitle = 'order page';
    $user = auth()->user();
    $orders = Order::with('branch')->get();
    $branches = branch::all();
    return view('admin.orders.index', ['orders' => $orders, 'user' => $user, 'pageTitle' => $pageTitle, 'branches' => $branches]);
  }


  public function getBranches($companyId)
  {
    $branches = Branch::where('company_id', $companyId)->get();
    return response()->json($branches);
  }

  public function getProducts($companyId)
  {
    $branches = Branch::where('company_id', $companyId)->get();
    if ($branches->isEmpty()) {
      return response()->json(['error' => 'No branches found for the given company.'], 404);
    }

    $branchIds = $branches->pluck('id');
    $stocks = Stock::whereIn('branch_id', $branchIds)->get();
    if ($stocks->isEmpty()) {
      return response()->json(['error' => 'No stocks found for the given branches.'], 404);
    }

    $productIds = $stocks->pluck('product_id');
    $products = Product::whereIn('id', $productIds)->get();
    if ($products->isEmpty()) {
      return response()->json(['error' => 'No products found for the given product IDs.'], 404);
    }

    $productNames = $products->pluck('name');
    $responseData = [
      'productIds' => $productIds,
      'productNames' => $productNames
    ];

    return response()->json($responseData);
  }

  public function getBranchProducts($branchId)
  {

    $stocks = Stock::where('branch_id', $branchId)->get();
    if ($stocks->isEmpty()) {
      return response()->json(['error' => 'No stocks found for the given branches.'], 404);
    }

    $productIds = $stocks->pluck('product_id');
    $products = Product::whereIn('id', $productIds)->get();
    if ($products->isEmpty()) {
      return response()->json(['error' => 'No products found for the given product IDs.'], 404);
    }

    $productNames = $products->pluck('name');
    $responseData = [
      'productBranchIds' => $productIds,
      'productBranchNames' => $productNames
    ];

    return response()->json($responseData);
  }
  public function getAllBranches()
  {
    $branches = Branch::all();
    return response()->json($branches);
  }

  public function create()
  {
    $user = auth()->user();
    $branches = branch::all();
    $products = product::all();
    $companies = company::all();
    return view('admin.orders.create', ['user' => $user, 'branches' => $branches, 'products' => $products, 'companies' => $companies]);
  }

  public function checkStock(Request $request)
  {
    $productIds = $request->input('product_ids');
    $quantities = $request->input('quantities');
    $orderId = $request->input('order_id');
    $status = $request->input('status');
    $order = Order::where('id', $orderId)->first();
    $statusHandleCancellToSuccess = $request->has('statusHandleCancellToSuccess') ? $request->input('statusHandleCancellToSuccess') : null;
    if ($order) {
      $oldStatus = $order->status;
      if ($oldStatus === "cancelled" && $statusHandleCancellToSuccess === "success") {
        $insufficientStock = [];

        foreach ($productIds as $index => $productId) {
          $stock = Stock::where('product_id', $productId)->first();
          $product = Product::findOrFail($productId);
          $productName = $product->name;
          $requestedQuantity = $quantities[$index];

          if (!$stock) {
            $insufficientStock[] = [
              'product_id' => $productId,
              'product_name' => __($productName),
              'product_message' => __('s.unknown_product'),
              'error' => 'No stock record found for this product'
            ];
            continue;
          }

          if ($stock->quantity < $requestedQuantity) {
            $insufficientStock[] = [
              'product_id' => $productId,
              'product_name' => $stock->product->name,
              'product_message' => __('s.insufficient_stock'),
              'available_quantity' => $stock->quantity
            ];
          }
        }

        if (count($insufficientStock) > 0) {

          return response()->json([
            'status' => 'error',
            'message' => __('s.product_not_enough_stock'),
            'insufficient_stock' => $insufficientStock
          ], 400);
        }


        return response()->json(['status' => 'success']);
      }
    }



    if ($status === "success") { //handle the case order changed from cancel to
      if ($orderId) {
        //  order_id is provided
        $orderItems = OrderItem::where('order_id', $orderId)->get();
        $orderItemsQuantity = $orderItems->pluck('quantity', 'product_id')->toArray();

        $differences = array_map(function ($quantity, $productId) use ($orderItemsQuantity) {
          return $quantity - ($orderItemsQuantity[$productId] ?? 0);
        }, $quantities, $productIds);
      } else {
        //  not provided
        $differences = $quantities;
      }
   

      $insufficientStock = [];

      foreach ($productIds as $index => $productId) {
        $stock = Stock::where('product_id', $productId)->first();
        $product = Product::findOrFail($productId);
        $productName = $product->name;
        $difference = $differences[$index];

        if (!$stock && $difference !== 0) {
          $insufficientStock[] = [
            'product_id' => $productId,
            'product_name' => __($productName),
            'productMessage' => __('s.unknown_product'),
            'error' => 'No stock record found for this product'
          ];
          continue;
        }

        if ($stock && $stock->quantity < $difference) {
          $insufficientStock[] = [
            'product_id' => $productId,
            'product_name' => $stock->product->name,
            'productMessage' => __('s.unknown_product'),
            'available_quantity' => $stock->quantity
          ];
        }
      }

      if (count($insufficientStock) > 0) {
        return response()->json([
          'status' => 'error',
          'message' => __('s.product_not_enough_stock'),
          'insufficient_stock' => $insufficientStock
        ], 400);
      }

      return response()->json(['status' => 'success']);
    }
  }




  public function performStore($request)
  {
    $request->validate([
      'order_date' => 'required|date',
      'branch_id' => 'required|integer|exists:branches,id',
      'stock_quantity' => 'required|array',
      'stock_quantity.*' => 'required|integer|min:1',
      'product_id' => 'required|array',
      'product_id.*' => 'required|integer|exists:products,id',
      'product_price' => 'required|array',
      'product_price.*' => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();

    try {
      $order = new Order();
      $branchId = $request->input('branch_id');
      $order->date = $request->input('order_date');
      $order->branch_id = $branchId;

      $stockQuantities = $request->input('stock_quantity');
      $productIds = $request->input('product_id');
      $productPrices = $request->input('product_price');
      $orderPrice = 0;

      for ($i = 0; $i < count($stockQuantities); $i++) {
        $quantity = $stockQuantities[$i];
        $price = $productPrices[$i];
        $subtotal = $quantity * $price;
        $orderPrice += $subtotal;
      }

      $order->price = $orderPrice;
      $order->save();

      for ($i = 0; $i < count($stockQuantities); $i++) {
        $product = Product::findOrFail($productIds[$i]);

        $orderItem = new OrderItem();
        $orderItem->order_id = $order->id;
        $orderItem->product_id = $product->id;
        $orderItem->product_name = $product->name;
        $orderItem->product_price = $productPrices[$i];
        $orderItem->quantity = $stockQuantities[$i];
        $orderItem->subtotal = $stockQuantities[$i] * $productPrices[$i];

        $orderItem->save();

        $stock = Stock::where('product_id', $productIds[$i])->firstOrFail();
        $stock->quantity -= $stockQuantities[$i];
        $stock->save();
      }

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }


  public function store(Request $request)
  {
    try {
      DB::beginTransaction();
      $this->performStore($request);
      DB::commit();
      return redirect()->route('orders.index')->with('success', __('s.order_created_successfully'));
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('errors1', $e->getMessage());
    }
  }


  public function show($id, Order $order)
  {
    if (!$id) {
      abort(404, 'Page not found');
    }

    $order = Order::where('id', $id)->get();
    if ($order->isEmpty()) {
      abort(404, 'Order not found');
    }

    $responseData = [
      'order' => $order->toArray(),
    ];

    return response()->json($responseData);
  }
  public function showOrderDetails($id)
  {
    $orderItems = orderItem::where('order_id', $id)
      ->with('order.branch.company.currency')
      ->get(['product_name', 'quantity', 'subtotal', 'order_id']);

    $formattedOrderItems = [];

    foreach ($orderItems as $orderItem) {
      $formattedOrderItems[] = [
        'product_name' => $orderItem->product_name,
        'quantity' => $orderItem->quantity,
        'subtotal' => $orderItem->subtotal,
        'branch_name' => $orderItem->order->branch->name ?? 'N/A',
        'currency_symbol' => $orderItem->order->branch->company->currency->symbol ?? 'no currency added',
      ];
    }

    return response()->json($formattedOrderItems);
  }




  public function edit($id)
  {
    $user = auth()->user();
    $order = Order::findOrFail($id);
    $orderId = $order->id;
    $orderItems = OrderItem::whereIn('order_id', [$orderId])->get();
    $selectedProductIds = $orderItems->pluck('product_id')->toArray();
    $orderPrice = $order->price;

    $branch = Branch::findOrFail($order->branch_id);
    $companyId = $branch->company_id;

    $productQuantities = [];
    $productPrices = [];
    $productTotalPrices = [];
    foreach ($orderItems as $orderItem) {
      $productId = $orderItem->product_id;
      $productQuantities[$productId] = $orderItem->quantity;
      $productPrices[$productId] = $orderItem->product_price;

      $productTotalPrices[$productId] = $orderItem->quantity * $orderItem->product_price;
    }

    $branches = Branch::all();
    $products = Product::all(['id', 'name']);
    $companies = Company::all();

    return view('admin.orders.edit', [
      'user' => $user,
      'order' => $order,
      'selectedProductIds' => $selectedProductIds,
      'branches' => $branches,
      'products' => $products,
      'companies' => $companies,
      'orderPrice' => $orderPrice,
      'productQuantities' => $productQuantities,
      'productPrices' => $productPrices,
      'productTotalPrices' => $productTotalPrices,
      'companyId' => $companyId,
    ]);
  }

  public function cancelOrder($order)
  {


    $orderItems = $order->orderItems;
    $productIds = [];
    $quantities = [];

    foreach ($orderItems as $orderItem) {
      //check if the existing of the product in the stock 
      $stock = Stock::where('product_id', $orderItem->product_id)->first();
      if ($stock) {
        $stock->quantity += $orderItem->quantity;
        $stock->save();
      } else {
        $branchId = $order->branch_id;
        $productIds[] = $orderItem->product_id;
        $quantities[] = $orderItem->quantity;
        //create a new stock to return the products
        $stockController = new StockController();
        $stockController->store(new Request([
          'branch_id' => $branchId,
          'product_id' => $productIds,
          'stock_quantity' => $quantities,
        ]));
      }
    }
    if ($orderItems->count() <= 1) {
      $orderId = $order->id;
      $orderItem = OrderItem::where('order_id', $orderId)->first();
      if ($orderItem) {
        $orderItem->quantity = 0;
        $orderItem->subtotal = 0;
        $orderItem->save();
      }
    } else {
      foreach ($orderItems as $orderItem) {
        $orderItem = OrderItem::where('product_id', $orderItem->product_id)->first();

        if ($orderItem) {
          $orderItem->quantity = 0;
          $orderItem->subtotal = 0;
          $orderItem->save();
        }
      }
    }



    $order->status = "cancelled";
    $order->price = 0;
    $order->save();
  }

  public function update(Request $request, $id)
  {
    $order = Order::findOrFail($id);
    $user = auth()->user();
    $orderItems = $order->orderItems;
    $branchId = $order->branch_id;
    $branch = Branch::findOrFail($branchId);
    $companyId = $branch->company_id;
    $status = $request->status;
    if ((int)$request->branch_id !== $order->branch_id || (int)$request->company !== $companyId) {
      try {
        DB::beginTransaction();
        $this->performDestroy($id);
        $this->performStore($request);
        DB::commit();
        return redirect()->route('orders.index')->with('success', __('s.order_cancelled_stored_successfully'));
      } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('errors1', $e->getMessage());
      }
    }

    if ($status === "cancelled") {
      $this->cancelOrder($order);
      return redirect()->route('orders.index')->with('success', __('s.order_cancelled_successfully'));
    }

    try {
      $request->validate([
        'order_date' => 'required|date',
        'branch_id' => 'required|integer|exists:branches,id',
        'stock_quantity' => 'required|array',
        'stock_quantity.*' => 'required|integer|min:1',
        'product_id' => 'required|array',
        'product_id.*' => 'required|integer|exists:products,id',
        'product_price' => 'required|array',
        'product_price.*' => 'required|numeric|min:0',
      ]);

      $order->date = $request->input('order_date');
      $order->branch_id = $request->input('branch_id');

      $totalPrice = 0;

      foreach ($orderItems as $key => $orderItem) {
        if (isset($request->product_id[$key]) && isset($request->product_price[$key]) && isset($request->stock_quantity[$key])) {
          $product = Product::findOrFail($request->product_id[$key]);
          $newQuantity = $request->stock_quantity[$key];
          $currentQuantity = $orderItem->quantity;

          // Update stock quantity based on the difference
          $stock = Stock::where('product_id', $product->id)->firstOrFail();
          if ($newQuantity > $currentQuantity) {
            $stock->quantity -= ($newQuantity - $currentQuantity);
          } elseif ($newQuantity < $currentQuantity) {
            $stock->quantity += ($currentQuantity - $newQuantity);
          }
          $stock->save();
          $orderItem->product_id = $product->id;
          $orderItem->product_name = $product->name;
          $orderItem->product_price = $request->product_price[$key];
          $orderItem->quantity = $newQuantity;
          $orderItem->subtotal = $newQuantity * $request->product_price[$key];
          $orderItem->save();
          $totalPrice += $orderItem->subtotal;
        } elseif (count($orderItems) === 1) {
          $product = Product::findOrFail($request->product_id[0]);
          $newQuantity = $request->stock_quantity[0];
          $currentQuantity = $orderItem->quantity;

          $stock = Stock::where('product_id', $product->id)->firstOrFail();
          if ($newQuantity > $currentQuantity) {
            $stock->quantity -= ($newQuantity - $currentQuantity);
          } elseif ($newQuantity < $currentQuantity) {
           
            $stock->quantity += ($currentQuantity - $newQuantity);
          }
          $stock->save();
          $orderItem->product_id = $product->id;
          $orderItem->product_name = $product->name;
          $orderItem->product_price = $request->product_price[0];
          $orderItem->quantity = $newQuantity;
          $orderItem->subtotal = $newQuantity * $request->product_price[0];
          $orderItem->save();
          $totalPrice += $orderItem->subtotal;
        }
      }

      if ($status) {
        $order->status = $status;
      }
      $order->price = $totalPrice;
      $order->save();
    } catch (\Exception $e) {
      return redirect()->back()->with('errors1', $e->getMessage());
    }


    return redirect()->route('orders.index')->with('success', __('s.order_updated_successfully'));
  }






  public function getAllOrders()
  {
    $orders = Order::with('branch.company.currency')->get(['id', 'date', 'price', 'status', 'branch_id']);
    $formattedOrders = [];

    foreach ($orders as $order) {
      $formattedOrders[] = [
        'id' => $order->id,
        'date' => $order->date,
        'price' => $order->price,
        'branch_name' => $order->branch->name ?? 'N/A',
        'currency_symbol' => $order->branch->company->currency->symbol ?? 'no currency added',
        'status' => $order->status,
      ];
    }

    return response()->json($formattedOrders);
  }


  /* for all companies and branches all date*/
  public function countOfSuccessSales()
  {
    $ordersCount = order::where('status', 'success')->count();
    $orderSales = order::sum('price');
    return response()->json(['orderCount' => $ordersCount, 'orderSales' => $orderSales]);
  }

  public function countOfSuccessBranchSales($companyId)
  {
    $branchIds = [];
    $branches = Branch::where('company_id', $companyId)->get();

    foreach ($branches as $branch) {
      $branchIds[] = $branch->id;
    }

    $ordersBranchCount = Order::whereIn('branch_id', $branchIds)
      ->where('status', 'success')
      ->count();
    $ordersBranchSales = Order::whereIn('branch_id', $branchIds)->sum('price');
    $company = Company::find($companyId);
    $currencySymbol = '';

    if ($company && $company->currency_id) {
      $currency = Currency::find($company->currency_id);
      if ($currency) {
        $currencySymbol = $currency->symbol;
      }
    }
    return response()->json(['ordersBranchCount' => $ordersBranchCount, 'ordersBranchSales' => $ordersBranchSales, 'currencySymbol' => $currencySymbol]);
  }
  public function productsPrices($productIds)
  {
    $ids = explode(',', $productIds);
    $products = Product::whereIn('id', $ids)->get();
    $productsPrices = [];
    foreach ($products as $product) {
      $productsPrices[$product->id] = $product->price;
    }

    return response()->json($productsPrices);
  }
  public function countOfSuccessSalesInDaterange($companyId, Request $request)
  {
    if ($companyId) {
      $startDate = $request->input('startDate');
      $endDate = $request->input('endDate');

      if ($startDate === $endDate) {
        $endDate = date('Y-m-d', strtotime($endDate . ' +1 day'));
      }

      $branchIds = [];

      $branches = Branch::where('company_id', $companyId)->get();

      foreach ($branches as $branch) {
        $branchIds[] = $branch->id;
      }

      $ordersCountDaterange = Order::whereIn('branch_id', $branchIds)
        ->where('status', 'success')
        ->whereDate('created_at', '>=', $startDate)
        ->whereDate('created_at', '<=', $endDate)
        ->count();

      $ordersSalesDaterange = Order::whereIn('branch_id', $branchIds)
        ->whereDate('created_at', '>=', $startDate)
        ->whereDate('created_at', '<=', $endDate)
        ->sum('price');

      $company = Company::find($companyId);
      $currencySymbol = '';

      if ($company && $company->currency_id) {
        $currency = Currency::find($company->currency_id);
        if ($currency) {
          $currencySymbol = $currency->symbol;
        }
      }
      return response()->json([
        'ordersCountDaterange' => $ordersCountDaterange,
        'ordersSalesDaterange' => $ordersSalesDaterange,
        'currencySymbol' => $currencySymbol,
      ]);
    }
  }


  public function countOfSuccessSalesBranchInDaterange($branchId, Request $request)
  {
    if (!$branchId) {
      return response()->json(['error' => 'Branch ID is missing'], 400);
    }

    $startDate = $request->input('startDate');
    $endDate = $request->input('endDate');

    if (!$startDate || !$endDate) {
      return response()->json(['error' => 'Start date and end date are required'], 400);
    }

    if ($startDate === $endDate) {
      $endDate = date('Y-m-d', strtotime($endDate . ' +1 day'));
    }

    $orders = Order::where('branch_id', $branchId)
      ->whereDate('created_at', '>=', $startDate)
      ->whereDate('created_at', '<=', $endDate);

    $ordersCountDaterange = $orders->where('status', 'success')->count();
    $ordersSalesDaterange = $orders->sum('price');

    $currencySymbol = '';
    $branch = branch::findOrFail($branchId);
    $companyId = $branch->company_id;
    $company = Company::where('id', $companyId)->first();
    if ($company && $company->currency_id) {
      $currency = Currency::find($company->currency_id);
      $currencySymbol = $currency ? $currency->symbol : '';
    }

    return response()->json([
      'ordersCountDaterange' => $ordersCountDaterange,
      'ordersSalesDaterange' => $ordersSalesDaterange,
      'currencySymbol' => $currencySymbol
    ]);
  }



  public function countOfSuccessSalesInDaterangeAllCompanies(Request $request)
  {
    $startDate = $request->input('startDate');
    $endDate = $request->input('endDate');

    if ($startDate === $endDate) {
      $endDate = date('Y-m-d', strtotime($endDate . ' +1 day'));
    }

    $ordersCountDaterange = Order::where('status', 'success')
      ->whereDate('created_at', '>=', $startDate)
      ->whereDate('created_at', '<=', $endDate)
      ->count();

    $ordersSalesDaterange = Order::whereDate('created_at', '>=', $startDate)
      ->whereDate('created_at', '<=', $endDate)
      ->sum('price');

    return response()->json(['ordersCountDaterange' => $ordersCountDaterange, 'ordersSalesDaterange' => $ordersSalesDaterange]);
  }

  public function countOfSuccessSalesInBranch($branchId)
  {
    $ordersBranchCount = Order::where('branch_id', $branchId)->where('status', 'success')->count();
    $ordersBranchSales = Order::where('branch_id', $branchId)->sum('price');
    $branch = branch::find($branchId);
    $companyId = $branch->company_id;
    $company = company::findOrFail($companyId);
    $currencySymbol = '';
    if ($company && $company->currency_id) {
      $currency = Currency::find($company->currency_id);
      if ($currency) {
        $currencySymbol = $currency->symbol;
      }
    }
    return response()->json(['ordersBranchCount' => $ordersBranchCount, 'ordersBranchSales' => $ordersBranchSales, 'currencySymbol' => $currencySymbol]);
  }

  protected function performDestroy($id)
  {
    $order = Order::findOrFail($id);
    $orderItems = $order->orderItems;
    $productIds = [];
    $quantities = [];

    foreach ($orderItems as $orderItem) {
      $stock = Stock::where('product_id', $orderItem->product_id)->first();
      if ($stock) {
        $stock->quantity += $orderItem->quantity;
        $stock->save();
      } else {
        $branchId = $order->branch_id;
        $productIds[] = $orderItem->product_id;
        $quantities[] = $orderItem->quantity;

        $stockController = new StockController();
        $stockController->store(new Request([
          'branch_id' => $branchId,
          'product_id' => $productIds,
          'stock_quantity' => $quantities,
        ]));
      }
    }

    $order->delete();
  }
  public function destroy($id)
  {
    try {
      DB::beginTransaction();
      $this->performDestroy($id);
      DB::commit();
      return response()->json(['message' => 'Order deleted successfully']);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }
}

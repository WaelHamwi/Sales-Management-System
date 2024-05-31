<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\company;
use App\Models\product;
use App\Traits\ImageUploadTrait;

class ProductController extends Controller
{
  public function index()
{
    $pageTitle = 'Product Page';
    $user = auth()->user();
    $products = Product::with('company', 'category')->get();
    $categories = Category::all();
    $companies = Company::all();

    return view('admin.products.index', [
        'products' => $products,
        'user' => $user,
        'pageTitle' => $pageTitle,
        'categories' => $categories,
        'companies' => $companies
    ]);
}

  use ImageUploadTrait;

    public function product_upload_image(Request $request)
    {
      $validatedData = $request->validate([
         'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
      return $this->uploadImage($request, 'uploads', 'product');
    }

    public function create()
    {
      $user = auth()->user();
      $companies = Company::all();
      $categories = Category::all();
      return view('admin.products.create', ['user'=>$user,'companies'=>$companies,'categories'=>$categories]);
    }

    public function store(Request $request)
  {
    $request->validate([
    'product_name' => 'required|string|min:1|max:35',
    'company_id' => 'required|exists:companies,id',
    'category_id' => 'required|exists:categories,id',
    'product_price' => ['required', 'regex:/^\d{1,16}(\.\d{1,2})?$/'],
    'product_sku' => 'nullable|string|max:64',
    'product_barcode' => 'nullable|string|max:48',
    'image' => 'string|max:100',
]);
      $product = new Product();
      $product->name = $request->input('product_name');
      $product->price = $request->input('product_price');
      $product->sku = $request->input('product_sku');
      $product->barcode = $request->input('product_barcode');
      $product->company_id = $request->input('company_id');
      $product->category_id = $request->input('category_id');

      if ($request->input('image')) {
          $product->image = $request->input('image');
      }

    $product->save();

      return redirect()->route('products.index')->with('success', __('s.product_created_successfully'));
  }

    public function show(product $product)
    {
        return view('products.show', compact('product'));
    }
    public function edit($id)
  {
    $pageTitle = __('s.edit_product_page');
    $user = auth()->user();
    $products = Product::all();
    $companies= Company::all();
    $categories= Category::all();
    $product = product::findOrFail($id);

  
      return view('admin.products.edit', ['products' => $products, 'user' => $user,'pageTitle'=>$pageTitle, 'product'=>$product,'companies'=>$companies,'categories'=>$categories]);
  }


  public function update(Request $request, $id)
{
  $request->validate([
    'product_name' => 'required|string|min:1|max:35',
    'company_id' => 'required|exists:companies,id',
    'category_id' => 'required|exists:categories,id',
    'product_price' => ['required', 'regex:/^\d{1,16}(\.\d{1,2})?$/'],
    'product_sku' => 'nullable|string|max:64',
    'product_barcode' => 'nullable|string|max:48',
  ]);


    try {
        $product= Product::find($id);

        $product->name = $request->input('product_name');
        $product->price = $request->input('product_price');
        $product->sku = $request->input('product_sku');
        $product->barcode = $request->input('product_barcode');
        $product->company_id = $request->input('company_id');
        $product->category_id = $request->input('category_id');

        if ($request->input('image')) {
          $product->image = $request->input('image');
        }

      $product->save();

        return redirect()->route('products.index')->with('success', __('s.product_updated_successfully'));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', __('s.product_updated_fail'));
    }
}
public function getAllProducts()
{
    $products = Product::with(['company.currency', 'category'])
        ->get(['id', 'name', 'price', 'barcode', 'sku', 'image', 'company_id', 'category_id']);

 
    $formattedProducts = [];

    foreach ($products as $product) {
        $formattedProducts[] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'sku' => $product->sku,
            'barcode' => $product->barcode,
            'image' => $product->image,
            'company_name' => $product->company->name,
            'category_name' => $product->category->name,
            'currency_symbol' => $product->company->currency->symbol ?? 'no currency added', 
        ];
    }

    return response()->json($formattedProducts);
}





public function destroy($id) {
$product = product::findOrFail($id);
$product->delete();
return response()->json(['message' => 'product deleted successfully']);
}
}

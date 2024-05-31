<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\company;
use App\Traits\ImageUploadTrait;

class CategoryController extends Controller
{
  public function index()
  {
      $pageTitle='category page';
      $user = auth()->user();
      $categories = Category::with('company')->get();

      $companies = Company::all();

      return view('admin.categories.index', ['categories' => $categories, 'user' => $user,'pageTitle'=>$pageTitle,'companies'=>$companies]);
  }

  use ImageUploadTrait;

    public function category_upload_image(Request $request)
    {
      $validatedData = $request->validate([
         'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
      return $this->uploadImage($request, 'uploads', 'category');
    }

    public function create()
    {
      $user = auth()->user();
      $companies = Company::all();
      return view('admin.categories.create', ['user'=>$user,'companies'=>$companies]);
    }

    public function store(Request $request)
  {
      $request->validate([
          'category_name' => 'required|string|min:1|max:35',
          'company_id' => 'required|exists:companies,id',
      ]);

      $category = new Category();
      $category->name = $request->input('category_name');
      $category->company_id = $request->input('company_id');

      if ($request->input('image')) {
          $category->image = $request->input('image');
      }

      $category->save();

      return redirect()->route('categories.index')->with('success', __('s.category_created_successfully'));
  }

    public function show(category $category)
    {
        return view('categories.show', compact('category'));
    }
    public function edit($id)
  {
    $pageTitle = __('s.edit_category_page');
    $user = auth()->user();
    $companies = Company::all();
    $categories = category::all();
      
      $category = category::findOrFail($id);
      return view('admin.categories.edit', ['categories' => $categories, 'user' => $user,'pageTitle'=>$pageTitle, 'category'=>$category,'companies'=>$companies]);
  }



  public function update(Request $request, $id)
{
  $request->validate([
      'category_name' => 'required|string|min:1|max:35',
      'company_id' => 'required|exists:companies,id',
  ]);


    try {
        $category = category::find($id);

        $category->name = $request->input('category_name');
        $category->company_id = $request->input('company_id');
        if ($request->input('image')) {
            $category->image = $request->input('image');
        }
        $category->save();

        return redirect()->route('categories.index')->with('success', __('s.category_updated_successfully'));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', __('s.category_updated_fail'));
    }
}
public function getAllcategories()
{
    $categories = Category::with('company:id,name')->get(['id', 'name', 'image', 'company_id']);
    $formattedcategories = [];

    foreach ($categories as $category) {
        $formattedcategories[] = [
            'id' => $category->id,
            'name' => $category->name,
            'image' => $category->image,
            'company_name' => $category->company->name
        ];
    }

    return response()->json($formattedcategories);
}


public function destroy($id) {
$category = category::findOrFail($id);
$category->delete();
return response()->json(['message' => 'category deleted successfully']);
}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\branch;
use App\Models\company;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;

class branchController extends Controller
{
  public function index()
  {
      $pageTitle='branch page';
      $user = auth()->user();
      $branches = branch::with('company')->get();

      $companies = Company::all();

      return view('admin.branches.index', ['branches' => $branches, 'user' => $user,'pageTitle'=>$pageTitle,'companies'=>$companies]);
  }

  use ImageUploadTrait;

    public function branch_upload_image(Request $request)
    {
      $validatedData = $request->validate([
         'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
      return $this->uploadImage($request, 'uploads', 'branch');
    }

    public function checkUnique(Request $request)
    {
        $branchName = $request->input('branch_name');
        $branchId = $request->input('branch_id');
        $companyId = $request->input('company_id');
    
        if (!$companyId) {
            return response()->json(['unique' => false, 'error' => 'Company ID is required.']);
        }
    
        $existingBranchQuery = DB::table('branches')
            ->where('name', $branchName)
            ->where('company_id', $companyId);
    
        if ($branchId) {
            $existingBranchQuery->where('id', '!=', $branchId);
        }
    
        $isExistingBranch = $existingBranchQuery->exists();
    
        return response()->json(['unique' => !$isExistingBranch]);
    }
    
    
    
    

    public function create()
    {
      $user = auth()->user();
      $companies = Company::all();
      return view('admin.branches.create', ['user'=>$user,'companies'=>$companies]);
    }

    public function store(Request $request)
  {
      $request->validate([
        'branch_name' => 'required|string|min:1|max:35|regex:/^[A-Za-z0-9 ]+$/',
        'company_id' => 'required|exists:companies,id',
      ]);

      $branch = new branch();
      $branch->name = $request->input('branch_name');
      $branch->company_id = $request->input('company_id');

      if ($request->input('image')) {
          $branch->image = $request->input('image');
      }

      $branch->save();

      return redirect()->route('branches.index')->with('success', __('s.branch_created_successfully'));
  }

    public function show(branch $branch)
    {
        return view('branches.show', compact('branch'));
    }
    public function edit($id)
  {
    $pageTitle = __('s.edit_branch_page');
    $user = auth()->user();
    $companies=Company::all();
    $branches = branch::all();
    $branch = branch::findOrFail($id);
    $companyId=$branch->company_id;
    $company=Company::findOrFail($companyId);
      return view('admin.branches.edit', ['branches' => $branches,'companies'=>$companies,'company'=>$company, 'user' => $user,'pageTitle'=>$pageTitle, 'branch'=>$branch]);
  }



  public function update(Request $request, $id)
{
    $request->validate([
        'branch_name' => 'required|string|min:1|max:35|regex:/^[A-Za-z0-9 ]+$/',
        'company_id' => 'required|exists:companies,id',
    ]);

    try {
        $branch = Branch::find($id);
        if (!$branch) {
            return redirect()->back()->with('error', __('s.branch_not_found'));
        }

        $branch->name = $request->input('branch_name');
        $branch->company_id = $request->input('company_id');
        
        if ($request->input('image')) {
            $branch->image = $request->input('image');
        }
        $branch->save();

        return redirect()->route('branches.index')->with('success', __('s.branch_updated_successfully'));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', __('s.branch_updated_fail'));
    }
}

public function getAllbranches()
{
    $branches = branch::with('company:id,name')->get(['id', 'name', 'image', 'company_id']);
    $formattedbranches = [];

    foreach ($branches as $branch) {
        $formattedbranches[] = [
            'id' => $branch->id,
            'name' => $branch->name,
            'image' => $branch->image,
            'company_name' => $branch->company->name
        ];
    }

    return response()->json($formattedbranches);
}


public function destroy($id) {
$branch = branch::findOrFail($id);
$branch->delete();
return response()->json(['message' => 'branch deleted successfully']);
}
}

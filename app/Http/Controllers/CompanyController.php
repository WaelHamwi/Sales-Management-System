<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Currency;
use App\Traits\ImageUploadTrait;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function index()
    {
        $pageTitle = 'company page';
        $user = auth()->user();
        $companies = Company::all();
        return view('admin.companies.index', ['companies' => $companies, 'user' => $user, 'pageTitle' => $pageTitle]);
    }

    use ImageUploadTrait;

    public function company_upload_image(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        return $this->uploadImage($request, 'uploads', 'company');
    }
    public function checkUnique(Request $request)
    {
        $companyName = $request->input('company_name');
        $companyId = $request->input('company_id');
    
        $existingCompanyQuery = Company::where('name', $companyName);
        
        if ($companyId) {
            $existingCompanyQuery->where('id', '!=', $companyId);
        }
    
        $isExistingCompany = $existingCompanyQuery->exists();
    
        return response()->json(['unique' => !$isExistingCompany]);
    }
    

    public function create()
    {
        $user = auth()->user();
        $currencies = Currency::all();
        return view('admin.companies.create', compact('user', 'currencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|min:1|max:35|unique:companies',
            'currency_id' => 'nullable|exists:currencies,id',
        ]);

        $company = new Company();
        $company->name = $request->input('company_name');
        $company->currency_id = $request->input('currency_id');

        if ($request->has('image')) {
            $company->image = $request->input('image');
        }

        $company->save();

        return redirect()->route('companies.index')->with('success', __('s.company_created_successfully'));
    }

    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }
    public function edit($id)
    {
        $pageTitle = __('s.edit_company_page');
        $user = auth()->user();
        $companies = Company::all();
        $company = Company::findOrFail($id);
        $currencies = Currency::all();

        $currency = Currency::find($company->currency_id);
        $currencyName = $currency ? $currency->name : 'Unknown Currency';

        return view('admin.companies.edit', ['companies' => $companies, 'currencies' => $currencies, 'currencyName' => $currencyName, 'user' => $user, 'pageTitle' => $pageTitle, 'company' => $company]);
    }


    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        $request->validate([
            'name' => [
                'string',
                'min:1',
                'max:35',
                Rule::unique('companies')->ignore($company->id),
            ],
            'currency_id' => 'nullable|exists:currencies,id',
        ]);

        try {
            $company = Company::find($id);
            $company->name = $request->input('company_name');
            if($request->input('currency_id')){
                $company->currency_id = $request->input('currency_id');
            }
            if ($request->input('image')) {
                $company->image = $request->input('image');
            }
            $company->save();

            return redirect()->route('companies.index')->with('success', __('s.company_updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('s.company_updated_fail'));
        }
    }
    public function getAllCompanies()
    {
        $companies = Company::all(['id', 'name', 'currency_id', 'image']);

        $formattedCompanies = [];
        foreach ($companies as $company) {
            $currencyName = Currency::find($company->currency_id)->name ?? null;

            $formattedCompanies[] = [
                'id' => $company->id,
                'name' => $company->name,
                'currency' => $currencyName,
                'image' => $company->image
            ];
        }

        return response()->json($formattedCompanies);
    }




    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json(['message' => 'Company deleted successfully']);
    }
}

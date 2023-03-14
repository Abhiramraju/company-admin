<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::paginate(10);
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url',
        ]);

        $company = new Company;
        $company->name = $validatedData['name'];
        $company->email = $validatedData['email'];
        $company->website = $validatedData['website'];

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = time() . '.' . $logo->getClientOriginalExtension();
            $path = public_path('storage/logos/' . $filename);
            Image::make($logo->getRealPath())->resize(100, 100)->save($path);
            $company->logo = $filename;
        }

        $company->save();

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    public function show($id)
    {
        $company = Company::find($id);
        return view('companies.show', compact('company'));
    }

    public function edit($id)
    {
        $company = Company::find($id);
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url',
        ]);

        $company = Company::find($id);
        $company->name = $validatedData['name'];
        $company->email = $validatedData['email'];
        $company->website = $validatedData['website'];


        if ($company->logo && $request->hasFile('logo')) {
            $path = public_path('storage/logos/' . $company->logo);
            if (file_exists($path)) {
                unlink($path);
            }
        }


        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = time() . '.' . $logo->getClientOriginalExtension();
            $path = public_path('storage/logos/' . $filename);
            Image::make($logo->getRealPath())->resize(100, 100)->save($path);
            $company->logo = $filename;
        }

        $company->save();

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }


    public function destroy($id)
    {
        $company = Company::findOrFail($id);
    
        // update the company_id of related records to null
        $company->employees()->update(['company_id' => null]);
    
        // delete the company logo file from storage if it exists
        if ($company->logo) {
            Storage::delete('logos/' . $company->logo);
        }
    
        // delete the company record
        $company->delete();
    
        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
    

}

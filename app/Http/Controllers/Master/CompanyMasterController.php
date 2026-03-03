<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\CompanyMaster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyMasterController extends Controller
{
    /**
     * Display a listing of the companies.
     */
    public function index()
    {
        $data['companies'] = CompanyMaster::orderBy('company_id', 'DESC')->get();
        return view('master/company/index', $data);
    }

    /**
     * Show the form for creating or editing a company.
     */
    public function form($id = null)
    {
        $data = [];
        if ($id) {
            $data['company'] = CompanyMaster::findOrFail($id);
        }
        return view('master/company/form', $data);
    }

    /**
     * Store or update company
     */
    public function save(Request $request, $id = null)
    {
        $company = $id
            ? CompanyMaster::findOrFail($id)
            : new CompanyMaster();

        $request->validate(
            [
                'company_code' => [
                    'required',
                    'min:2',
                    'max:50',
                    'regex:/^[A-Z0-9-]+$/i',
                    Rule::unique('companies', 'company_code')->ignore($id, 'company_id'),
                ],
                'company_name' => [
                    'required',
                    'min:3',
                    'max:255',
                    'regex:/^(?=.*[a-zA-Z])(?!.*<script>)[a-zA-Z0-9\s!@#$%^&*()_+{}\[\]:;\"\'<>,.?\/\\\\|-]+$/i',
                ],
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:50',
                'address' => 'nullable|string|max:500',
                'city' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'country' => 'nullable|string|max:100',
                'gst_number' => 'nullable|string|max:50',
                'website' => 'nullable|url|max:255',
                'status' => 'required|in:Active,Inactive',
            ],
            [
                'company_code.required' => 'Company code is required',
                'company_code.min' => 'Company code must be at least 2 characters',
                'company_code.max' => 'Company code must not exceed 50 characters',
                'company_code.regex' => 'Company code must contain only letters, numbers, and hyphens',
                'company_code.unique' => 'This company code already exists',

                'company_name.required' => 'Company name is required',
                'company_name.min' => 'Company name must be at least 3 characters',
                'company_name.max' => 'Company name must not exceed 255 characters',
                'company_name.regex' => 'Company name contains invalid characters',

                'email.email' => 'Please enter a valid email address',
                'email.max' => 'Email must not exceed 255 characters',

                'phone.max' => 'Phone must not exceed 50 characters',
                'address.max' => 'Address must not exceed 500 characters',
                'city.max' => 'City must not exceed 100 characters',
                'state.max' => 'State must not exceed 100 characters',
                'country.max' => 'Country must not exceed 100 characters',
                'gst_number.max' => 'GST number must not exceed 50 characters',

                'website.url' => 'Please enter a valid website URL',
                'website.max' => 'Website must not exceed 255 characters',

                'status.required' => 'Status is required',
            ]
        );

        $company->fill($request->all());
        $company->save();

        return redirect('companies')->with(
            'success',
            $id ? 'Company updated successfully!' : 'Company created successfully!'
        );
    }

    /**
     * Display the specified company.
     */
    public function show($id)
    {
        $data['company'] = CompanyMaster::findOrFail($id);
        return view('master/company/show', $data);
    }

    /**
     * Remove the specified company from storage.
     */
    public function destroy($id)
    {
        $company = CompanyMaster::findOrFail($id);
        $company->delete();

        return redirect('companies')->with('danger', 'Company deleted successfully!');
    }

    /**
     * Change the status of a company.
     */
    public function changeStatus(Request $request)
    {
        $company = CompanyMaster::findOrFail($request->id);
        $company->status = $request->status;
        $company->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }

    /**
     * Store selected company in session for filtering.
     */
    public function setCompany(Request $request)
    {
        $request->validate([
            'company_id' => ['required'],
        ]);

        if ($request->company_id === 'all') {
            $request->session()->put('company_id', 'all');
            return back()->with('success', 'All companies selected successfully!');
        }

        $company = CompanyMaster::where('company_id', $request->company_id)
            ->where('status', 'Active')
            ->first();

        if (!$company) {
            return back()->with('danger', 'Selected company is inactive.');
        }

        $request->session()->put('company_id', $company->company_id);

        return back()->with('success', 'Company selected successfully!');
    }
}

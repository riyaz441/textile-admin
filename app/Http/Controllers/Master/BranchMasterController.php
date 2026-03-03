<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\BranchMaster;
use App\Models\CompanyMaster;
use Illuminate\Http\Request;

class BranchMasterController extends Controller
{
    /**
     * Display a listing of the branches.
     */
    public function index()
    {
        $data['branches'] = BranchMaster::orderBy('branch_id', 'DESC')->get();
        return view('master/branch/index', $data);
    }

    /**
     * Show the form for creating or editing a branch.
     */
    public function form($id = null)
    {
        $data = [];
        $data['companies'] = CompanyMaster::where('status', 'Active')->get();
        if ($id) {
            $data['branch'] = BranchMaster::findOrFail($id);
        }
        return view('master/branch/form', $data);
    }

    /**
     * Store or update branch
     */
    public function save(Request $request, $id = null)
    {
        $branch = $id
            ? BranchMaster::findOrFail($id)
            : new BranchMaster();

        $request->validate(
            [
                'company_id' => [
                    'required',
                    'exists:companies,company_id',
                ],
                'branch_code' => [
                    'required',
                    'min:2',
                    'max:50',
                    'regex:/^[A-Z0-9-]+$/i',
                    'unique:branches,branch_code,' . ($id ?? 'NULL') . ',branch_id',
                ],
                'branch_name' => [
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
                'status' => 'required|in:Active,Inactive',
            ],
            [
                'company_id.required' => 'Company is required',
                'company_id.exists' => 'Selected company does not exist',

                'branch_code.required' => 'Branch code is required',
                'branch_code.min' => 'Branch code must be at least 2 characters',
                'branch_code.max' => 'Branch code must not exceed 50 characters',
                'branch_code.regex' => 'Branch code must contain only letters, numbers, and hyphens',
                'branch_code.unique' => 'This branch code already exists',

                'branch_name.required' => 'Branch name is required',
                'branch_name.min' => 'Branch name must be at least 3 characters',
                'branch_name.max' => 'Branch name must not exceed 255 characters',
                'branch_name.regex' => 'Branch name contains invalid characters',

                'email.email' => 'Please enter a valid email address',
                'email.max' => 'Email must not exceed 255 characters',

                'phone.max' => 'Phone must not exceed 50 characters',
                'address.max' => 'Address must not exceed 500 characters',
                'city.max' => 'City must not exceed 100 characters',
                'state.max' => 'State must not exceed 100 characters',
                'country.max' => 'Country must not exceed 100 characters',

                'status.required' => 'Status is required',
            ]
        );

        $branch->fill($request->all());
        $branch->save();

        return redirect('branches')->with(
            'success',
            $id ? 'Branch updated successfully!' : 'Branch created successfully!'
        );
    }

    /**
     * Display the specified branch.
     */
    public function show($id)
    {
        $data['branch'] = BranchMaster::findOrFail($id);
        return view('master/branch/show', $data);
    }

    /**
     * Remove the specified branch from storage.
     */
    public function destroy($id)
    {
        $branch = BranchMaster::findOrFail($id);
        $branch->delete();

        return redirect('branches')->with('danger', 'Branch deleted successfully!');
    }

    /**
     * Change the status of a branch.
     */
    public function changeStatus(Request $request)
    {
        $branch = BranchMaster::findOrFail($request->id);
        $branch->status = $request->status;
        $branch->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }

    /**
     * Get branches by company for AJAX requests.
     */
    public function getByCompany(Request $request)
    {
        $request->validate([
            'company_id' => ['required', 'exists:companies,company_id'],
        ]);

        $branches = BranchMaster::where('company_id', $request->company_id)
            ->where('status', 'Active')
            ->orderBy('branch_name')
            ->get(['branch_id', 'branch_name']);

        return response()->json(['success' => true, 'branches' => $branches]);
    }
}

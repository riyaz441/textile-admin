<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\CompanyMaster;
use App\Models\LaborMaster;
use Illuminate\Http\Request;

class LaborMasterController extends Controller
{
    /**
     * Display a listing of the labor masters.
     */
    public function index()
    {
        $data['labors'] = LaborMaster::orderBy('labor_id', 'DESC')->get();
        return view('master/labor/index', $data);
    }

    /**
     * Show the form for creating or editing a labor.
     */
    public function form($id = null)
    {
        $data = [];
        $data['companies'] = CompanyMaster::where('status', 'Active')->get();
        if ($id) {
            $data['labor'] = LaborMaster::findOrFail($id);
        }
        return view('master/labor/form', $data);
    }

    /**
     * Store or update labor
     */
    public function save(Request $request, $id = null)
    {
        $labor = $id
            ? LaborMaster::findOrFail($id)
            : new LaborMaster();

        $request->validate(
            [
                'company_id' => [
                    'required',
                    'exists:companies,company_id',
                ],
                'labor_code' => [
                    'required',
                    'min:2',
                    'max:50',
                    'regex:/^[A-Z0-9-]+$/i',
                    'unique:labors,labor_code,' . ($id ?? 'NULL') . ',labor_id',
                ],
                'labor_name' => [
                    'required',
                    'min:3',
                    'max:100',
                    'regex:/^(?=.*[a-zA-Z])(?!.*<script>)[a-zA-Z0-9\s!@#$%^&*()_+{}\[\]:;\"\'<>,.?\/\\\\|-]+$/i',
                ],
                'description' => 'nullable|string|max:500',
                'base_cost' => 'nullable|numeric|min:0',
                'cost_per_hour' => 'nullable|numeric|min:0',
                'estimated_hours' => 'nullable|numeric|min:0',
                'skill_level' => 'required|in:basic,intermediate,advanced,master',
                'status' => 'required|in:Active,Inactive',
            ],
            [
                'company_id.required' => 'Company is required',
                'company_id.exists' => 'Selected company does not exist',

                'labor_code.required' => 'Labor code is required',
                'labor_code.min' => 'Labor code must be at least 2 characters',
                'labor_code.max' => 'Labor code must not exceed 50 characters',
                'labor_code.regex' => 'Labor code must contain only letters, numbers, and hyphens',
                'labor_code.unique' => 'This labor code already exists',

                'labor_name.required' => 'Labor name is required',
                'labor_name.min' => 'Labor name must be at least 3 characters',
                'labor_name.max' => 'Labor name must not exceed 100 characters',
                'labor_name.regex' => 'Labor name contains invalid characters',

                'base_cost.numeric' => 'Base cost must be a valid number',
                'cost_per_hour.numeric' => 'Cost per hour must be a valid number',
                'estimated_hours.numeric' => 'Estimated hours must be a valid number',

                'skill_level.required' => 'Skill level is required',
                'status.required' => 'Status is required',
            ]
        );

        $labor->fill($request->all());
        $labor->save();

        return redirect('labors')->with(
            'success',
            $id ? 'Labor updated successfully!' : 'Labor created successfully!'
        );
    }

    /**
     * Display the specified labor.
     */
    public function show($id)
    {
        $data['labor'] = LaborMaster::findOrFail($id);
        return view('master/labor/show', $data);
    }

    /**
     * Remove the specified labor from storage.
     */
    public function destroy($id)
    {
        $labor = LaborMaster::findOrFail($id);
        $labor->delete();

        return redirect('labors')->with('danger', 'Labor deleted successfully!');
    }

    /**
     * Change the status of a labor.
     */
    public function changeStatus(Request $request)
    {
        $labor = LaborMaster::findOrFail($request->id);
        $labor->status = $request->status;
        $labor->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }
}

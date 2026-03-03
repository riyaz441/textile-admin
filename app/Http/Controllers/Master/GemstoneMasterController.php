<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\BranchMaster;
use App\Models\CompanyMaster;
use App\Models\GemstoneMaster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GemstoneMasterController extends Controller
{
    /**
     * Display a listing of the gemstones.
     */
    public function index()
    {
        $data['gemstones'] = GemstoneMaster::with(['company', 'branch'])
            ->orderBy('gemstone_id', 'DESC')
            ->get();
        return view('master/gemstone/index', $data);
    }

    /**
     * Show the form for creating or editing a gemstone.
     */
    public function form($id = null)
    {
        $data = [];
        $data['companies'] = CompanyMaster::where('status', 'Active')->orderBy('company_name')->get();
        $data['branches'] = BranchMaster::where('status', 'Active')->orderBy('branch_name')->get();
        if ($id) {
            $data['gemstone'] = GemstoneMaster::findOrFail($id);
        }
        return view('master/gemstone/form', $data);
    }

    /**
     * Store or update gemstone
     */
    public function save(Request $request, $id = null)
    {
        $gemstone = $id
            ? GemstoneMaster::findOrFail($id)
            : new GemstoneMaster();

        $request->validate(
            [
                'company_id' => [
                    'required',
                    'exists:companies,company_id',
                ],
                'branch_id' => [
                    'required',
                    'exists:branches,branch_id',
                ],
                'gemstone_name' => [
                    'required',
                    'min:2',
                    'max:50',
                    'string',
                ],
                'type' => [
                    'required',
                    'in:diamond,ruby,sapphire,emerald,pearl,other',
                ],
                'color' => 'nullable|string|max:30',
                'clarity' => 'nullable|string|max:30',
                'cut_grade' => 'nullable|string|max:30',
                'default_carat_weight' => 'nullable|numeric|min:0|max:999.999',
                'gemstone_code' => [
                    'nullable',
                    'string',
                    'max:50',
                    Rule::unique('gemstones', 'gemstone_code')->ignore($id, 'gemstone_id'),
                ],
                'shape' => 'nullable|string|max:50',
                'cut' => 'nullable|string|max:50',
                'measurement_length' => 'nullable|numeric|min:0|max:9999.99',
                'measurement_width' => 'nullable|numeric|min:0|max:9999.99',
                'measurement_depth' => 'nullable|numeric|min:0|max:9999.99',
                'treatment' => 'nullable|string|max:100',
                'origin' => 'nullable|string|max:100',
                'fluorescence' => 'nullable|string|max:50',
                'symmetry' => 'nullable|string|max:50',
                'polish' => 'nullable|string|max:50',
                'girdle' => 'nullable|string|max:50',
                'culet' => 'nullable|string|max:50',
                'table_percentage' => 'nullable|numeric|min:0|max:999.99',
                'depth_percentage' => 'nullable|numeric|min:0|max:999.99',
                'certification_lab' => 'nullable|string|max:100',
                'certification_number' => 'nullable|string|max:100',
                'certification_date' => 'nullable|date',
                'status' => 'required|in:Active,Inactive',
            ],
            [
                'company_id.required' => 'Company is required',
                'company_id.exists' => 'Selected company does not exist',
                'branch_id.required' => 'Branch is required',
                'branch_id.exists' => 'Selected branch does not exist',
                'gemstone_name.required' => 'Gemstone name is required',
                'gemstone_name.min' => 'Gemstone name must be at least 2 characters',
                'gemstone_name.max' => 'Gemstone name must not exceed 50 characters',

                'type.required' => 'Type is required',
                'type.in' => 'Invalid gemstone type selected',

                'color.max' => 'Color must not exceed 30 characters',
                'clarity.max' => 'Clarity must not exceed 30 characters',
                'cut_grade.max' => 'Cut grade must not exceed 30 characters',
                'default_carat_weight.numeric' => 'Default carat weight must be a number',
                'default_carat_weight.max' => 'Default carat weight must not exceed 999.999',
                'gemstone_code.unique' => 'Gemstone code must be unique',
                'status.required' => 'Status is required',
            ]
        );

        $gemstone->fill($request->all());
        $gemstone->save();

        return redirect('gemstones')->with(
            'success',
            $id ? 'Gemstone updated successfully!' : 'Gemstone created successfully!'
        );
    }

    /**
     * Display the specified gemstone.
     */
    public function show($id)
    {
        $data['gemstone'] = GemstoneMaster::with(['company', 'branch'])->findOrFail($id);
        return view('master/gemstone/show', $data);
    }

    /**
     * Remove the specified gemstone from storage.
     */
    public function delete($id)
    {
        $gemstone = GemstoneMaster::findOrFail($id);
        $gemstone->delete();

        return redirect('gemstones')->with('danger', 'Gemstone deleted successfully!');
    }

    /**
     * Change the status of a gemstone.
     */
    public function changeStatus(Request $request)
    {
        $gemstone = GemstoneMaster::findOrFail($request->id);
        $gemstone->status = $request->status;
        $gemstone->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }
}

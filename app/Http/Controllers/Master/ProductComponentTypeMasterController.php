<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\CompanyMaster;
use App\Models\ComponentTypeMaster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductComponentTypeMasterController extends Controller
{
    /**
     * Display all component types.
     */
    public function index()
    {
        $data['componentTypes'] = ComponentTypeMaster::with('company')
            ->orderBy('type_id', 'desc')
            ->get();

        return view('master/component_type/index', $data);
    }

    /**
     * Show the form for creating or editing a component type.
     */
    public function form($id = null)
    {
        $data = [];
        $data['companies'] = CompanyMaster::where('status', 'Active')->orderBy('company_name')->get();
        if ($id) {
            $data['componentType'] = ComponentTypeMaster::findOrFail($id);
        }

        return view('master/component_type/form', $data);
    }

    /**
     * Store or update component type.
     */
    public function save(Request $request, $id = null)
    {
        $componentType = $id
            ? ComponentTypeMaster::findOrFail($id)
            : new ComponentTypeMaster();

        $request->validate(
            [
                'company_id' => [
                    'required',
                    'exists:companies,company_id',
                ],
                'type_name' => [
                    'required',
                    'string',
                    'max:100',
                    'regex:/^[A-Za-z. ]+$/',
                    Rule::unique('component_types', 'type_name')
                        ->where(fn ($query) => $query->where('company_id', $request->company_id))
                        ->ignore($id, 'type_id'),
                ],
                'category' => 'nullable|string|max:100',
                'description' => 'nullable|string',
                'status' => 'required|in:Active,Inactive',
            ],
            [
                'company_id.required' => 'Company is required',
                'company_id.exists' => 'Selected company does not exist',
                'type_name.required' => 'Component type name is required',
                'type_name.unique' => 'This component type name already exists',
                'status.required' => 'Status is required',
            ]
        );

        $componentType->fill($request->all());
        $componentType->save();

        return redirect('component-types')->with(
            'success',
            $id ? 'Component type updated successfully!' : 'Component type created successfully!'
        );
    }

    /**
     * Display the specified component type.
     */
    public function show($id)
    {
        $data['componentType'] = ComponentTypeMaster::with('company')->findOrFail($id);
        return view('master/component_type/show', $data);
    }

    /**
     * Delete component type.
     */
    public function destroy($id)
    {
        ComponentTypeMaster::findOrFail($id)->delete();

        return redirect('component-types')->with('danger', 'Component type deleted successfully!');
    }

    /**
     * Change the status of a component type.
     */
    public function changeStatus(Request $request)
    {
        $componentType = ComponentTypeMaster::findOrFail($request->id);
        $componentType->status = $request->status;
        $componentType->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }
}

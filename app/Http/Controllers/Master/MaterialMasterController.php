<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialMasterController extends Controller
{
    /**
     * Display a listing of the materials.
     */
    public function index()
    {
        $data['materials'] = Material::orderBy('material_id', 'DESC')->get();
        return view('master/material/index', $data);
    }

    /**
     * Show the form for creating or editing a material.
     */
    public function form($id = null)
    {
        $data = [];
        if ($id) {
            $data['material'] = Material::findOrFail($id);
        }
        return view('master/material/form', $data);
    }

    /**
     * Store or update material
     */
    public function save(Request $request, $id = null)
    {
        $material = $id
            ? Material::findOrFail($id)
            : new Material();

        $request->validate(
            [
                'material_name' => [
                    'required',
                    'max:50',
                    'unique:materials,material_name,' . ($id ?? 'NULL') . ',material_id',
                ],
                'description' => 'nullable|string',
                'carat_purity' => 'nullable|string|max:20',
                'density' => 'nullable|numeric',
                'status' => 'required|in:Active,Inactive',
            ],
            [
                'material_name.required' => 'Material name is required',
                'material_name.max' => 'Material name must not exceed 50 characters',
                'material_name.unique' => 'This material name already exists',
                'carat_purity.max' => 'Carat/Purity must not exceed 20 characters',
                'density.numeric' => 'Density must be a valid number',
                'status.required' => 'Status is required',
            ]
        );

        $material->material_name = $request->material_name;
        $material->description = $request->description;
        $material->carat_purity = $request->carat_purity;
        $material->density = $request->density;
        $material->status = $request->status;
        $material->save();

        return redirect('materials')->with(
            'success',
            $id ? 'Material updated successfully!' : 'Material created successfully!'
        );
    }

    /**
     * Display the specified material.
     */
    public function show($id)
    {
        $data['material'] = Material::findOrFail($id);
        return view('master/material/show', $data);
    }

    /**
     * Remove the specified material from storage.
     */
    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect('materials')->with('danger', 'Material deleted successfully!');
    }

    /**
     * Change the status of a material.
     */
    public function changeStatus(Request $request)
    {
        $material = Material::findOrFail($request->id);
        $material->status = $request->status;
        $material->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }
}

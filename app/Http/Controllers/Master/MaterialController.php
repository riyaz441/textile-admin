<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::orderBy('material_id', 'DESC')->get();
        return view('master.material.index', compact('materials'));
    }

    public function create()
    {
        return view('master.material.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_name' => 'required|max:50|unique:materials,material_name',
            'description' => 'nullable|string',
            'carat_purity' => 'nullable|string|max:20',
            'density' => 'nullable|numeric',
        ]);
        Material::create($request->only(['material_name', 'description', 'carat_purity', 'density']));
        return redirect()->route('materials.index')->with('success', 'Material created successfully!');
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        return view('master.material.edit', compact('material'));
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        $request->validate([
            'material_name' => 'required|max:50|unique:materials,material_name,' . $id . ',material_id',
            'description' => 'nullable|string',
            'carat_purity' => 'nullable|string|max:20',
            'density' => 'nullable|numeric',
        ]);
        $material->update($request->only(['material_name', 'description', 'carat_purity', 'density']));
        return redirect()->route('materials.index')->with('success', 'Material updated successfully!');
    }

    public function show($id)
    {
        $material = Material::findOrFail($id);
        return view('master.material.show', compact('material'));
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();
        return redirect()->route('materials.index')->with('danger', 'Material deleted successfully!');
    }
}

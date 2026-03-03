<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Gemstone;
use Illuminate\Http\Request;

class GemstoneController extends Controller
{
    public function index()
    {
        $gemstones = Gemstone::orderBy('gemstone_id', 'DESC')->get();
        return view('master.gemstone.index', compact('gemstones'));
    }

    public function create()
    {
        return view('master.gemstone.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gemstone_name' => 'required|max:50',
            'type' => 'required|in:diamond,ruby,sapphire,emerald,pearl,other',
            'color' => 'nullable|max:30',
            'clarity' => 'nullable|max:30',
            'cut_grade' => 'nullable|max:30',
            'default_carat_weight' => 'nullable|numeric',
            'gemstone_code' => 'nullable|max:50|unique:gemstones,gemstone_code',
            'shape' => 'nullable|max:50',
            'cut' => 'nullable|max:50',
            'measurement_length' => 'nullable|numeric',
            'measurement_width' => 'nullable|numeric',
            'measurement_depth' => 'nullable|numeric',
            'treatment' => 'nullable|max:100',
            'origin' => 'nullable|max:100',
            'fluorescence' => 'nullable|max:50',
            'symmetry' => 'nullable|max:50',
            'polish' => 'nullable|max:50',
            'girdle' => 'nullable|max:50',
            'culet' => 'nullable|max:50',
            'table_percentage' => 'nullable|numeric',
            'depth_percentage' => 'nullable|numeric',
            'certification_lab' => 'nullable|max:100',
            'certification_number' => 'nullable|max:100',
            'certification_date' => 'nullable|date',
        ]);
        Gemstone::create($request->all());
        return redirect()->route('gemstones.index')->with('success', 'Gemstone created successfully!');
    }

    public function edit($id)
    {
        $gemstone = Gemstone::findOrFail($id);
        return view('master.gemstone.edit', compact('gemstone'));
    }

    public function update(Request $request, $id)
    {
        $gemstone = Gemstone::findOrFail($id);
        $request->validate([
            'gemstone_name' => 'required|max:50',
            'type' => 'required|in:diamond,ruby,sapphire,emerald,pearl,other',
            'color' => 'nullable|max:30',
            'clarity' => 'nullable|max:30',
            'cut_grade' => 'nullable|max:30',
            'default_carat_weight' => 'nullable|numeric',
            'gemstone_code' => 'nullable|max:50|unique:gemstones,gemstone_code,' . $id . ',gemstone_id',
            'shape' => 'nullable|max:50',
            'cut' => 'nullable|max:50',
            'measurement_length' => 'nullable|numeric',
            'measurement_width' => 'nullable|numeric',
            'measurement_depth' => 'nullable|numeric',
            'treatment' => 'nullable|max:100',
            'origin' => 'nullable|max:100',
            'fluorescence' => 'nullable|max:50',
            'symmetry' => 'nullable|max:50',
            'polish' => 'nullable|max:50',
            'girdle' => 'nullable|max:50',
            'culet' => 'nullable|max:50',
            'table_percentage' => 'nullable|numeric',
            'depth_percentage' => 'nullable|numeric',
            'certification_lab' => 'nullable|max:100',
            'certification_number' => 'nullable|max:100',
            'certification_date' => 'nullable|date',
        ]);
        $gemstone->update($request->all());
        return redirect()->route('gemstones.index')->with('success', 'Gemstone updated successfully!');
    }

    public function show($id)
    {
        $gemstone = Gemstone::findOrFail($id);
        return view('master.gemstone.show', compact('gemstone'));
    }

    public function destroy($id)
    {
        $gemstone = Gemstone::findOrFail($id);
        $gemstone->delete();
        return redirect()->route('gemstones.index')->with('danger', 'Gemstone deleted successfully!');
    }
}

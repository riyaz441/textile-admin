<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Measurement;
use Illuminate\Http\Request;

class MeasurementMasterController extends Controller
{
    /**
     * Display a listing of the measurements.
     */
    public function index()
    {
        $data['measurements'] = Measurement::orderBy('measurement_id', 'DESC')->get();
        return view('master/measurement/index', $data);
    }

    /**
     * Show the form for creating or editing a measurement.
     */
    public function form($id = null)
    {
        $data = [];
        if ($id) {
            $data['measurement'] = Measurement::findOrFail($id);
        }
        return view('master/measurement/form', $data);
    }

    /**
     * Store or update measurement.
     */
    public function save(Request $request, $id = null)
    {
        $measurement = $id
            ? Measurement::findOrFail($id)
            : new Measurement();

        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'min:2',
                    'max:45',
                ],
                'UOM' => [
                    'required',
                    'string',
                    'max:45',
                ],
                'status' => [
                    'required',
                    'in:Active,Inactive',
                ],
            ],
            [
                'name.required' => 'Measurement name is required',
                'name.min' => 'Measurement name must be at least 2 characters',
                'name.max' => 'Measurement name must not exceed 45 characters',
                'UOM.required' => 'UOM is required',
                'UOM.max' => 'UOM must not exceed 45 characters',
                'status.required' => 'Status is required',
            ]
        );

        $measurement->fill($request->only(['name', 'UOM', 'status']));
        $measurement->save();

        return redirect('measurements')->with(
            'success',
            $id ? 'Measurement updated successfully!' : 'Measurement created successfully!'
        );
    }

    /**
     * Display the specified measurement.
     */
    public function show($id)
    {
        $data['measurement'] = Measurement::findOrFail($id);
        return view('master/measurement/show', $data);
    }

    /**
     * Remove the specified measurement from storage.
     */
    public function delete($id)
    {
        $measurement = Measurement::findOrFail($id);
        $measurement->delete();

        return redirect('measurements')->with('danger', 'Measurement deleted successfully!');
    }

    /**
     * Change the status of a measurement.
     */
    public function changeStatus(Request $request)
    {
        $measurement = Measurement::findOrFail($request->id);
        $measurement->status = $request->status;
        $measurement->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }
}

<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\CompanyMaster;
use App\Models\LocationMaster;
use App\Models\BranchMaster; // ✅ ADDED
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocationMasterController extends Controller
{
    public function index()
    {
        $data['locations'] = LocationMaster::with(['company', 'parent'])
            ->orderBy('location_id', 'DESC')
            ->get();

        return view('master/location/index', $data);
    }

    public function form($id = null)
    {
        $data = [];
        $data['companies'] = CompanyMaster::where('status', 'Active')->get();
        $data['branches'] = BranchMaster::where('status', 'Active')->get(); // ✅ ADDED

        $data['parentLocations'] = LocationMaster::orderBy('location_name')
            ->when($id, function ($query) use ($id) {
                $query->where('location_id', '!=', $id);
            })
            ->get();

        if ($id) {
            $data['location'] = LocationMaster::findOrFail($id);
        }

        return view('master/location/form', $data);
    }

    public function save(Request $request, $id = null)
    {
        $location = $id
            ? LocationMaster::findOrFail($id)
            : new LocationMaster();

        $request->validate(
            [
                'branch_id' => [ // ✅ ADDED
                    'required',
                    'exists:branches,branch_id',
                ],
                'company_id' => [
                    'required',
                    'exists:companies,company_id',
                ],
                'location_code' => [
                    'required',
                    'min:2',
                    'max:50',
                    'regex:/^[A-Z0-9-]+$/i',
                    Rule::unique('locations', 'location_code')->ignore($id, 'location_id'),
                ],
                'location_name' => [
                    'required',
                    'min:3',
                    'max:100',
                    'regex:/^(?=.*[a-zA-Z])(?!.*<script>)[a-zA-Z0-9\s!@#$%^&*()_+{}\[\]:;"\'<>.,?\/\\\\|-]+$/i',
                ],
                'location_type' => [
                    'required',
                    Rule::in(['store', 'warehouse', 'display_case', 'safe', 'vault', 'counter', 'workshop', 'qc_area', 'quarantine']),
                ],
                'parent_location_id' => [
                    'nullable',
                    'integer',
                    'exists:locations,location_id',
                ],
                'address' => 'nullable|string|max:500',
                'contact_person' => 'nullable|string|max:100',
                'phone' => 'nullable|string|max:20',
                'capacity' => 'nullable|integer|min:0',
                'temperature_controlled' => 'required|boolean',
                'humidity_controlled' => 'required|boolean',
                'security_level' => [
                    'required',
                    Rule::in(['low', 'medium', 'high', 'maximum']),
                ],
                'status' => [
                    'required',
                    Rule::in(['Active', 'Inactive']),
                ],
                'notes' => 'nullable|string',
            ]
        );

        $location->fill($request->all());
        $location->save();

        return redirect('locations')->with(
            'success',
            $id ? 'Location updated successfully!' : 'Location created successfully!'
        );
    }

    public function show($id)
    {
        $data['location'] = LocationMaster::with(['company', 'parent'])->findOrFail($id);
        return view('master/location/show', $data);
    }

    public function destroy($id)
    {
        $location = LocationMaster::findOrFail($id);
        $location->delete();

        return redirect('locations')->with('danger', 'Location deleted successfully!');
    }

    public function changeStatus(Request $request)
    {
        $location = LocationMaster::findOrFail($request->id);
        $location->status = $request->status;
        $location->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }
}
<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DoctorMasterController extends Controller
{
    public function index()
    {
        $data['doctors'] = Doctor::orderBy('doctor_id', 'DESC')->get();
        return view('master/doctor/index', $data);
    }

    public function form($id = null)
    {
        $data = [];
        if ($id) {
            $data['doctor'] = Doctor::findOrFail($id);
        }
        return view('master/doctor/form', $data);
    }

    public function save(Request $request, $id = null)
    {
        $doctor = $id
            ? Doctor::findOrFail($id)
            : new Doctor();

        $request->validate([
            'name' => [
                'required',
                'min:3',
                'max:255',
                'regex:/^(?=.*[a-zA-Z])(?!.*<script>)[a-zA-Z0-9\s!@#$%^&*()_+{}\[\]:;\"\'<>\,.?\/\\\\|-]+$/i',
            ],
            'mobile_no' => [
                'required',
                'regex:/^[0-9]{10,15}$/',
                Rule::unique('doctors', 'mobile_no')->ignore($id, 'doctor_id'),
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('doctors', 'email')->ignore($id, 'doctor_id'),
            ],
            'image' => $id ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Active,Inactive',
        ], [
            'mobile_no.regex' => 'Mobile number must be 10 to 15 digits only.',
            'mobile_no.unique' => 'This mobile number already exists.',
            'email.unique' => 'This email already exists.',
        ]);

        $priority = $request->has('priority');

        if ($priority) {
            $priorityCount = Doctor::where('priority', true)
                ->when($id, function ($query) use ($id) {
                    $query->where('doctor_id', '!=', $id);
                })
                ->count();

            if ($priorityCount >= 4) {
                return back()->withInput()->withErrors([
                    'priority' => 'Only 4 doctors can be marked as priority at the same time.',
                ]);
            }
        }

        $doctorData = $request->except('priority');
        $doctorData['priority'] = $priority;

        if ($request->hasFile('image')) {
            if ($doctor->image && file_exists(public_path($doctor->image))) {
                unlink(public_path($doctor->image));
            }

            $file = $request->file('image');
            $filename = time() . '_doctor.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/doctors'), $filename);
            $doctorData['image'] = 'assets/doctors/' . $filename;
        }

        $doctor->fill($doctorData);
        $doctor->save();

        return redirect('doctors')->with('success', $id ? 'Doctor updated successfully!' : 'Doctor created successfully!');
    }

    public function show($id)
    {
        $data['doctor'] = Doctor::findOrFail($id);
        return view('master/doctor/show', $data);
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);

        if ($doctor->image && file_exists(public_path($doctor->image))) {
            unlink(public_path($doctor->image));
        }

        $doctor->delete();

        return redirect('doctors')->with('danger', 'Doctor deleted successfully!');
    }

    public function changeStatus(Request $request)
    {
        $doctor = Doctor::findOrFail($request->id);
        $doctor->status = $request->status;
        $doctor->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }
}

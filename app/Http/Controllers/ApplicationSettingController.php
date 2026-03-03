<?php

namespace App\Http\Controllers;

use App\Models\ApplicationSetting;
use App\Models\CompanyMaster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApplicationSettingController extends Controller
{
    /**
     * Display a listing of the settings.
     */
    public function index()
    {
        $data['settings'] = ApplicationSetting::with(['company', 'branch'])
            ->orderBy('setting_id', 'DESC')
            ->get();
        return view('application_settings/index', $data);
    }

    /**
     * Show the form for creating or editing a setting.
     */
    public function form($id = null)
    {
        $data = [];
        $data['companies'] = CompanyMaster::where('status', 'Active')->get();
        if ($id) {
            $data['setting'] = ApplicationSetting::findOrFail($id);
        }
        return view('application_settings/form', $data);
    }

    /**
     * Store or update setting.
     */
    public function save(Request $request, $id = null)
    {
        $setting = $id
            ? ApplicationSetting::findOrFail($id)
            : new ApplicationSetting();

        $rules = [
            'company_id' => [
                'nullable',
                'exists:companies,company_id',
                'required_with:branch_id',
            ],
            'branch_id' => [
                'nullable',
            ],
            'setting_key' => [
                'required',
                'max:100',
                'regex:/^[A-Za-z0-9_.-]+$/',
                Rule::unique('settings', 'setting_key')->ignore($id, 'setting_id'),
            ],
            'setting_type' => ['required', Rule::in(['string', 'number', 'boolean', 'json'])],
            'setting_value' => ['nullable'],
            'category' => ['nullable', 'max:50'],
            'description' => ['nullable', 'max:1000'],
        ];

        if ($request->filled('branch_id')) {
            $branchRule = Rule::exists('branches', 'branch_id');
            if ($request->filled('company_id')) {
                $branchRule->where(fn ($query) => $query->where('company_id', $request->company_id));
            }
            $rules['branch_id'][] = $branchRule;
        }

        if ($request->setting_type === 'number') {
            $rules['setting_value'][] = 'numeric';
        } elseif ($request->setting_type === 'boolean') {
            $rules['setting_value'][] = 'boolean';
        } elseif ($request->setting_type === 'json') {
            $rules['setting_value'][] = 'json';
        } else {
            $rules['setting_value'][] = 'string';
        }

        $messages = [
            'company_id.required_with' => 'Company is required when branch is selected',
            'company_id.exists' => 'Selected company does not exist',
            'branch_id.exists' => 'Selected branch does not exist for the selected company',
            'setting_key.required' => 'Setting key is required',
            'setting_key.max' => 'Setting key must not exceed 100 characters',
            'setting_key.regex' => 'Setting key can contain letters, numbers, dots, hyphens, and underscores only',
            'setting_key.unique' => 'This setting key already exists',
            'setting_type.required' => 'Setting type is required',
            'setting_value.numeric' => 'Setting value must be a valid number',
            'setting_value.boolean' => 'Setting value must be true/false or 1/0',
            'setting_value.json' => 'Setting value must be valid JSON',
            'category.max' => 'Category must not exceed 50 characters',
            'description.max' => 'Description must not exceed 1000 characters',
        ];

        $request->validate($rules, $messages);

        $setting->fill([
            'company_id' => $request->company_id,
            'branch_id' => $request->company_id ? $request->branch_id : null,
            'setting_key' => $request->setting_key,
            'setting_value' => $request->setting_value,
            'setting_type' => $request->setting_type,
            'category' => $request->category,
            'description' => $request->description,
        ]);
        $setting->save();

        return redirect('application-settings')->with(
            'success',
            $id ? 'Setting updated successfully!' : 'Setting created successfully!'
        );
    }

    /**
     * Display the specified setting.
     */
    public function show($id)
    {
        $data['setting'] = ApplicationSetting::with(['company', 'branch'])->findOrFail($id);
        return view('application_settings/show', $data);
    }

    /**
     * Remove the specified setting from storage.
     */
    public function destroy($id)
    {
        $setting = ApplicationSetting::findOrFail($id);
        $setting->delete();

        return redirect('application-settings')->with('danger', 'Setting deleted successfully!');
    }
}

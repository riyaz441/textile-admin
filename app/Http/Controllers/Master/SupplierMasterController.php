<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SupplierMaster;
use App\Models\CompanyMaster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierMasterController extends Controller
{
    /**
     * Display a listing of the suppliers.
     */
    public function index()
    {
        $data['suppliers'] = SupplierMaster::orderBy('supplier_id', 'DESC')->get();
        return view('master/supplier/index', $data);
    }

    /**
     * Show the form for creating or editing a supplier.
     */
    public function form($id = null)
    {
        $data = [];
        $data['companies'] = CompanyMaster::where('status', 'Active')->orderBy('company_name')->get();
        if ($id) {
            $data['supplier'] = SupplierMaster::findOrFail($id);
        }
        return view('master/supplier/form', $data);
    }

    /**
     * Store or update supplier
     */
    public function save(Request $request, $id = null)
    {
        $supplier = $id
            ? SupplierMaster::findOrFail($id)
            : new SupplierMaster();

        $request->validate(
            [
                'supplier_code' => [
                    'required',
                    'min:2',
                    'max:20',
                    'regex:/^[A-Z0-9-]+$/i',
                    Rule::unique('suppliers')->ignore($id, 'supplier_id'),
                    // 'unique:suppliers,supplier_code,' . ($id ?? 'NULL') . ',supplier_id',
                ],
                'company_id' => [
                    'required',
                    'exists:companies,company_id',
                ],
                'contact_person' => 'nullable|string|max:100',
                'email' => 'nullable|email|max:100',
                'phone' => 'nullable|string|max:20',
                'mobile' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'city' => 'nullable|string|max:50',
                'state' => 'nullable|string|max:50',
                'country' => 'nullable|string|max:50',
                'tax_id' => 'nullable|string|max:50',
                'payment_terms' => 'nullable|string|max:100',
                'bank_details' => 'nullable|string|max:1000',
                'rating' => 'nullable|numeric|min:0|max:5',
                'notes' => 'nullable|string|max:1000',
                'status' => 'required|in:Active,Inactive',
            ],
            [
                'supplier_code.required' => 'Supplier code is required',
                'supplier_code.min' => 'Supplier code must be at least 2 characters',
                'supplier_code.max' => 'Supplier code must not exceed 20 characters',
                'supplier_code.regex' => 'Supplier code must contain only letters, numbers, and hyphens',
                'supplier_code.unique' => 'This supplier code already exists',

                'company_id.required' => 'Company is required',
                'company_id.exists' => 'Selected company does not exist',

                'contact_person.max' => 'Contact person must not exceed 100 characters',
                'email.email' => 'Please enter a valid email address',
                'email.max' => 'Email must not exceed 100 characters',
                'phone.max' => 'Phone must not exceed 20 characters',
                'mobile.max' => 'Mobile must not exceed 20 characters',
                'address.max' => 'Address must not exceed 500 characters',
                'city.max' => 'City must not exceed 50 characters',
                'state.max' => 'State must not exceed 50 characters',
                'country.max' => 'Country must not exceed 50 characters',
                'tax_id.max' => 'Tax ID must not exceed 50 characters',
                'payment_terms.max' => 'Payment terms must not exceed 100 characters',
                'bank_details.max' => 'Bank details must not exceed 1000 characters',
                'rating.numeric' => 'Rating must be a number',
                'rating.max' => 'Rating must not exceed 5',
                'notes.max' => 'Notes must not exceed 1000 characters',
                'status.required' => 'Status is required',
            ]
        );

        $supplier->fill($request->except('company_name'));
        if ($request->filled('rating')) {
            $supplier->rating = $request->rating;
        } else {
            $supplier->rating = 0;
        }
        $supplier->save();

        return redirect('suppliers')->with(
            'success',
            $id ? 'Supplier updated successfully!' : 'Supplier created successfully!'
        );
    }

    /**
     * Display the specified supplier.
     */
    public function show($id)
    {
        $data['supplier'] = SupplierMaster::findOrFail($id);
        return view('master/supplier/show', $data);
    }

    /**
     * Remove the specified supplier from storage.
     */
    public function destroy($id)
    {
        $supplier = SupplierMaster::findOrFail($id);
        $supplier->delete();

        return redirect('suppliers')->with('danger', 'Supplier deleted successfully!');
    }

    /**
     * Change the status of a supplier.
     */
    public function changeStatus(Request $request)
    {
        $supplier = SupplierMaster::findOrFail($request->id);
        $supplier->status = $request->status;
        $supplier->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }
}

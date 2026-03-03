<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\CompanyMaster;
use App\Models\ProductCategoryMaster;
use Illuminate\Http\Request;

class ProductCategoryMasterController extends Controller
{
    /**
     * Display all categories
     */
    public function index()
    {
        $data['categories'] = ProductCategoryMaster::with(['parentCategory', 'company'])
            ->orderBy('category_id', 'desc')
            ->get();
        return view('master/product_category/index', $data);
    }

    /**
     * Show the form for creating or editing a product category.
     */
    public function form($id = null)
    {
        $data = [];
        $data['companies'] = CompanyMaster::where('status', 'Active')->orderBy('company_name')->get();
        if ($id) {
            $data['category'] = ProductCategoryMaster::findOrFail($id);
        }
        $data['parentCategories'] = ProductCategoryMaster::when($id, function ($query) use ($id) {
            return $query->where('category_id', '!=', $id);
        })
            ->orderBy('category_name')
            ->get();
        return view('master/product_category/form', $data);
    }

    /**
     * Store or update product category
     */
    public function save(Request $request, $id = null)
    {
        $category = $id
            ? ProductCategoryMaster::findOrFail($id)
            : new ProductCategoryMaster();

        $request->validate(
            [
                'company_id' => [
                    'required',
                    'exists:companies,company_id',
                ],
                'category_name' => [
                    'required',
                    'string',
                    'max:100',
                    'regex:/^[A-Za-z. ]+$/',
                    'unique:categories,category_name,' . ($id ?? 'NULL') . ',category_id',
                ],
                'category_code' => [
                    'required',
                    'string',
                    'max:20',
                    'unique:categories,category_code,' . ($id ?? 'NULL') . ',category_id',
                ],
                'description' => 'nullable|string',
                'parent_category_id' => 'nullable|integer',
                'status' => 'required|in:Active,Inactive',
            ],
            [
                'company_id.required' => 'Company is required',
                'company_id.exists' => 'Selected company does not exist',
                'category_name.required' => 'Category name is required',
                'category_name.unique' => 'This category name already exists',
                'category_code.required' => 'Category code is required',
                'category_code.unique' => 'This category code already exists',
                'status.required' => 'Status is required',
            ]
        );

        $category->fill($request->all());
        $category->parent_category_id = $request->parent_category_id ?? 0;
        $category->save();

        return redirect('product-categories')->with(
            'success',
            $id ? 'Product category updated successfully!' : 'Product category created successfully!'
        );
    }

    /**
     * Display the specified material.
     */
    public function show($id)
    {
        $data['category'] = ProductCategoryMaster::with(['parentCategory', 'company'])->findOrFail($id);
        return view('master/product_category/show', $data);
    }

    /**
     * Delete category
     */
    public function destroy($id)
    {
        ProductCategoryMaster::findOrFail($id)->delete();

        return redirect('product-categories')->with('danger', 'Product category deleted successfully!');
    }

    /**
     * Change the status of a product category.
     */
    public function changeStatus(Request $request)
    {
        $category = ProductCategoryMaster::findOrFail($request->id);
        $category->status = $request->status;
        $category->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }
}

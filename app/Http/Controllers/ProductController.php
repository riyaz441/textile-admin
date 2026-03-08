<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $data['products'] = Product::orderBy('id', 'DESC')->get();
        return view('product/index', $data);
    }

    /**
     * Show the form for creating or editing a product.
     */
    public function form($id = null)
    {
        $data = [];
        if ($id) {
            $data['product'] = Product::findOrFail($id);
        }
        return view('product/form', $data);
    }

    /**
     * Store or update product
     */
    public function save(Request $request, $id = null)
    {
        $product = $id
            ? Product::findOrFail($id)
            : new Product();

        // Normalize slug input (spaces/special chars -> hyphens) before validation.
        $request->merge([
            'slug' => Str::slug($request->input('slug', $request->input('name', ''))),
        ]);

        // Build validation rules dynamically
        // Main image is required for new products, nullable for updates
        $imageRule = $id ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048';

        $request->validate(
            [
                'name' => [
                    'required',
                    'min:3',
                    'max:255',
                    'regex:/^(?!.*<script>)[a-zA-Z0-9\s!@#$%^&*()_+{}\[\]:;\"\'<>,.?\/\\\\|-]+$/i',
                ],
                'sku' => [
                    'required',
                    'min:2',
                    'max:100',
                    'regex:/^[A-Z0-9-]+$/i',
                    Rule::unique('products', 'sku')->ignore($id, 'id'),
                ],
                'slug' => [
                    'required',
                    'min:3',
                    'max:255',
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                    Rule::unique('products', 'slug')->ignore($id, 'id'),
                ],
                'category' => 'required|in:male,female,kids',
                'description' => 'required|min:10|max:2000',
                'short_description' => 'nullable|max:500',
                'price' => 'required|numeric|min:0|max:999999.99',
                'cost_price' => 'nullable|numeric|min:0|max:999999.99',
                'discount_percentage' => 'nullable|numeric|min:0|max:100',
                'image' => $imageRule,
                'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'stock_quantity' => 'required|numeric|min:0|max:999999',
                'min_stock_level' => 'nullable|numeric|min:0|max:999999',
                'rating' => 'nullable|numeric|min:0|max:5',
                'status' => 'required|in:Active,Inactive',
            ],
            [
                'name.required' => 'Product name is required',
                'name.min' => 'Product name must be at least 3 characters',
                'name.max' => 'Product name must not exceed 255 characters',
                'name.regex' => 'Product name contains invalid characters',

                'sku.required' => 'SKU is required',
                'sku.min' => 'SKU must be at least 2 characters',
                'sku.max' => 'SKU must not exceed 100 characters',
                'sku.regex' => 'SKU must contain only letters, numbers, and hyphens',
                'sku.unique' => 'This SKU already exists',

                'slug.required' => 'Slug is required',
                'slug.min' => 'Slug must be at least 3 characters',
                'slug.max' => 'Slug must not exceed 255 characters',
                'slug.regex' => 'Slug must contain only lowercase letters, numbers, and hyphens',
                'slug.unique' => 'This slug already exists',

                'category.required' => 'Category is required',
                'category.in' => 'Category must be one of: male, female, or kids',

                'description.required' => 'Description is required',
                'description.min' => 'Description must be at least 10 characters',
                'description.max' => 'Description must not exceed 2000 characters',

                'short_description.max' => 'Short description must not exceed 500 characters',

                'price.required' => 'Price is required',
                'price.numeric' => 'Price must be a valid number',
                'price.min' => 'Price must be at least 0',
                'price.max' => 'Price is too high',

                'cost_price.numeric' => 'Cost price must be a valid number',
                'stock_quantity.required' => 'Stock quantity is required',
                'stock_quantity.numeric' => 'Stock quantity must be a valid number',

                'discount_percentage.numeric' => 'Discount percentage must be a valid number',
                'discount_percentage.max' => 'Discount percentage cannot exceed 100%',

                'rating.numeric' => 'Rating must be a valid number',
                'rating.max' => 'Rating cannot exceed 5',

                'image.required' => 'Main image is required for new products',
                'image.image' => 'Main image must be a valid image file',
                'image.mimes' => 'Main image must be in jpeg, png, jpg, or gif format',
                'image.max' => 'Main image size must not exceed 2MB',

                'status.required' => 'Status is required',
            ]
        );

        $productData = $request->all();

        // Handle image uploads
        $imageFields = ['image', 'image_1', 'image_2', 'image_3'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/products'), $filename);
                $productData[$field] = 'assets/products/' . $filename;
            }
        }

        $product->fill($productData);
        $product->save();

        return redirect()->route('products.index')->with(
            'success',
            $id ? 'Product updated successfully!' : 'Product created successfully!'
        );
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $data['product'] = Product::findOrFail($id);
        return view('product/show', $data);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete associated images
        $imageFields = ['image', 'image_1', 'image_2', 'image_3'];
        foreach ($imageFields as $field) {
            if ($product->$field && file_exists(public_path($product->$field))) {
                unlink(public_path($product->$field));
            }
        }

        $product->delete();

        return redirect()->route('products.index')->with('danger', 'Product deleted successfully!');
    }

    /**
     * Change the status of a product.
     */
    public function changeStatus(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->status = $request->status;
        $product->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }
}

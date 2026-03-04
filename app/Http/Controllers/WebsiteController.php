<?php

namespace App\Http\Controllers;

use App\Models\Product;

class WebsiteController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'Active')->orderByDesc('id')->get();

        return view('website.index', [
            'productsByCategory' => [
                'male' => $products->where('category', 'male')->values(),
                'female' => $products->where('category', 'female')->values(),
                'kids' => $products->where('category', 'kids')->values(),
            ],
            'featuredProductId' => optional($products->first())->id,
        ]);
    }

    public function products()
    {
        $products = Product::where('status', 'Active')->orderByDesc('id')->get();

        return view('website.products', [
            'products' => $products,
            'featuredProductId' => optional($products->first())->id,
        ]);
    }

    public function singleProduct($id = null)
    {
        if (!$id) {
            return redirect()->route('products');
        }

        $product = Product::where('status', 'Active')->findOrFail($id);

        return view('website.single-product', [
            'product' => $product,
            'featuredProductId' => $product->id,
            'relatedProducts' => Product::where('status', 'Active')
                ->where('category', $product->category)
                ->where('id', '!=', $product->id)
                ->orderByDesc('id')
                ->limit(4)
                ->get(),
        ]);
    }
}

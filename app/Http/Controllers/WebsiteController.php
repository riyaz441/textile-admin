<?php

namespace App\Http\Controllers;

use App\Models\Product;

class WebsiteController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'Active')->orderByDesc('id')->get();
        $maleProducts = $products->where('category', 'male')->values();
        $femaleProducts = $products->where('category', 'female')->values();

        return view('website.index', [
            'recentProducts' => $products->take(6),
            'popularProducts' => ($femaleProducts->isNotEmpty() ? $femaleProducts : $products)->take(6),
            'bestSellingProducts' => ($maleProducts->isNotEmpty() ? $maleProducts : $products)->take(6),
        ]);
    }

    public function products()
    {
        return view('website.products', [
            'products' => Product::where('status', 'Active')->orderByDesc('id')->get(),
        ]);
    }

    public function productDetails($slug)
    {
        $product = Product::where('status', 'Active')
            ->where('slug', $slug)
            ->firstOrFail();
        $productImages = collect([
            $product->image,
            $product->image_1,
            $product->image_2,
            $product->image_3,
        ])->filter()->values();

        return view('website.product_details', [
            'product' => $product,
            'productImages' => $productImages,
            'relatedProducts' => Product::where('status', 'Active')
                ->where('category', $product->category)
                ->where('id', '!=', $product->id)
                ->orderByDesc('id')
                ->limit(8)
                ->get(),
        ]);
    }
}

<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Links of CSS files -->
    @include('website.layout.style')

    <title>Products - Textile eCommerce</title>
    <link rel="icon" type="image/png" href="{{ asset('website/assets/img/favicon.png') }}">
</head>

<body>
    @include('website.layout.header')

    <!-- Start Page Title -->
    <div class="page-title-area">
        <div class="container">
            <div class="page-title-content">
                <h2>
                    {{ $selectedCategory ? ucfirst($selectedCategory) . " Products" : 'Products' }}
                </h2>
                <ul>
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>{{ $selectedCategory ? ucfirst($selectedCategory) . " Products" : 'Products' }}</li>
                </ul>
            </div>
        </div>
    </div>

    @if ($products->isNotEmpty())
        <!-- Start Products Area -->
        <section class="products-area pt-100 pb-70">
            <div class="container">
                <div id="products-collections-filter" class="row">
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6 products-col-item">
                            <div class="products-box">
                                <div class="products-image">
                                    <a href="{{ route('website.products.show', $product->slug) }}">
                                        <img src="{{ asset($product->image) }}" class="main-image" alt="{{ $product->name }}">
                                        <img src="{{ asset($product->image_1 ?: $product->image) }}" class="hover-image" alt="{{ $product->name }}">
                                    </a>

                                    <div class="products-button">
                                        <ul>
                                            <li>
                                                <div class="wishlist-btn">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#shoppingWishlistModal">
                                                        <i class='bx bx-heart'></i>
                                                        <span class="tooltip-label">Add to Wishlist</span>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="compare-btn">
                                                    <a href="#">
                                                        <i class='bx bx-refresh'></i>
                                                        <span class="tooltip-label">Compare</span>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="quick-view-btn">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#productsQuickView">
                                                        <i class='bx bx-search-alt'></i>
                                                        <span class="tooltip-label">Quick View</span>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    @if ($loop->first)
                                        <div class="new-tag">New!</div>
                                    @endif
                                </div>

                                <div class="products-content">
                                    <span class="category">{{ ucfirst($product->category) }}</span>
                                    <h3><a href="{{ route('website.products.show', $product->slug) }}">{{ $product->name }}</a></h3>
                                    <div class="star-rating">
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                    </div>
                                    <div class="price">
                                        @if ($product->discount_percentage > 0 && $product->cost_price)
                                            <span class="old-price">${{ number_format($product->cost_price, 2) }}</span>
                                        @endif
                                        <span class="new-price">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                    <a href="#" class="add-to-cart">Add to Cart</a>
                                </div>

                                @if ($product->discount_percentage > 0)
                                    <span class="products-discount">
                                        <span>{{ rtrim(rtrim(number_format($product->discount_percentage, 2), '0'), '.') }}% OFF</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <div class="container my-5">
            <div class="alert alert-info text-center" role="alert">
                No products available in this category at the moment. Please check back later.
            </div>
        </div>
    @endif

    <section class="facility-area pb-70">
        <div class="container">
            <div class="facility-slides owl-carousel owl-theme">
                <div class="single-facility-box">
                    <div class="icon">
                        <i class='flaticon-tracking'></i>
                    </div>
                    <h3>Free Shipping Worldwide</h3>
                </div>

                <div class="single-facility-box">
                    <div class="icon">
                        <i class='flaticon-return'></i>
                    </div>
                    <h3>Easy Return Policy</h3>
                </div>

                <div class="single-facility-box">
                    <div class="icon">
                        <i class='flaticon-shuffle'></i>
                    </div>
                    <h3>7 Day Exchange Policy</h3>
                </div>

                <div class="single-facility-box">
                    <div class="icon">
                        <i class='flaticon-sale'></i>
                    </div>
                    <h3>Weekend Discount Coupon</h3>
                </div>

                <div class="single-facility-box">
                    <div class="icon">
                        <i class='flaticon-credit-card'></i>
                    </div>
                    <h3>Secure Payment Methods</h3>
                </div>

                <div class="single-facility-box">
                    <div class="icon">
                        <i class='flaticon-location'></i>
                    </div>
                    <h3>Track Your Package</h3>
                </div>

                <div class="single-facility-box">
                    <div class="icon">
                        <i class='flaticon-customer-service'></i>
                    </div>
                    <h3>24/7 Customer Support</h3>
                </div>
            </div>
        </div>
    </section>

    @include('website.layout.footer')

    <div class="go-top"><i class='bx bx-up-arrow-alt'></i></div>

    <!-- Links of JS files -->
    @include('website.layout.script')

</body>

</html>

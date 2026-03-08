<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Links of CSS files -->
    @include('website.layout.style')

    <title>Textile</title>

    <link rel="icon" type="image/png" href="{{ asset('website/assets/img/favicon.png') }}">
</head>

<body>

    @include('website.layout.header')

    <!-- Start Search Overlay -->
    <div class="search-overlay">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="search-overlay-layer"></div>
                <div class="search-overlay-layer"></div>
                <div class="search-overlay-layer"></div>

                <div class="search-overlay-close">
                    <span class="search-overlay-close-line"></span>
                    <span class="search-overlay-close-line"></span>
                </div>

                <div class="search-overlay-form">
                    <form>
                        <input type="text" class="input-search" placeholder="Search here...">
                        <button type="submit"><i class='bx bx-search-alt'></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Search Overlay -->

    <!-- Start Main Banner Area -->
    <div class="home-slides-two owl-carousel owl-theme">
        <div class="main-banner banner-bg2">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-md-12">
                                <div class="banner-content text-white">
                                    <div class="line"></div>
                                    <span class="sub-title">Trending Women's Collection</span>
                                    <h1>New Inspiration 2024</h1>
                                    <p>Click here to shop in your local currency. We ship over 2 million products around
                                        the world!</p>
                                    <div class="btn-box">
                                        <a href="products-right-sidebar-2.html" class="default-btn">Shop Women's</a>
                                        <a href="products-right-sidebar-3.html" class="optional-btn">Shop Men's</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-banner banner-bg4">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-md-12">
                                <div class="banner-content text-white">
                                    <div class="line"></div>
                                    <span class="sub-title">Make Your Fashion Smarter</span>
                                    <h1>Clothing made for you!</h1>
                                    <p>Click here to shop in your local currency. We ship over 2 million products around
                                        the world!</p>
                                    <div class="btn-box">
                                        <a href="products-right-sidebar-2.html" class="default-btn">Shop Women's</a>
                                        <a href="products-right-sidebar-3.html" class="optional-btn">Shop Men's</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-banner banner-bg5">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-md-12">
                                <div class="banner-content text-white">
                                    <div class="line"></div>
                                    <span class="sub-title">Clothing Made For You!</span>
                                    <h1>Your Fashion Smarter</h1>
                                    <p>Click here to shop in your local currency. We ship over 2 million products around
                                        the world!</p>
                                    <div class="btn-box">
                                        <a href="products-right-sidebar-2.html" class="default-btn">Shop Women's</a>
                                        <a href="products-right-sidebar-3.html" class="optional-btn">Shop Men's</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Banner Area -->

    <!-- Start Categories Banner Area -->
    <section class="categories-banner-area pt-100 pb-70">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <div class="categories-box">
                        <img src="{{ asset('website/assets/img/categories/img5.jpg') }}" alt="image">

                        <div class="content">
                            <h3>New Collections!</h3>
                        </div>

                        <a href="products-left-sidebar.html" class="link-btn"></a>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="categories-box">
                                <img src="{{ asset('website/assets/img/categories/img6.jpg') }}" alt="image">

                                <div class="content">
                                    <h3>Our Popular Products</h3>
                                </div>

                                <a href="products-left-sidebar.html" class="link-btn"></a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="categories-box">
                                <img src="{{ asset('website/assets/img/categories/img7.jpg') }}" alt="image">

                                <div class="content">
                                    <h3>Hot Trending Products</h3>
                                </div>

                                <a href="products-left-sidebar.html" class="link-btn"></a>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="categories-box">
                                <img src="{{ asset('website/assets/img/categories/img8.jpg') }}" alt="image">

                                <div class="content">
                                    <h3>Winter Collections!</h3>
                                </div>

                                <a href="products-left-sidebar.html" class="link-btn"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Categories Banner Area -->

    @if (($recentProducts ?? collect())->isNotEmpty())
        <!-- Start Products Area -->
        <section class="products-area pb-70">
            <div class="container">
                <div class="section-title">
                    <span class="sub-title">See Our Collection</span>
                    <h2>Recent Products</h2>
                </div>

                <div class="row justify-content-center">
                    @foreach ($recentProducts as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6">
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
                                                    <a href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#productsQuickView"
                                                        data-product-name="{{ $product->name }}"
                                                        data-product-category="{{ ucfirst($product->category) }}"
                                                        data-product-price="{{ number_format($product->price, 2) }}"
                                                        data-product-old-price="{{ ($product->discount_percentage > 0 && $product->cost_price) ? number_format($product->cost_price, 2) : '' }}"
                                                        data-product-image="{{ asset($product->image) }}"
                                                        data-product-url="{{ route('website.products.show', $product->slug) }}"
                                                        data-product-stock="{{ $product->stock_quantity }}"
                                                        data-product-sku="{{ $product->sku }}">
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
        <!-- End Products Area -->
    @else
        <div class="container my-5">
            <div class="alert alert-info text-center" role="alert">
                No recent products available at the moment. Please check back later.
            </div>
        </div>
    @endif

    <!-- Start Offer Area -->
    <section class="offer-area bg-image2 ptb-100 jarallax" data-jarallax='{"speed": 0.3}'>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6 offset-lg-7 ">
                    <div class="offer-content-box">
                        <span class="sub-title">Limited Time Offer!</span>
                        <h2>-40% OFF</h2>
                        <p>Get The Best Deals Now</p>
                        <a href="products-right-sidebar.html" class="default-btn">Discover Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Offer Area -->

    @if (($popularProducts ?? collect())->isNotEmpty())
        <!-- Start Products Area -->
        <section class="products-area pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <span class="sub-title">See Our Collection</span>
                    <h2>Popular Products</h2>
                </div>

                <div class="row justify-content-center">
                    @foreach ($popularProducts as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6">
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
                                                    <a href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#productsQuickView"
                                                        data-product-name="{{ $product->name }}"
                                                        data-product-category="{{ ucfirst($product->category) }}"
                                                        data-product-price="{{ number_format($product->price, 2) }}"
                                                        data-product-old-price="{{ ($product->discount_percentage > 0 && $product->cost_price) ? number_format($product->cost_price, 2) : '' }}"
                                                        data-product-image="{{ asset($product->image) }}"
                                                        data-product-url="{{ route('website.products.show', $product->slug) }}"
                                                        data-product-stock="{{ $product->stock_quantity }}"
                                                        data-product-sku="{{ $product->sku }}">
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
        <!-- End Products Area -->
    @else
        <div class="container my-5">
            <div class="alert alert-info text-center" role="alert">
                No popular products available at the moment. Please check back later.
            </div>
        </div>
    @endif

    <!-- Start Facility Area -->
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
    <!-- End Facility Area -->

    @if (($bestSellingProducts ?? collect())->isNotEmpty())
        <!-- Start Products Area -->
        <section class="products-area pb-70">
            <div class="container">
                <div class="section-title">
                    <span class="sub-title">See Our Collection</span>
                    <h2>Best Selling Products</h2>
                </div>

                <div class="row justify-content-center">
                    @foreach ($bestSellingProducts as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6">
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
                                                    <a href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#productsQuickView"
                                                        data-product-name="{{ $product->name }}"
                                                        data-product-category="{{ ucfirst($product->category) }}"
                                                        data-product-price="{{ number_format($product->price, 2) }}"
                                                        data-product-old-price="{{ ($product->discount_percentage > 0 && $product->cost_price) ? number_format($product->cost_price, 2) : '' }}"
                                                        data-product-image="{{ asset($product->image) }}"
                                                        data-product-url="{{ route('website.products.show', $product->slug) }}"
                                                        data-product-stock="{{ $product->stock_quantity }}"
                                                        data-product-sku="{{ $product->sku }}">
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
        <!-- End Products Area -->
    @else
        <div class="container my-5">
            <div class="alert alert-info text-center" role="alert">
                No best selling products available at the moment. Please check back later.
            </div>
        </div>
    @endif

    <!-- Start Brand Area -->
    <div class="brand-area ptb-70">
        <div class="container">
            <div class="section-title">
                <h2>Shop By Brand</h2>
            </div>

            <div class="brand-slides owl-carousel owl-theme">
                <div class="brand-item">
                    <a href="#"><img src="{{ asset('website/assets/img/brand/tussarsaree.jpg') }}" alt="image">Tussar Saree</a>
                </div>

                <div class="brand-item">
                    <a href="#"><img src="{{ asset('website/assets/img/brand/tussarsaree.jpg') }}" alt="image">Linen Saree</a>
                </div>

                <div class="brand-item">
                    <a href="#"><img src="{{ asset('website/assets/img/brand/tussarsaree.jpg') }}" alt="image">Cotton Silk Saree</a>
                </div>

                <div class="brand-item">
                    <a href="#"><img src="{{ asset('website/assets/img/brand/tussarsaree.jpg') }}" alt="image">Matka Silk</a>
                </div>

                <div class="brand-item">
                    <a href="#"><img src="{{ asset('website/assets/img/brand/tussarsaree.jpg') }}" alt="image">Chenderi Saree</a>
                </div>

                <div class="brand-item">
                    <a href="#"><img src="{{ asset('website/assets/img/brand/tussarsaree.jpg') }}" alt="image">Khadi Silk</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Brand Area -->

    <!-- Start Blog Area -->
    <section class="blog-area pt-100 pb-70">
        <div class="container">
            <div class="section-title">
                <span class="sub-title">Recent Story</span>
                <h2>From The Xton Blog</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="single-blog-post">
                        <div class="post-image">
                            <a href="{{ route('blog.details') }}">
                                <img src="{{ asset('website/assets/img/blog/img1.jpg') }}" alt="image">
                            </a>
                            <div class="date">
                                <span>January 29, 2024</span>
                            </div>
                        </div>

                        <div class="post-content">
                            <span class="category">Ideas</span>
                            <h3><a href="{{ route('blog.details') }}">The #1 eCommerce blog to grow your business</a></h3>
                            <a href="{{ route('blog.details') }}" class="details-btn">Read Story</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-blog-post">
                        <div class="post-image">
                            <a href="{{ route('blog.details') }}">
                                <img src="{{ asset('website/assets/img/blog/img2.jpg') }}" alt="image">
                            </a>
                            <div class="date">
                                <span>January 29, 2024</span>
                            </div>
                        </div>

                        <div class="post-content">
                            <span class="category">Advice</span>
                            <h3><a href="{{ route('blog.details') }}">Latest ecommerce trend: The rise of shoppable posts</a>
                            </h3>
                            <a href="{{ route('blog.details') }}" class="details-btn">Read Story</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-blog-post">
                        <div class="post-image">
                            <a href="{{ route('blog.details') }}">
                                <img src="{{ asset('website/assets/img/blog/img3.jpg') }}" alt="image">
                            </a>
                            <div class="date">
                                <span>January 29, 2024</span>
                            </div>
                        </div>

                        <div class="post-content">
                            <span class="category">Social</span>
                            <h3><a href="{{ route('blog.details') }}">Building eCommerce wave: Social media shopping</a></h3>
                            <a href="{{ route('blog.details') }}" class="details-btn">Read Story</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Blog Area -->

    @include('website.layout.footer')

    <div class="go-top"><i class='bx bx-up-arrow-alt'></i></div>

    @include('website.layout.script')
</body>

</html>

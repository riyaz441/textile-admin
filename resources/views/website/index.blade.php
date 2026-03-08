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

    <!-- Start Products Area -->
    <section class="products-area pb-70">
        <div class="container">
            <div class="section-title">
                <span class="sub-title">See Our Collection</span>
                <h2>Recent Products</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img13.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover13.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="new-tag">New!</div>
                        </div>

                        <div class="products-content">
                            <span class="category">T-Shirt</span>
                            <h3><a href="products-type-2.html">Long Sleeve Leopard T-Shirt</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="old-price">$321</span>
                                <span class="new-price">$250</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>

                        <span class="products-discount">
                            <span>
                                20% OFF
                            </span>
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img14.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover14.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="products-content">
                            <span class="category">T-Shirt</span>
                            <h3><a href="products-type-2.html">Causal V-Neck Soft Raglan</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="old-price">$210</span>
                                <span class="new-price">$200</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img15.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover15.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="products-content">
                            <span class="category">Shirt</span>
                            <h3><a href="products-type-2.html">Hanes Men's Pullover</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="new-price">$200</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img16.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover16.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="sale-tag">Sale!</div>
                        </div>

                        <div class="products-content">
                            <span class="category">Twist Shirt</span>
                            <h3><a href="products-type-2.html">Gildan Men's Crew T-Shirt</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="new-price">$150</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img17.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover17.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="products-content">
                            <span class="category">Smart Shirt</span>
                            <h3><a href="products-type-2.html">Yidarton Women's Comfy</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="new-price">$240</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>

                        <span class="products-discount">
                            <span>
                                15% OFF
                            </span>
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img18.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover18.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="products-content">
                            <span class="category">EcoSmart</span>
                            <h3><a href="products-type-2.html">Womens Tops Color</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="old-price">$150</span>
                                <span class="new-price">$100</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Products Area -->

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

    <!-- Start Products Area -->
    <section class="products-area pt-100 pb-70">
        <div class="container">
            <div class="section-title">
                <span class="sub-title">See Our Collection</span>
                <h2>Popular Products</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img7.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover7.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="new-tag">New!</div>
                        </div>

                        <div class="products-content">
                            <span class="category">T-Shirt</span>
                            <h3><a href="products-type-2.html">Tbmpoy Men's Tapered</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="old-price">$321</span>
                                <span class="new-price">$250</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>

                        <span class="products-discount">
                            <span>
                                20% OFF
                            </span>
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img8.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover8.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="products-content">
                            <span class="category">T-Shirt</span>
                            <h3><a href="products-type-2.html">Sunnyme Women's Ponchos</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="old-price">$210</span>
                                <span class="new-price">$200</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img9.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover9.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="products-content">
                            <span class="category">Shirt</span>
                            <h3><a href="products-type-2.html">Open Front Knit Sweaters</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="old-price">$210</span>
                                <span class="new-price">$200</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img10.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover10.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="sale-tag">Sale!</div>
                        </div>

                        <div class="products-content">
                            <span class="category">Twist Shirt</span>
                            <h3><a href="products-type-2.html">Block Striped Draped</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="new-price">$150</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img11.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover11.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="products-content">
                            <span class="category">Smart Shirt</span>
                            <h3><a href="products-type-2.html">Fleece Hooded Sweatshirt</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="new-price">$240</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>

                        <span class="products-discount">
                            <span>
                                15% OFF
                            </span>
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img12.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover12.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="products-content">
                            <span class="category">EcoSmart</span>
                            <h3><a href="products-type-2.html">Women's Modern-Skinny</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="old-price">$150</span>
                                <span class="new-price">$100</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Products Area -->

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

    <!-- Start Products Area -->
    <section class="products-area pb-70">
        <div class="container">
            <div class="section-title">
                <span class="sub-title">See Our Collection</span>
                <h2>Best Selling Products</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img1.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover1.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="new-tag">New!</div>
                        </div>

                        <div class="products-content">
                            <span class="category">T-Shirt</span>
                            <h3><a href="products-type-2.html">Sleeve Faux Suede Loose</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="old-price">$321</span>
                                <span class="new-price">$250</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>

                        <span class="products-discount">
                            <span>
                                20% OFF
                            </span>
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img2.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover2.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="products-content">
                            <span class="category">T-Shirt</span>
                            <h3><a href="products-type-2.html">T-Shirt Casual Stripe Tunic</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="old-price">$210</span>
                                <span class="new-price">$200</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img3.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover3.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="products-content">
                            <span class="category">Shirt</span>
                            <h3><a href="products-type-2.html">Chest Cutout Tunics Long</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="old-price">$210</span>
                                <span class="new-price">$200</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img4.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover4.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="sale-tag">Sale!</div>
                        </div>

                        <div class="products-content">
                            <span class="category">Twist Shirt</span>
                            <h3><a href="products-type-2.html">Twist Knotted Tops</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="new-price">$150</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img5.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover5.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="products-content">
                            <span class="category">Smart Shirt</span>
                            <h3><a href="products-type-2.html">Premium Lightweight Fleece</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="new-price">$240</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>

                        <span class="products-discount">
                            <span>
                                15% OFF
                            </span>
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="products-type-2.html">
                                <img src="{{ asset('website/assets/img/products/img6.jpg') }}" class="main-image" alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover6.jpg') }}" class="hover-image" alt="image">
                            </a>

                            <div class="products-button">
                                <ul>
                                    <li>
                                        <div class="wishlist-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#shoppingWishlistModal">
                                                <i class='bx bx-heart'></i>
                                                <span class="tooltip-label">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="compare-btn">
                                            <a href="compare.html">
                                                <i class='bx bx-refresh'></i>
                                                <span class="tooltip-label">Compare</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="quick-view-btn">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#productsQuickView">
                                                <i class='bx bx-search-alt'></i>
                                                <span class="tooltip-label">Quick View</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="products-content">
                            <span class="category">EcoSmart</span>
                            <h3><a href="products-type-2.html">EcoSmart Fleece Hoodie</a></h3>
                            <div class="star-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                            <div class="price">
                                <span class="old-price">$150</span>
                                <span class="new-price">$100</span>
                            </div>
                            <a href="cart.html" class="add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Products Area -->

    <!-- Start Brand Area -->
    <div class="brand-area ptb-70">
        <div class="container">
            <div class="section-title">
                <h2>Shop By Brand</h2>
            </div>

            <div class="brand-slides owl-carousel owl-theme">
                <div class="brand-item">
                    <a href="#"><img src="{{ asset('website/assets/img/brand/img1.png') }}" alt="image"></a>
                </div>

                <div class="brand-item">
                    <a href="#"><img src="{{ asset('website/assets/img/brand/img2.png') }}" alt="image"></a>
                </div>

                <div class="brand-item">
                    <a href="#"><img src="{{ asset('website/assets/img/brand/img3.png') }}" alt="image"></a>
                </div>

                <div class="brand-item">
                    <a href="#"><img src="{{ asset('website/assets/img/brand/img4.png') }}" alt="image"></a>
                </div>

                <div class="brand-item">
                    <a href="#"><img src="{{ asset('website/assets/img/brand/img5.png') }}" alt="image"></a>
                </div>

                <div class="brand-item">
                    <a href="#"><img src="{{ asset('website/assets/img/brand/img6.png') }}" alt="image"></a>
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
                            <a href="single-blog-2.html">
                                <img src="{{ asset('website/assets/img/blog/img1.jpg') }}" alt="image">
                            </a>
                            <div class="date">
                                <span>January 29, 2024</span>
                            </div>
                        </div>

                        <div class="post-content">
                            <span class="category">Ideas</span>
                            <h3><a href="single-blog-2.html">The #1 eCommerce blog to grow your business</a></h3>
                            <a href="single-blog-2.html" class="details-btn">Read Story</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-blog-post">
                        <div class="post-image">
                            <a href="single-blog-2.html">
                                <img src="{{ asset('website/assets/img/blog/img2.jpg') }}" alt="image">
                            </a>
                            <div class="date">
                                <span>January 29, 2024</span>
                            </div>
                        </div>

                        <div class="post-content">
                            <span class="category">Advice</span>
                            <h3><a href="single-blog-2.html">Latest ecommerce trend: The rise of shoppable posts</a>
                            </h3>
                            <a href="single-blog-2.html" class="details-btn">Read Story</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-blog-post">
                        <div class="post-image">
                            <a href="single-blog-2.html">
                                <img src="{{ asset('website/assets/img/blog/img3.jpg') }}" alt="image">
                            </a>
                            <div class="date">
                                <span>January 29, 2024</span>
                            </div>
                        </div>

                        <div class="post-content">
                            <span class="category">Social</span>
                            <h3><a href="single-blog-2.html">Building eCommerce wave: Social media shopping</a></h3>
                            <a href="single-blog-2.html" class="details-btn">Read Story</a>
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

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
                <h2>Products</h2>
                <ul>
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>Products</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Start Products Area -->
    <section class="products-area pt-100 pb-70">
        <div class="container">
            <div id="products-collections-filter" class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 products-col-item">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="#">
                                <img src="{{ asset('website/assets/img/products/img13.jpg') }}" class="main-image"
                                    alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover13.jpg') }}"
                                    class="hover-image" alt="image">
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
                                            <a href="compare.html">
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

                            <div class="new-tag">New!</div>
                        </div>

                        <div class="products-content">
                            <span class="category">T-Shirt</span>
                            <h3><a href="#">Long Sleeve Leopard T-Shirt</a></h3>
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

                <div class="col-lg-4 col-md-6 col-sm-6 products-col-item">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="#">
                                <img src="{{ asset('website/assets/img/products/img14.jpg') }}" class="main-image"
                                    alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover14.jpg') }}"
                                    class="hover-image" alt="image">
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
                                            <a href="compare.html">
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
                        </div>

                        <div class="products-content">
                            <span class="category">T-Shirt</span>
                            <h3><a href="#">Causal V-Neck Soft Raglan</a></h3>
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

                <div class="col-lg-4 col-md-6 col-sm-6 products-col-item">
                    <div class="products-box">
                        <div class="products-image">
                            <a href="#">
                                <img src="{{ asset('website/assets/img/products/img15.jpg') }}" class="main-image"
                                    alt="image">
                                <img src="{{ asset('website/assets/img/products/img-hover15.jpg') }}"
                                    class="hover-image" alt="image">
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
                                            <a href="compare.html">
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
                        </div>

                        <div class="products-content">
                            <span class="category">Shirt</span>
                            <h3><a href="#">Hanes Men's Pullover</a></h3>
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
            </div>

            <div class="pagination-area text-center">
                <a href="#" class="prev page-numbers"><i class='bx bx-chevron-left'></i></a>
                <span class="page-numbers current" aria-current="page">1</span>
                <a href="#" class="page-numbers">2</a>
                <a href="#" class="page-numbers">3</a>
                <a href="#" class="page-numbers">4</a>
                <a href="#" class="page-numbers">5</a>
                <a href="#" class="next page-numbers"><i class='bx bx-chevron-right'></i></a>
            </div>
        </div>
    </section>

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
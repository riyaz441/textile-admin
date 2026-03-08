<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('website.layout.style')

    <title>{{ $product->name }} - Product Details</title>
    <link rel="icon" type="image/png" href="{{ asset("website/assets/img/favicon.png") }}">
    
    <style>
        .carousel-inner {
            background-color: #f8f9fa;
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .carousel-inner img {
            height: 500px;
            width: 100%;
            object-fit: scale-down;
        }

        .product-thumbnails {
            margin-top: 1rem;
        }

        .thumbnail-img {
            width: 100%;
            height: auto;
            border: 2px solid transparent;
            border-radius: 0.25rem;
            transition: all 0.3s ease;
            object-fit: cover;
            background-color: #f8f9fa;
            padding: 4px;
            box-sizing: border-box;
        }

        .thumbnail-img:hover {
            opacity: 0.8;
            cursor: pointer;
        }

        .thumbnail-img.active {
            border: 2px solid #333;
        }
    </style>
</head>

<body>
    @include("website.layout.header")

    <div class="page-title-area">
        <div class="container">
            <div class="page-title-content">
                <h2>{{ $product->name }}</h2>
                <ul>
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>Products Details</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="product-details-area pt-100 pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-12">
                    <div class="products-details-image">
                        <!-- Main Carousel -->
                        <div id="productCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($productImages as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset($image) }}" class="d-block w-100" alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Thumbnail Gallery -->
                        <div class="product-thumbnails">
                            <div class="row g-2">
                                @foreach ($productImages as $index => $image)
                                    <div class="col-3">
                                        <img src="{{ asset($image) }}" 
                                             class="img-fluid thumbnail-img {{ $index === 0 ? 'active' : '' }}" 
                                             alt="{{ $product->name }}"
                                             onclick="changeMainImage(this, {{ $index }})"
                                             style="cursor: pointer; border: 2px solid transparent; transition: border 0.3s;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-md-12">
                    <div class="products-details-desc">
                        <h3>{{ $product->name }}</h3>

                        <div class="price">
                            <span class="new-price">${{ number_format($product->price, 2) }}</span>
                            @if ($product->cost_price)
                                <span class="old-price">${{ number_format($product->cost_price, 2) }}</span>
                            @endif
                        </div>

                        <div class="products-review">
                            <div class="rating">
                                <i class='bx bx-star'></i>
                                <i class='bx bx-star'></i>
                                <i class='bx bx-star'></i>
                                <i class='bx bx-star'></i>
                                <i class='bx bx-star'></i>
                            </div>
                            <a href="#" class="rating-count">{{ number_format($product->rating, 1) }}/5 rating</a>
                        </div>

                        <ul class="products-info">
                            <li><span>SKU:</span> <a href="#">{{ $product->sku }}</a></li>
                            <li><span>Availability:</span> <a href="#">In stock ({{ $product->stock_quantity }} items)</a></li>
                            <li><span>Products Type:</span> <a href="#">{{ ucfirst($product->category) }}</a></li>
                        </ul>

                        <div class="products-color-switch">
                            <span>Color:</span>

                            <ul>
                                <li><a href="#" title="Black" class="color-black"></a></li>
                                <li><a href="#" title="White" class="color-white"></a></li>
                                <li class="active"><a href="#" title="Green" class="color-green"></a></li>
                                <li><a href="#" title="Yellow Green" class="color-yellowgreen"></a></li>
                                <li><a href="#" title="Teal" class="color-teal"></a></li>
                            </ul>
                        </div>

                        <div class="products-size-wrapper">
                            <span>Size:</span>

                            <ul>
                                <li><a href="#">XS</a></li>
                                <li class="active"><a href="#">S</a></li>
                                <li><a href="#">M</a></li>
                                <li><a href="#">XL</a></li>
                                <li><a href="#">XXL</a></li>
                            </ul>
                        </div>

                        <div class="products-info-btn">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#sizeGuideModal"><i
                                    class='bx bx-crop'></i> Size guide</a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#productsShippingModal"><i
                                    class='bx bxs-truck'></i> Shipping</a>
                            <a href="contact.html"><i class='bx bx-envelope'></i> Ask about this products</a>
                        </div>

                        <div class="products-add-to-cart">
                            <div class="input-counter">
                                <span class="minus-btn"><i class='bx bx-minus'></i></span>
                                <input type="text" value="1">
                                <span class="plus-btn"><i class='bx bx-plus'></i></span>
                            </div>

                            <button type="submit" class="default-btn"><i class="fas fa-cart-plus"></i> Add to
                                Cart</button>
                        </div>

                        <div class="wishlist-compare-btn">
                            <a href="#" class="optional-btn"><i class='bx bx-heart'></i> Add to Wishlist</a>
                            <a href="#" class="optional-btn"><i class='bx bx-refresh'></i> Add to Compare</a>
                        </div>

                        <div class="buy-checkbox-btn">
                            <div class="item">
                                <input class="inp-cbx" id="cbx" type="checkbox">
                                <label class="cbx" for="cbx">
                                    <span>
                                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    <span>I agree with the terms and conditions</span>
                                </label>
                            </div>

                            <div class="item">
                                <a href="#" class="default-btn">Buy it now!</a>
                            </div>
                        </div>

                        <div class="products-details-accordion">
                            <ul class="accordion">
                                <li class="accordion-item">
                                    <a class="accordion-title active" href="javascript:void(0)">
                                        <i class='bx bx-chevron-down'></i>
                                        Description
                                    </a>

                                    <div class="accordion-content show">
                                        <p>{{ $product->description }}</p>

                                        <ul>
                                            <li>Fabric 1: 100% Polyester</li>
                                            <li>Fabric 2: 100% Polyester, Lining: 100% Polyester</li>
                                            <li>Fabric 3: 75% Polyester, 20% Viscose, 5% Elastane</li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="accordion-item">
                                    <a class="accordion-title" href="javascript:void(0)">
                                        <i class='bx bx-chevron-down'></i>
                                        Additional information
                                    </a>

                                    <div class="accordion-content">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td>Category:</td>
                                                    <td>{{ ucfirst($product->category) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>SKU:</td>
                                                    <td>{{ $product->sku }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Stock:</td>
                                                    <td>{{ $product->stock_quantity }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Status:</td>
                                                    <td>{{ $product->status }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Price:</td>
                                                    <td>${{ number_format($product->price, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Short Description:</td>
                                                    <td>{{ $product->short_description ?: 'N/A' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </li>

                                <li class="accordion-item">
                                    <a class="accordion-title" href="javascript:void(0)">
                                        <i class='bx bx-chevron-down'></i>
                                        Reviews
                                    </a>

                                    <div class="accordion-content">
                                        <div class="products-review-form">
                                            <h3>Customer Reviews</h3>

                                            <div class="review-title">
                                                <div class="rating">
                                                    <i class='bx bxs-star'></i>
                                                    <i class='bx bxs-star'></i>
                                                    <i class='bx bxs-star'></i>
                                                    <i class='bx bxs-star'></i>
                                                    <i class='bx bx-star'></i>
                                                </div>
                                                <p>Based on 3 reviews</p>
                                                <a href="#" class="default-btn">Write a Review</a>
                                            </div>

                                            <div class="review-comments">
                                                <div class="review-item">
                                                    <div class="rating">
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bx-star'></i>
                                                    </div>
                                                    <h3>Good</h3>
                                                    <span><strong>Admin</strong> on <strong>Sep 21, 2024</strong></span>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                                                        enim ad minim veniam, quis nostrud exercitation.</p>
                                                </div>

                                                <div class="review-item">
                                                    <div class="rating">
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bx-star'></i>
                                                    </div>
                                                    <h3>Good</h3>
                                                    <span><strong>Admin</strong> on <strong>Sep 21, 2024</strong></span>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                                                        enim ad minim veniam, quis nostrud exercitation.</p>
                                                </div>

                                                <div class="review-item">
                                                    <div class="rating">
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bx-star'></i>
                                                    </div>
                                                    <h3>Good</h3>
                                                    <span><strong>Admin</strong> on <strong>Sep 21, 2024</strong></span>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                                                        enim ad minim veniam, quis nostrud exercitation.</p>
                                                </div>
                                            </div>

                                            <div class="review-form">
                                                <h3>Write a Review</h3>

                                                <form>
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" id="name" name="name"
                                                                    placeholder="Enter your name" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="form-group">
                                                                <input type="email" id="email" name="email"
                                                                    placeholder="Enter your email" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="form-group">
                                                                <input type="text" id="review-title" name="review-title"
                                                                    placeholder="Enter your review a title"
                                                                    class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="form-group">
                                                                <textarea name="review-body" id="review-body" cols="30"
                                                                    rows="6" placeholder="Write your comments here"
                                                                    class="form-control"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 col-md-12">
                                                            <button type="submit" class="default-btn">Submit
                                                                Review</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <div class="related-products">
                <div class="container">
                    <div class="section-title">
                        <span class="sub-title">Our Shop</span>
                        <h2>Related Products</h2>
                    </div>

                    <div class="products-slides owl-carousel owl-theme">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="single-products-box">
                                <div class="products-image">
                                    <a href="{{ route('website.products.show', $relatedProduct->slug) }}">
                                        <img src="{{ asset($relatedProduct->image) }}" class="main-image" alt="{{ $relatedProduct->name }}">
                                        <img src="{{ asset($relatedProduct->image_1 ?: $relatedProduct->image) }}" class="hover-image" alt="{{ $relatedProduct->name }}">
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
                                </div>

                                <div class="products-content">
                                    <h3><a href="{{ route('website.products.show', $relatedProduct->slug) }}">{{ $relatedProduct->name }}</a></h3>
                                    <div class="price">
                                        @if ($relatedProduct->cost_price)
                                            <span class="old-price">${{ number_format($relatedProduct->cost_price, 2) }}</span>
                                        @endif
                                        <span class="new-price">${{ number_format($relatedProduct->price, 2) }}</span>
                                    </div>
                                    <div class="star-rating">
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                    </div>
                                    <a href="#" class="add-to-cart">Add to Cart</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
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

    @include("website.layout.footer")
    <div class="go-top"><i class='bx bx-up-arrow-alt'></i></div>

    @include('website.layout.script')

    <script>
        function changeMainImage(thumbnail, index) {
            // Get the carousel instance
            const carousel = new bootstrap.Carousel(document.getElementById('productCarousel'));
            // Go to the slide at index
            carousel.to(index);
            
            // Update thumbnail styling
            document.querySelectorAll('.thumbnail-img').forEach(img => {
                img.style.border = '2px solid transparent';
            });
            thumbnail.style.border = '2px solid #333';
        }
    </script>
</body>

</html>

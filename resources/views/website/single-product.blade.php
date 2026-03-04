<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Hexashop - Product Detail Page</title>


    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('website/assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('website/assets/css/font-awesome.css') }}">

    <link rel="stylesheet" href="{{ asset('website/assets/css/templatemo-hexashop.css') }}">

    <link rel="stylesheet" href="{{ asset('website/assets/css/owl-carousel.css') }}">

    <link rel="stylesheet" href="{{ asset('website/assets/css/lightbox.css') }}">
    <style>
        #product .product-layout {
            align-items: flex-start;
        }

        #product .product-gallery-col {
            flex: 0 0 64%;
            max-width: 64%;
        }

        #product .product-info-col {
            flex: 0 0 36%;
            max-width: 36%;
            padding-left: 20px;
        }

        #product .left-images {
            width: 100%;
            overflow: hidden;
        }

        .product-gallery-main img {
            width: 100%;
            max-height: 520px;
            object-fit: cover;
            border-radius: 6px;
        }

        .product-gallery-thumbs {
            display: flex;
            gap: 10px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .product-gallery-thumbs .thumb-btn {
            border: 2px solid #e8e8e8;
            padding: 0;
            border-radius: 6px;
            background: #fff;
            overflow: hidden;
            cursor: pointer;
        }

        .product-gallery-thumbs .thumb-btn.active {
            border-color: #2a2a2a;
        }

        .product-gallery-thumbs img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            display: block;
        }

        @media (max-width: 991.98px) {
            #product .product-gallery-col,
            #product .product-info-col {
                flex: 0 0 100%;
                max-width: 100%;
                padding-left: 15px;
                padding-right: 15px;
            }

            #product .product-info-col {
                margin-top: 30px;
            }
        }
    </style>
<!--

TemplateMo 571 Hexashop

https://templatemo.com/tm-571-hexashop

-->
    </head>

    <body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->


    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="{{ route('index') }}" class="logo">
                            <img src="{{ asset('website/assets/images/logo.png') }}">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="{{ route('index') }}" class="active">Home</a></li>
                            <li class="scroll-to-section"><a href="{{ route('index') }}">Men's</a></li>
                            <li class="scroll-to-section"><a href="{{ route('index') }}">Women's</a></li>
                            <li class="scroll-to-section"><a href="{{ route('index') }}">Kid's</a></li>
                            <li class="submenu">
                                <a href="javascript:;">Pages</a>
                                <ul>
                                    <li><a href="{{ route('about') }}">About Us</a></li>
                                    <li><a href="{{ route('products') }}">Products</a></li>
                                    <li><a href="{{ route('single-product') }}">Single Product</a></li>
                                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                </ul>
                            </li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Banner Area Start ***** -->
    <div class="page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>{{ $product->name }}</h2>
                        <span>{{ ucfirst($product->category) }} Collection</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->


    <!-- ***** Product Area Starts ***** -->
    @php
        $productImages = collect([$product->image, $product->image_1, $product->image_2, $product->image_3])->filter()->take(4)->values();
        $starCount = max(0, min(5, (int) round($product->rating ?? 0)));
        $unitPrice = (float) $product->price;
        $mainImage = $productImages->first();
    @endphp
    <section class="section" id="product">
        <div class="container">
            <div class="row product-layout">
                <div class="col-lg-8 product-gallery-col">
                    <div class="left-images">
                        @if ($mainImage)
                            <div class="product-gallery-main">
                                <img id="main-product-image" src="{{ asset($mainImage) }}" alt="{{ $product->name }}">
                            </div>
                            @if ($productImages->count() > 1)
                                <div class="product-gallery-thumbs">
                                    @foreach ($productImages as $index => $image)
                                        <button type="button" class="thumb-btn {{ $index === 0 ? 'active' : '' }}"
                                            data-image="{{ asset($image) }}">
                                            <img src="{{ asset($image) }}" alt="{{ $product->name }} {{ $index + 1 }}">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            <div class="col-lg-4 product-info-col">
                <div class="right-content">
                    <h4>{{ $product->name }}</h4>
                    <span class="price">${{ number_format($unitPrice, 2) }}</span>
                    <ul class="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <li><i class="fa {{ $i <= $starCount ? 'fa-star' : 'fa-star-o' }}"></i></li>
                        @endfor
                    </ul>
                    <span>{{ $product->short_description ?: $product->description }}</span>
                    <div class="quote">
                        <i class="fa fa-quote-left"></i>
                        <p>{{ $product->description }}</p>
                    </div>
                    <div class="quantity-content">
                        <div class="left-content">
                            <h6>No. of Orders</h6>
                        </div>
                        <div class="right-content">
                            <div class="quantity buttons_added">
                                <input type="button" value="-" class="minus">
                                <input type="number" step="1" min="1" max="{{ max(1, (int) $product->stock_quantity) }}"
                                    name="quantity" value="1" title="Qty" class="input-text qty text" size="4"
                                    pattern="" inputmode="">
                                <input type="button" value="+" class="plus">
                            </div>
                        </div>
                    </div>
                    <div class="total">
                        <h4>Total: $<span id="product-total">{{ number_format($unitPrice, 2) }}</span></h4>
                        <div class="main-border-button"><a href="#">Add To Cart</a></div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>
    <!-- ***** Product Area Ends ***** -->

    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="first-item">
                        <div class="logo">
                            <img src="{{ asset('website/assets/images/white-logo.png') }}" alt="hexashop ecommerce templatemo">
                        </div>
                        <ul>
                            <li><a href="#">16501 Collins Ave, Sunny Isles Beach, FL 33160, United States</a></li>
                            <li><a href="#">hexashop@company.com</a></li>
                            <li><a href="#">010-020-0340</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h4>Shopping &amp; Categories</h4>
                    <ul>
                        <li><a href="#">Men’s Shopping</a></li>
                        <li><a href="#">Women’s Shopping</a></li>
                        <li><a href="#">Kid's Shopping</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Homepage</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4>Help &amp; Information</h4>
                    <ul>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">FAQ's</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Tracking ID</a></li>
                    </ul>
                </div>
                <div class="col-lg-12">
                    <div class="under-footer">
                        <p>Copyright © 2022 HexaShop Co., Ltd. All Rights Reserved.

                        <br>Design: <a href="https://templatemo.com" target="_parent" title="free css templates">TemplateMo</a>

                        <br>Distributed By: <a href="https://themewagon.com" target="_blank" title="free & premium responsive templates">ThemeWagon</a></p>
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-behance"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- jQuery -->
    <script src="{{ asset('website/assets/js/jquery-2.1.0.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('website/assets/js/popper.js') }}"></script>
    <script src="{{ asset('website/assets/js/bootstrap.min.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('website/assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('website/assets/js/accordions.js') }}"></script>
    <script src="{{ asset('website/assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('website/assets/js/scrollreveal.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/imgfix.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/slick.js') }}"></script>
    <script src="{{ asset('website/assets/js/lightbox.js') }}"></script>
    <script src="{{ asset('website/assets/js/isotope.js') }}"></script>
    <script src="{{ asset('website/assets/js/quantity.js') }}"></script>

    <!-- Global Init -->
    <script src="{{ asset('website/assets/js/custom.js') }}"></script>

    <script>
        $(function() {
            const unitPrice = {{ json_encode($unitPrice) }};
            const qtyInput = $('.qty');
            const totalElement = $('#product-total');
            const mainImage = $('#main-product-image');
            const thumbButtons = $('.thumb-btn');

            function refreshTotal() {
                const qty = Math.max(1, parseInt(qtyInput.val(), 10) || 1);
                totalElement.text((unitPrice * qty).toFixed(2));
            }

            qtyInput.on('input change', refreshTotal);
            refreshTotal();

            thumbButtons.on('click', function () {
                const selectedImage = $(this).data('image');
                if (!selectedImage || !mainImage.length) {
                    return;
                }
                mainImage.attr('src', selectedImage);
                thumbButtons.removeClass('active');
                $(this).addClass('active');
            });
        });

        $(function() {
            var selectedClass = "";
            $("p").click(function(){
            selectedClass = $(this).attr("data-rel");
            $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("."+selectedClass).fadeOut();
            setTimeout(function() {
              $("."+selectedClass).fadeIn();
              $("#portfolio").fadeTo(50, 1);
            }, 500);

            });
        });

    </script>

  </body>

</html>

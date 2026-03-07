<!DOCTYPE html>
<html lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="{{ asset("website/assets/css/bootstrap.min.css") }}">
        <link rel="stylesheet" href="{{ asset("website/assets/css/boxicons.min.css") }}">
        <link rel="stylesheet" href="{{ asset("website/assets/css/style.css") }}">
        <link rel="stylesheet" href="{{ asset("website/assets/css/responsive.css") }}">
        <title>Product Details</title>
        <link rel="icon" type="image/png" href="{{ asset("website/assets/img/favicon.png") }}">
    </head>
    <body>
        @include('"'"'website.layout.header'"'"')

        <div class="page-title-area">
            <div class="container">
                <div class="page-title-content">
                    <h2>Product Details</h2>
                    <ul>
                        <li><a href="{{ route('"'"'index'"'"') }}">Home</a></li>
                        <li><a href="{{ route('"'"'products'"'"') }}">Products</a></li>
                        <li>Details</li>
                    </ul>
                </div>
            </div>
        </div>

        <section class="product-details-area pt-100 pb-70">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-md-12 mb-4">
                        <img src="{{ asset("website/assets/img/products/img13.jpg") }}" alt="product" style="width: 100%; height: auto;" class="border rounded">
                    </div>
                    <div class="col-lg-7 col-md-12">
                        <h1 class="mb-3">Long Sleeve Leopard T-Shirt</h1>
                        <div class="mb-3">
                            <span style="text-decoration: line-through; margin-right: 10px;">$321</span>
                            <span style="font-size: 28px; color: #ff6b6b; font-weight: bold;">$250</span>
                        </div>
                        <div class="mb-3">
                            <i class='"'"'bx bxs-star'"'"'></i>
                            <i class='"'"'bx bxs-star'"'"'></i>
                            <i class='"'"'bx bxs-star'"'"'></i>
                            <i class='"'"'bx bxs-star'"'"'></i>
                            <i class='"'"'bx bxs-star'"'"'></i>
                            <span class="ms-2">(5 reviews)</span>
                        </div>
                        <p class="mb-4" style="font-size: 16px; line-height: 1.6;">Premium quality long sleeve t-shirt. Made with sustainable fabrics. Perfect for casual and comfortable wear. Available in multiple colors and sizes.</p>
                        <div class="mb-4">
                            <label class="d-block mb-2"><strong>Size:</strong></label>
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="size" id="size-s" value="S">
                                <label class="btn btn-outline-primary" for="size-s">S</label>
                                <input type="radio" class="btn-check" name="size" id="size-m" value="M" checked>
                                <label class="btn btn-outline-primary" for="size-m">M</label>
                                <input type="radio" class="btn-check" name="size" id="size-l" value="L">
                                <label class="btn btn-outline-primary" for="size-l">L</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary btn-lg flex-grow-1">Add to Cart</button>
                            <button class="btn btn-outline-primary btn-lg"><i class='"'"'bx bx-heart'"'"'></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('"'"'website.layout.footer'"'"')
        <div class="go-top"><i class='"'"'bx bx-up-arrow-alt'"'"'></i></div>

        <script src="{{ asset("website/assets/js/jquery.min.js") }}"></script>
        <script src="{{ asset("website/assets/js/bootstrap.min.js") }}"></script>
        <script src="{{ asset("website/assets/js/main.js") }}"></script>
    </body>
</html>

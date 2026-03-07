<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('website/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/style.css') }}">
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
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="products-box" onclick="window.location.href='{{ route('products.show', 1) }}'"
                        style="cursor: pointer;">
                        <h3><a href="{{ route('products.show', 1) }}">Product 1</a></h3>
                        <p>Premium quality textile</p>
                        <a href="{{ route('products.show', 1) }}" class="btn">View</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="products-box" onclick="window.location.href='{{ route('products.show', 2) }}'"
                        style="cursor: pointer;">
                        <h3><a href="{{ route('products.show', 2) }}">Product 2</a></h3>
                        <p>Premium quality textile</p>
                        <a href="{{ route('products.show', 2) }}" class="btn">View</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="products-box" onclick="window.location.href='{{ route('products.show', 3) }}'"
                        style="cursor: pointer;">
                        <h3><a href="{{ route('products.show', 3) }}">Product 3</a></h3>
                        <p>Premium quality textile</p>
                        <a href="{{ route('products.show', 3) }}" class="btn">View</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('website.layout.footer')
    <div class="go-top"><i class='bx bx-up-arrow-alt'></i></div>

    <script src="{{ asset('website/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/main.js') }}"></script>
</body>

</html>

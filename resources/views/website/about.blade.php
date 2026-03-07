<!DOCTYPE html>
<html lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="{{ asset("website/assets/css/bootstrap.min.css") }}">
        <link rel="stylesheet" href="{{ asset("website/assets/css/animate.min.css") }}">
        <link rel="stylesheet" href="{{ asset("website/assets/css/boxicons.min.css") }}">
        <link rel="stylesheet" href="{{ asset("website/assets/css/style.css") }}">
        <link rel="stylesheet" href="{{ asset("website/assets/css/responsive.css") }}">
        <title>About Us - Textile eCommerce</title>
        <link rel="icon" type="image/png" href="{{ asset("website/assets/img/favicon.png") }}">
    </head>
    <body>
        @include('"'"'website.layout.header'"'"')

        <!-- Start Page Title -->
        <div class="page-title-area">
            <div class="container">
                <div class="page-title-content">
                    <h2>About Us</h2>
                    <ul>
                        <li><a href="{{ route('"'"'index'"'"') }}">Home</a></li>
                        <li>About Us</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Start About Area -->
        <section class="about-area ptb-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <img src="{{ asset("website/assets/img/about.jpg") }}" alt="about" style="width: 100%; height: auto;">
                    </div>
                    <div class="col-lg-6 col-md-12 ps-4">
                        <div class="about-content">
                            <h2>Welcome to Xton Textile Store</h2>
                            <p>We are a leading textile eCommerce platform dedicated to providing high-quality fabrics and clothing to customers worldwide. With over a decade of experience, we pride ourselves on offering premium products at competitive prices.</p>

                            <h3 class="mt-4">Our Mission</h3>
                            <p>Our mission is to make quality textiles and clothing accessible to everyone. We believe in sustainable practices and ethical sourcing of all our materials.</p>

                            <h3 class="mt-4">Why Choose Us</h3>
                            <ul>
                                <li>Premium quality products</li>
                                <li>Competitive pricing</li>
                                <li>Fast and reliable shipping</li>
                                <li>Excellent customer service</li>
                                <li>Sustainable practices</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('"'"'website.layout.footer'"'"')
        <div class="go-top"><i class='"'"'bx bx-up-arrow-alt'"'"'></i></div>

        <script src="{{ asset("website/assets/js/jquery.min.js") }}"></script>
        <script src="{{ asset("website/assets/js/bootstrap.bundle.min.js") }}"></script>
        <script src="{{ asset("website/assets/js/main.js") }}"></script>
    </body>
</html>

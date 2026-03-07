<!DOCTYPE html>
<html lang="zxx">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Links of CSS files -->
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/bootstrap.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/animate.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/boxicons.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/flaticon.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/magnific-popup.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/nice-select.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/slick.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/owl.carousel.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/meanmenu.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/rangeSlider.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/style.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/dark.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/responsive.css'"'"') }}">

        <title>Textile - eCommerce</title>

        <link rel="icon" type="image/png" href="{{ asset('"'"'website/assets/img/favicon.png'"'"') }}">
    </head>
    <body>

        @include('"'"'website.layout.header'"'"')

        <!-- Start Page Title -->
        <div class="page-title-area">
            <div class="container">
                <div class="page-title-content">
                    <h2>Blog</h2>
                    <ul>
                        <li><a href="{{ route('"'"'index'"'"') }}">Home</a></li>
                        <li>Blog</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Page Title -->

        <!-- Start Blog Area -->
        <section class="blog-area ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="blog-card border rounded overflow-hidden">
                            <img src="{{ asset('"'"'website/assets/img/blog/blog1.jpg'"'"') }}" alt="blog" style="width: 100%; height: 250px; object-fit: cover;">
                            <div class="p-4">
                                <span class="text-muted">March 7, 2026</span>
                                <h3 class="mt-2"><a href="#" class="text-decoration-none">Latest Textile Trends for 2026</a></h3>
                                <p>Discover the hottest textile trends this year. From sustainable fabrics to vibrant colors.</p>
                                <a href="#" class="btn btn-sm btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="blog-card border rounded overflow-hidden">
                            <img src="{{ asset('"'"'website/assets/img/blog/blog2.jpg'"'"') }}" alt="blog" style="width: 100%; height: 250px; object-fit: cover;">
                            <div class="p-4">
                                <span class="text-muted">March 5, 2026</span>
                                <h3 class="mt-2"><a href="#" class="text-decoration-none">How to Care for Your Textiles</a></h3>
                                <p>Learn the best practices for maintaining your products to ensure longevity and quality.</p>
                                <a href="#" class="btn btn-sm btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="blog-card border rounded overflow-hidden">
                            <img src="{{ asset('"'"'website/assets/img/blog/blog3.jpg'"'"') }}" alt="blog" style="width: 100%; height: 250px; object-fit: cover;">
                            <div class="p-4">
                                <span class="text-muted">March 3, 2026</span>
                                <h3 class="mt-2"><a href="#" class="text-decoration-none">Sustainable Fashion: Making a Difference</a></h3>
                                <p>Explore how sustainable textiles are changing the fashion industry positively.</p>
                                <a href="#" class="btn btn-sm btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pagination-area text-center mt-5">
                    <a href="#" class="btn btn-sm me-2"><i class='"'"'bx bx-chevron-left'"'"'></i></a>
                    <span class="btn btn-sm active">1</span>
                    <a href="#" class="btn btn-sm">2</a>
                    <a href="#" class="btn btn-sm">3</a>
                    <a href="#" class="btn btn-sm ms-2"><i class='"'"'bx bx-chevron-right'"'"'></i></a>
                </div>
            </div>
        </section>
        <!-- End Blog Area -->

        @include('"'"'website.layout.footer'"'"')
        
        <div class="go-top"><i class='"'"'bx bx-up-arrow-alt'"'"'></i></div>

        <script src="{{ asset('"'"'website/assets/js/jquery.min.js'"'"') }}"></script>
        <script src="{{ asset('"'"'website/assets/js/bootstrap.bundle.min.js'"'"') }}"></script>
        <script src="{{ asset('"'"'website/assets/js/owl.carousel.min.js'"'"') }}"></script>
        <script src="{{ asset('"'"'website/assets/js/main.js'"'"') }}"></script>
    </body>
</html>

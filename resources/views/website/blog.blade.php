<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Links of CSS files -->
    @include('website.layout.style')

    <title>Textile - eCommerce</title>

    <link rel="icon" type="image/png" href="{{ asset("website/assets/img/favicon.png") }}">
</head>

<body>

    @include("website.layout.header")

    <!-- Start Page Title -->
    <div class="page-title-area">
        <div class="container">
            <div class="page-title-content">
                <h2>Blog</h2>
                <ul>
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>Blog</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Start Blog Area -->
    <section class="blog-area ptb-100">
        <div class="container">
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
                            <h3><a href="{{ route('blog.details') }}">Latest ecommerce trend: The rise of shoppable posts</a></h3>
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

                <div class="col-lg-12 col-md-12 col-sm-12">
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
    <!-- End Blog Area -->

    @include("website.layout.footer")

    <div class="go-top"><i class='bx bx-up-arrow-alt'></i></div>

    @include('website.layout.script')
</body>

</html>
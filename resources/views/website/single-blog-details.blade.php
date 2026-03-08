<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    @include('website.layout.style')

    <title>Blog Details - Textile</title>
    <link rel="icon" type="image/png" href="{{ asset('website/assets/img/favicon.png') }}">
</head>

<body>
    @include('website.layout.header')

    <div class="page-title-area">
        <div class="container">
            <div class="page-title-content">
                <h2>Blog Details</h2>
                <ul>
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>Blog Details</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="blog-details-area ptb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12">
                    <div class="blog-details-desc">
                        <div class="article-video">
                            <iframe src="https://www.youtube.com/embed/bk7McNUjWgw"></iframe>
                        </div>

                        <div class="article-content">
                            <div class="entry-meta">
                                <ul>
                                    <li>
                                        <i class='bx bx-folder-open'></i>
                                        <span>Category</span>
                                        <a href="#">Fashion</a>
                                    </li>
                                    <li>
                                        <i class='bx bx-group'></i>
                                        <span>View</span>
                                        <a href="#">813,454</a>
                                    </li>
                                    <li>
                                        <i class='bx bx-calendar'></i>
                                        <span>Last Updated</span>
                                        <a href="#">01/14/2024</a>
                                    </li>
                                </ul>
                            </div>

                            <h3>The #1 eCommerce blog to grow your business</h3>

                            <p>Quuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quia non numquam eius modi tempora incidunt ut labore et dolore magnam dolor sit amet, consectetur adipisicing.</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                            <blockquote class="wp-block-quote">
                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                                <cite>Tom Cruise</cite>
                            </blockquote>

                            <ul class="wp-block-gallery columns-3">
                                <li class="blocks-gallery-item">
                                    <figure>
                                        <img src="{{ asset('website/assets/img/blog/img2.jpg') }}" alt="image">
                                    </figure>
                                </li>
                                <li class="blocks-gallery-item">
                                    <figure>
                                        <img src="{{ asset('website/assets/img/blog/img3.jpg') }}" alt="image">
                                    </figure>
                                </li>
                                <li class="blocks-gallery-item">
                                    <figure>
                                        <img src="{{ asset('website/assets/img/blog/img4.jpg') }}" alt="image">
                                    </figure>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <aside class="widget-area">
                        <section class="widget widget_search">
                            <form class="search-form">
                                <label>
                                    <span class="screen-reader-text">Search for:</span>
                                    <input type="search" class="search-field" placeholder="Search...">
                                </label>
                                <button type="submit"><i class="bx bx-search-alt"></i></button>
                            </form>
                        </section>

                        <section class="widget widget_xton_posts_thumb">
                            <h3 class="widget-title">Popular Posts</h3>
                            <article class="item">
                                <a href="#" class="thumb"><span class="fullimage cover bg1" role="img"></span></a>
                                <div class="info">
                                    <span>June 10, 2024</span>
                                    <h4 class="title usmall"><a href="#">Top ecommerce conferences in 2024</a></h4>
                                </div>
                                <div class="clear"></div>
                            </article>
                        </section>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    <section class="facility-area pb-70">
        <div class="container">
            <div class="facility-slides owl-carousel owl-theme">
                <div class="single-facility-box">
                    <div class="icon"><i class='flaticon-tracking'></i></div>
                    <h3>Free Shipping Worldwide</h3>
                </div>
                <div class="single-facility-box">
                    <div class="icon"><i class='flaticon-return'></i></div>
                    <h3>Easy Return Policy</h3>
                </div>
                <div class="single-facility-box">
                    <div class="icon"><i class='flaticon-shuffle'></i></div>
                    <h3>7 Day Exchange Policy</h3>
                </div>
                <div class="single-facility-box">
                    <div class="icon"><i class='flaticon-sale'></i></div>
                    <h3>Weekend Discount Coupon</h3>
                </div>
                <div class="single-facility-box">
                    <div class="icon"><i class='flaticon-credit-card'></i></div>
                    <h3>Secure Payment Methods</h3>
                </div>
                <div class="single-facility-box">
                    <div class="icon"><i class='flaticon-location'></i></div>
                    <h3>Track Your Package</h3>
                </div>
                <div class="single-facility-box">
                    <div class="icon"><i class='flaticon-customer-service'></i></div>
                    <h3>24/7 Customer Support</h3>
                </div>
            </div>
        </div>
    </section>

    @include('website.layout.footer')

    <div class="go-top"><i class='bx bx-up-arrow-alt'></i></div>

    @include('website.layout.script')
</body>

</html>

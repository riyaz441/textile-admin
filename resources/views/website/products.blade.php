<!DOCTYPE html>
<html lang="zxx">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="{{ asset("website/assets/css/bootstrap.min.css") }}">
        <link rel="stylesheet" href="{{ asset("website/assets/css/animate.min.css") }}">
        <link rel="stylesheet" href="{{ asset("website/assets/css/boxicons.min.css") }}">
        <link rel="stylesheet" href="{{ asset("website/assets/css/style.css") }}">
        <title>Products - Textile eCommerce</title>
        <link rel="icon" type="image/png" href="{{ asset("website/assets/img/favicon.png") }}">
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
                        <div class="products-box">
                            <h3><a href="{{ route('products.show', 1) }}">Product 1</a></h3>
                            <p>Premium quality textile</p>
                            <a href="{{ route('products.show', 1) }}" class="btn">View</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="products-box">
                            <h3><a href="{{ route('products.show', 2) }}">Product 2</a></h3>
                            <p>Premium quality textile</p>
                            <a href="{{ route('products.show', 2) }}" class="btn">View</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="products-box">
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

        <script src="{{ asset("website/assets/js/jquery.min.js") }}"></script>
        <script src="{{ asset("website/assets/js/bootstrap.bundle.min.js") }}"></script>
        <script src="{{ asset("website/assets/js/main.js") }}"></script>
    </body>
</html>
<!DOCTYPE html>
<html lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/bootstrap.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/animate.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/boxicons.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/style.css'"'"') }}">
        <title>Product Details - Textile eCommerce</title>
        <link rel="icon" type="image/png" href="{{ asset('"'"'website/assets/img/favicon.png'"'"') }}">
    </head>
    <body>
        @include('"'"'website.layout.header'"'"')

        <!-- Start Page Title -->
        <div class="page-title-area">
            <div class="container">
                <div class="page-title-content">
                    <h2>Product Details</h2>
                    <ul>
                        <li><a href="{{ route('"'"'index'"'"') }}">Home</a></li>
                        <li><a href="{{ route('"'"'products'"'"') }}">Products</a></li>
                        <li>Product Details</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Start Product Details Area -->
        <section class="product-details-area pt-100 pb-70">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <img src="{{ asset('"'"'website/assets/img/products/img13.jpg'"'"') }}" alt="product" style="width: 100%; height: auto;">
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="product-details-content">
                            <h1>Long Sleeve Leopard T-Shirt</h1>
                            <div class="price mb-3">
                                <span style="text-decoration: line-through; margin-right: 10px;">$321</span>
                                <span style="font-size: 24px; color: #ff6b6b;">$250</span>
                            </div>
                            <div class="rating mb-3">
                                <i class='"'"'bx bxs-star'"'"'></i>
                                <i class='"'"'bx bxs-star'"'"'></i>
                                <i class='"'"'bx bxs-star'"'"'></i>
                                <i class='"'"'bx bxs-star'"'"'></i>
                                <i class='"'"'bx bxs-star'"'"'></i>
                                <span>(5 reviews)</span>
                            </div>
                            <p class="mb-4">Premium quality long sleeve t-shirt made with sustainable fabrics. Perfect for casual wear.</p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary">Add to Cart</button>
                                <button class="btn btn-outline-primary">Add to Wishlist</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('"'"'website.layout.footer'"'"')
        <div class="go-top"><i class='"'"'bx bx-up-arrow-alt'"'"'></i></div>

        <script src="{{ asset('"'"'website/assets/js/jquery.min.js'"'"') }}"></script>
        <script src="{{ asset('"'"'website/assets/js/bootstrap.bundle.min.js'"'"') }}"></script>
        <script src="{{ asset('"'"'website/assets/js/main.js'"'"') }}"></script>
    </body>
</html>
'"@;

Set-Content -Path 'e:\xampp\htdocs\textile-admin\resources\views\website\product_details.blade.php' -Value $productDetailsContent
Write-Host "product_details.blade.php updated"

# Update about.blade.php
$aboutContent = @'
<!DOCTYPE html>
<html lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/bootstrap.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/animate.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/boxicons.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/style.css'"'"') }}">
        <title>About Us - Textile eCommerce</title>
        <link rel="icon" type="image/png" href="{{ asset('"'"'website/assets/img/favicon.png'"'"') }}">
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
                        <img src="{{ asset('"'"'website/assets/img/about.jpg'"'"') }}" alt="about" style="width: 100%; height: auto;">
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="about-content ps-4">
                            <h2>Welcome to Textile Store</h2>
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

        <script src="{{ asset('"'"'website/assets/js/jquery.min.js'"'"') }}"></script>
        <script src="{{ asset('"'"'website/assets/js/bootstrap.bundle.min.js'"'"') }}"></script>
        <script src="{{ asset('"'"'website/assets/js/main.js'"'"') }}"></script>
    </body>
</html>
'"@;

Set-Content -Path 'e:\xampp\htdocs\textile-admin\resources\views\website\about.blade.php' -Value $aboutContent
Write-Host "about.blade.php updated"

# Update blog.blade.php
$blogContent = @'
<!DOCTYPE html>
<html lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/bootstrap.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/animate.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/boxicons.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/style.css'"'"') }}">
        <title>Blog - Textile eCommerce</title>
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
                                <p>Learn the best practices for maintaining your textile products to ensure longevity.</p>
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
                                <p>Explore how sustainable textiles are changing the fashion industry and the environment.</p>
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

        @include('"'"'website.layout.footer'"'"')
        <div class="go-top"><i class='"'"'bx bx-up-arrow-alt'"'"'></i></div>

        <script src="{{ asset('"'"'website/assets/js/jquery.min.js'"'"') }}"></script>
        <script src="{{ asset('"'"'website/assets/js/bootstrap.bundle.min.js'"'"') }}"></script>
        <script src="{{ asset('"'"'website/assets/js/main.js'"'"') }}"></script>
    </body>
</html>
'"@;

Set-Content -Path 'e:\xampp\htdocs\textile-admin\resources\views\website\blog.blade.php' -Value $blogContent
Write-Host "blog.blade.php updated"

php -r "
\$products = file_get_contents('e:\\xampp\\htdocs\\textile-admin\\resources\\views\\website\\products.blade.php');
\$pos = strpos(\$products, '@include(\'website.layout.header\')');
if (\$pos > 0) {
    \$newContent = substr(\$products, 0, \$pos + strlen('@include(\'website.layout.header\')'));
    // Find the closing body tag
    \$bodyPos = strrpos(\$products, '</body>');
    if (\$bodyPos > 0) {
        \$footer = substr(\$products, \$bodyPos);
        \$newContent .= file_get_contents('php://stdin') . \$footer;
        file_put_contents('e:\\xampp\\htdocs\\textile-admin\\resources\\views\\website\\products.blade.php', \$newContent);
        echo 'File would be updated';
    }
}
" 2>&1 ; echo "File check completed"

# Remove and recreate products.blade.php with clean content
Remove-Item 'e:\xampp\htdocs\textile-admin\resources\views\website\products.blade.php' -Force
@'
<!DOCTYPE html>
<html lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/bootstrap.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/boxicons.min.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/style.css'"'"') }}">
        <link rel="stylesheet" href="{{ asset('"'"'website/assets/css/responsive.css'"'"') }}">
        <title>Products - Textile eCommerce</title>
        <link rel="icon" type="image/png" href="{{ asset('"'"'website/assets/img/favicon.png'"'"') }}">
    </head>
    <body>
        @include('"'"'website.layout.header'"'"')

        <!-- Start Page Title -->
        <div class="page-title-area">
            <div class="container">
                <div class="page-title-content">
                    <h2>Products</h2>
                    <ul>
                        <li><a href="{{ route('"'"'index'"'"') }}">Home</a></li>
                        <li>Products</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Start Products Area -->
        <section class="products-area pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="products-box border rounded p-3">
                            <img src="{{ asset('"'"'website/assets/img/products/img13.jpg'"'"') }}" alt="product" style="width: 100%; height: 250px; object-fit: cover;" class="mb-3">
                            <h5><a href="{{ route('"'"'products.show'"'"', 1) }}" class="text-decoration-none">Long Sleeve Leopard T-Shirt</a></h5>
                            <p class="text-muted">Premium quality textile</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>$250</span>
                                <a href="{{ route('"'"'products.show'"'"', 1) }}" class="btn btn-sm btn-primary">View</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="products-box border rounded p-3">
                            <img src="{{ asset('"'"'website/assets/img/products/img14.jpg'"'"') }}" alt="product" style="width: 100%; height: 250px; object-fit: cover;" class="mb-3">
                            <h5><a href="{{ route('"'"'products.show'"'"', 2) }}" class="text-decoration-none">Casual V-Neck Soft Raglan</a></h5>
                            <p class="text-muted">Premium quality textile</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>$200</span>
                                <a href="{{ route('"'"'products.show'"'"', 2) }}" class="btn btn-sm btn-primary">View</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="products-box border rounded p-3">
                            <img src="{{ asset('"'"'website/assets/img/products/img15.jpg'"'"') }}" alt="product" style="width: 100%; height: 250px; object-fit: cover;" class="mb-3">
                            <h5><a href="{{ route('"'"'products.show'"'"', 3) }}" class="text-decoration-none">Hanes Men'"'"'s Pullover</a></h5>
                            <p class="text-muted">Premium quality textile</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>$200</span>
                                <a href="{{ route('"'"'products.show'"'"', 3) }}" class="btn btn-sm btn-primary">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('"'"'website.layout.footer'"'"')
        <div class="go-top"><i class='"'"'bx bx-up-arrow-alt'"'"'></i></div>

        <script src="{{ asset('"'"'website/assets/js/jquery.min.js'"'"') }}"></script>
        <script src="{{ asset('"'"'website/assets/js/bootstrap.min.js'"'"') }}"></script>
        <script src="{{ asset('"'"'website/assets/js/main.js'"'"') }}"></script>
    </body>
</html>

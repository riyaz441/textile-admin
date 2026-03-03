<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Textile - {{ env('APP_NAME') }}</title>
    <!-- SEO friendly -->
    <meta name="description"
        content="NexusTex – modern fabric manufacturer offering premium cotton, silk, linen and garment collections.">
    <!-- Bootstrap 5 + Icons + Google Fonts + AOS + animate.css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- custom style -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- STICKY NAVBAR (glassmorphism) -->
    <nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light glass-nav">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.html"><i
                    class="bi bi-scissors me-2 text-maroon"></i>NexusTex</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#products">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="#why">Why us</a></li>
                    <li class="nav-item"><a class="nav-link" href="product-details.html?sample=1">Showcase</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-outline-maroon ms-lg-3 px-4"
                            href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO with subtle parallax & gradient / glassmorphism effect -->
    <section class="hero-section d-flex align-items-center">
        <div class="container text-center text-lg-start">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="display-4 fw-bold"><span class="text-dark-blue">Weaving</span> <span
                            class="text-maroon">excellence</span> since 1985</h1>
                    <p class="lead text-secondary my-4">Premium fabrics, timeless garments & sustainable textile
                        solutions for modern creators.</p>
                    <a href="#products" class="btn btn-maroon btn-lg px-5 py-3 me-2 shadow-sm"><i
                            class="bi bi-grid-fill me-2"></i>Explore collection</a>
                    <a href="#contact" class="btn btn-outline-maroon btn-lg px-5 py-3">Get sample</a>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 text-center" data-aos="fade-left" data-aos-duration="1000">
                    <img src="https://placehold.co/600x400/FAF7F0/A67B5B?text=Premium+Fabrics&font=montserrat"
                        alt="hero textile" class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- OUR PRODUCTS (main focus) -->
    <section id="products" class="py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="zoom-in">
                <h2 class="fw-bold text-dark-blue">Our signature <span class="text-maroon">products</span></h2>
                <p class="text-secondary">Handpicked fabrics & garments for every occasion</p>
            </div>
            <!-- responsive grid: 3 desktop, 2 tablet, 1 mobile -->
            <div class="row g-4">
                <!-- product card 1 (loop ready) -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="50">
                    <div class="card h-100 product-card shadow-sm border-0">
                        <img src="https://placehold.co/600x400/f5ebe0/A67B5B?text=Cotton+Saree" class="card-img-top"
                            alt="Cotton Saree">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">Cotton Saree</h5>
                            <p class="card-text small text-secondary">Handwoven cotton, breathable, traditional borders.
                            </p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="h5 fw-bold text-maroon">$49.99</span>
                                <span class="text-dark-blue"><i class="bi bi-star-fill text-warning me-1"></i>4.8</span>
                            </div>
                            <a href="product-details.html?id=1" class="btn btn-outline-maroon w-100">View details <i
                                    class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
                <!-- product card 2 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 product-card shadow-sm border-0">
                        <img src="https://placehold.co/600x400/f5e3d3/A1392F?text=Silk+Kurti" class="card-img-top"
                            alt="Silk Kurti">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">Silk Kurti</h5>
                            <p class="card-text small text-secondary">Pure Banarasi silk, festive embroidery.</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="h5 fw-bold text-maroon">$89.99</span>
                                <span class="text-dark-blue"><i class="bi bi-star-fill text-warning me-1"></i>4.9</span>
                            </div>
                            <a href="product-details.html?id=2" class="btn btn-outline-maroon w-100">View details <i
                                    class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
                <!-- product card 3 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="150">
                    <div class="card h-100 product-card shadow-sm border-0">
                        <img src="https://placehold.co/600x400/EDE7DC/A67B5B?text=Linen+Shirt" class="card-img-top"
                            alt="Linen Shirt">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">Linen Shirt</h5>
                            <p class="card-text small text-secondary">Premium Belgian linen, regular fit, 4 colors.</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="h5 fw-bold text-maroon">$59.99</span>
                                <span class="text-dark-blue"><i class="bi bi-star-fill text-warning me-1"></i>4.7</span>
                            </div>
                            <a href="product-details.html?id=3" class="btn btn-outline-maroon w-100">View details <i
                                    class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
                <!-- product card 4 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 product-card shadow-sm border-0">
                        <img src="https://placehold.co/600x400/F3E9DE/2C3E50?text=Denim+Jacket" class="card-img-top"
                            alt="Denim Jacket">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">Selvedge Denim Jacket</h5>
                            <p class="card-text small text-secondary">Raw denim, unisex, brass buttons.</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="h5 fw-bold text-maroon">$129.99</span>
                                <span class="text-dark-blue"><i class="bi bi-star-fill text-warning me-1"></i>4.8</span>
                            </div>
                            <a href="product-details.html?id=4" class="btn btn-outline-maroon w-100">View details <i
                                    class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
                <!-- product card 5 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="250">
                    <div class="card h-100 product-card shadow-sm border-0">
                        <img src="https://placehold.co/600x400/f1e2d4/8B5A2B?text=Wool+Blend+Blazer"
                            class="card-img-top" alt="Wool Blazer">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">Wool Blend Blazer</h5>
                            <p class="card-text small text-secondary">Italian merino, tailored fit, autumn collection.
                            </p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="h5 fw-bold text-maroon">$199.99</span>
                                <span class="text-dark-blue"><i class="bi bi-star-fill text-warning me-1"></i>4.9</span>
                            </div>
                            <a href="product-details.html?id=5" class="btn btn-outline-maroon w-100">View details <i
                                    class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
                <!-- product card 6 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 product-card shadow-sm border-0">
                        <img src="https://placehold.co/600x400/F7F3EE/962715?text=Printed+Maxi" class="card-img-top"
                            alt="Printed Maxi Dress">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">Printed Maxi Dress</h5>
                            <p class="card-text small text-secondary">Viscose crepe, floral print, adjustable straps.
                            </p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="h5 fw-bold text-maroon">$79.99</span>
                                <span class="text-dark-blue"><i class="bi bi-star-fill text-warning me-1"></i>4.6</span>
                            </div>
                            <a href="product-details.html?id=6" class="btn btn-outline-maroon w-100">View details <i
                                    class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY CHOOSE US (with soft gradient) -->
    <section id="why" class="py-5 bg-cream-gradient">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-down">
                <h2 class="fw-bold text-dark-blue">Why <span class="text-maroon">NexusTex</span></h2>
                <p class="text-secondary">Craftsmanship, ethics, and innovation at every step.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="flip-left" data-aos-delay="50">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <i class="bi bi-droplet fs-1 text-maroon"></i>
                        <h5 class="mt-3">Eco-friendly dyes</h5>
                        <p class="text-secondary small">Low-impact, azo-free dyes & sustainable water processing.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="flip-left" data-aos-delay="100">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <i class="bi bi-hand-thumbs-up fs-1 text-maroon"></i>
                        <h5 class="mt-3">Ethical sourcing</h5>
                        <p class="text-secondary small">Direct trade with farmers, fair wages for artisans.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="flip-left" data-aos-delay="150">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <i class="bi bi-truck fs-1 text-maroon"></i>
                        <h5 class="mt-3">Global shipping</h5>
                        <p class="text-secondary small">Express delivery to 50+ countries, easy returns.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CLIENT TESTIMONIALS SLIDER (Bootstrap carousel) -->
    <section class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center fw-bold text-dark-blue mb-4" data-aos="zoom-in">What our clients say</h2>
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row justify-content-center">
                            <div class="col-md-8 text-center">
                                <i class="bi bi-quote fs-1 text-maroon opacity-50"></i>
                                <p class="lead">"Incredible fabric quality and professional service. Our summer
                                    collection sold out thanks to NexusTex."</p>
                                <h6 class="fw-bold">— Priya K., Fashion Designer</h6>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-md-8 text-center">
                                <i class="bi bi-quote fs-1 text-maroon opacity-50"></i>
                                <p class="lead">"The linen shirt fabric is unmatched. We've partnered with them for 5+
                                    years."</p>
                                <h6 class="fw-bold">— Marco V., Brand Owner</h6>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-md-8 text-center">
                                <i class="bi bi-quote fs-1 text-maroon opacity-50"></i>
                                <p class="lead">"Fast shipping, great communication, and the silk sarees are exquisite."
                                </p>
                                <h6 class="fw-bold">— Aisha M., Boutique Owner</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-maroon rounded-circle" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-maroon rounded-circle" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- FOOTER with contact details -->
    <footer id="contact" class="bg-dark-blue text-white pt-5 pb-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="fw-bold"><i class="bi bi-scissors me-2 text-maroon"></i>NexusTex</h5>
                    <p class="small text-white-50">Premium textile manufacturer since 1985. We bring fabric to life.</p>
                    <p><i class="bi bi-geo-alt-fill me-2 text-maroon"></i> 42 Weaving St, Manchester, UK</p>
                    <p><i class="bi bi-telephone-fill me-2 text-maroon"></i> +44 161 234 5678</p>
                    <p><i class="bi bi-envelope-fill me-2 text-maroon"></i> hello@nexustex.com</p>
                </div>
                <div class="col-md-2">
                    <h6>Quick links</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none">About</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Products</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Sustainability</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6>Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none">FAQ</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Shipping</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Returns</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>Follow us</h6>
                    <i class="bi bi-facebook me-3 fs-4"></i>
                    <i class="bi bi-instagram me-3 fs-4"></i>
                    <i class="bi bi-linkedin fs-4"></i>
                    <hr class="mt-3">
                    <p class="small mb-0">© 2025 NexusTex. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS + AOS init + custom hover etc -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 800, easing: 'ease-in-out' });
    </script>
</body>

</html>
<div class="top-header">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-4 col-md-12">
                <ul class="header-contact-info">
                    <li>Welcome to Textile</li>
                    <li>Call: <a href="tel:+01321654214">+01 321 654 214</a></li>
                    <li>
                        <div class="dropdown language-switcher d-inline-block">
                            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <img src="{{ asset('website/assets/img/us-flag.jpg') }}" alt="image">
                                <span>Eng <i class='bx bx-chevron-down'></i></span>
                            </button>

                            <div class="dropdown-menu">
                                <a href="#" class="dropdown-item d-flex align-items-center">
                                    <img src="{{ asset('website/assets/img/germany-flag.jpg') }}" class="shadow-sm" alt="flag">
                                    <span>Ger</span>
                                </a>
                                <a href="#" class="dropdown-item d-flex align-items-center">
                                    <img src="{{ asset('website/assets/img/france-flag.jpg') }}" class="shadow-sm" alt="flag">
                                    <span>Fre</span>
                                </a>
                                <a href="#" class="dropdown-item d-flex align-items-center">
                                    <img src="{{ asset('website/assets/img/spain-flag.jpg') }}" class="shadow-sm" alt="flag">
                                    <span>Spa</span>
                                </a>
                                <a href="#" class="dropdown-item d-flex align-items-center">
                                    <img src="{{ asset('website/assets/img/russia-flag.jpg') }}" class="shadow-sm" alt="flag">
                                    <span>Rus</span>
                                </a>
                                <a href="#" class="dropdown-item d-flex align-items-center">
                                    <img src="{{ asset('website/assets/img/italy-flag.jpg') }}" class="shadow-sm" alt="flag">
                                    <span>Ita</span>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="top-header-discount-info">
                    <p><strong>50% OFF</strong> all new collections! <a href="#">Discover Now!</a></p>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <ul class="header-top-menu">
                    <li><a href="{{ route('login') }}" target="_blank"><i class='bx bx-log-in'></i> Login</a></li>
                </ul>

                <ul class="header-top-others-option">
                    <div class="option-item">
                        <div class="search-btn-box">
                            <i class="search-btn bx bx-search-alt"></i>
                        </div>
                    </div>

                    <div class="option-item">
                        <div class="cart-btn">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#shoppingCartModal"><i
                                    class='bx bx-shopping-bag'></i><span>0</span></a>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Top Header Area -->

<!-- Start Navbar Area -->
<div class="navbar-area">
    <div class="xton-responsive-nav">
        <div class="container">
            <div class="xton-responsive-menu">
                <div class="logo">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('website/assets/img/logo.png') }}" class="main-logo" alt="logo">
                        <img src="{{ asset('website/assets/img/white-logo.png') }}" class="white-logo" alt="logo">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="xton-nav">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="{{ route('index') }}">
                    <img src="{{ asset('website/assets/img/logo.png') }}" class="main-logo" alt="logo">
                    <img src="{{ asset('website/assets/img/white-logo.png') }}" class="white-logo" alt="logo">
                </a>

                <div class="collapse navbar-collapse mean-menu">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('index') }}" class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}">Home</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('products') }}" class="nav-link {{ request()->routeIs('products', 'website.products.show') ? 'active' : '' }}">
                                Product <i class='bx bx-chevron-down'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a href="{{ route('products', ['category' => 'male']) }}" class="nav-link {{ request()->routeIs('products') && request('category') === 'male' ? 'active' : '' }}">Men</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('products', ['category' => 'female']) }}" class="nav-link {{ request()->routeIs('products') && request('category') === 'female' ? 'active' : '' }}">Women</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="{{ route('products', ['category' => 'kids']) }}" class="nav-link {{ request()->routeIs('products') && request('category') === 'kids' ? 'active' : '' }}">Kids</a>
                                </li> --}}
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('blog') }}" class="nav-link {{ request()->routeIs('blog') ? 'active' : '' }}">Blog</a>
                        </li>
                    </ul>

                    <div class="others-option">
                        <div class="option-item">
                            <div class="search-btn-box">
                                <i class="search-btn bx bx-search-alt"></i>
                            </div>
                        </div>

                        <div class="option-item">
                            <div class="cart-btn">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#shoppingCartModal"><i
                                        class='bx bx-shopping-bag'></i><span>0</span></a>
                            </div>
                        </div>

                        <div class="option-item">
                            <div class="burger-menu" data-bs-toggle="modal" data-bs-target="#sidebarModal">
                                <span class="top-bar"></span>
                                <span class="middle-bar"></span>
                                <span class="bottom-bar"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

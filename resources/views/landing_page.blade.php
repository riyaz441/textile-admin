<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gold Shop - {{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #696cff;
            --primary-dark: #5254cc;
            --primary-light: #8385ff;
            --gold: #d4a853;
            --gold-light: #e8c97a;
            --gold-dark: #b8923e;
            --dark: #1a1a2e;
            --darker: #0f0f1a;
            --light: #f8f9fa;
            --gray: #6c757d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--darker);
            color: #fff;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: 'Playfair Display', serif;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--darker);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        /* Navbar */
        .navbar-custom {
            background: rgba(15, 15, 26, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(105, 108, 255, 0.1);
            padding: 15px 0;
            transition: all 0.4s ease;
        }

        .navbar-custom.scrolled {
            padding: 8px 0;
            box-shadow: 0 4px 30px rgba(105, 108, 255, 0.15);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--gold), var(--gold-light), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-brand i {
            background: linear-gradient(135deg, var(--gold), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.75) !important;
            font-weight: 500;
            font-size: 0.95rem;
            margin: 0 8px;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--gold));
            transition: width 0.3s ease;
            border-radius: 2px;
        }

        .nav-link:hover {
            color: #fff !important;
        }

        .nav-link:hover::after {
            width: 70%;
        }

        .btn-nav {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff !important;
            border: none;
            padding: 8px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(105, 108, 255, 0.3);
        }

        .btn-nav:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(105, 108, 255, 0.4);
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--darker) 0%, var(--dark) 50%, rgba(105, 108, 255, 0.05) 100%);
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 80%;
            height: 150%;
            background: radial-gradient(ellipse, rgba(105, 108, 255, 0.08) 0%, transparent 70%);
            animation: heroGlow 8s ease-in-out infinite alternate;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -20%;
            width: 60%;
            height: 80%;
            background: radial-gradient(ellipse, rgba(212, 168, 83, 0.06) 0%, transparent 70%);
            animation: heroGlow 10s ease-in-out infinite alternate-reverse;
        }

        @keyframes heroGlow {
            0% {
                transform: translate(0, 0) scale(1);
            }

            100% {
                transform: translate(30px, -20px) scale(1.1);
            }
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(105, 108, 255, 0.1);
            border: 1px solid rgba(105, 108, 255, 0.2);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--primary-light);
            margin-bottom: 24px;
            animation: fadeInUp 0.8s ease forwards;
        }

        .hero-badge i {
            color: var(--gold);
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 24px;
            animation: fadeInUp 0.8s ease 0.2s forwards;
            opacity: 0;
        }

        .hero-title .highlight {
            background: linear-gradient(135deg, var(--gold), var(--gold-light), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }

        .hero-title .highlight-purple {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-description {
            font-size: 1.15rem;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.8;
            margin-bottom: 40px;
            max-width: 520px;
            animation: fadeInUp 0.8s ease 0.4s forwards;
            opacity: 0;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s ease 0.6s forwards;
            opacity: 0;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            border: none;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.4s ease;
            box-shadow: 0 8px 30px rgba(105, 108, 255, 0.35);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(105, 108, 255, 0.5);
            color: #fff;
        }

        .btn-outline-custom {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(212, 168, 83, 0.4);
            padding: 14px 36px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.4s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-outline-custom:hover {
            background: rgba(212, 168, 83, 0.1);
            border-color: var(--gold);
            color: var(--gold-light);
            transform: translateY(-3px);
        }

        .hero-stats {
            display: flex;
            gap: 40px;
            margin-top: 60px;
            animation: fadeInUp 0.8s ease 0.8s forwards;
            opacity: 0;
        }

        .hero-stat {
            text-align: center;
        }

        .hero-stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--gold), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-stat-label {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 4px;
        }

        .hero-image-wrapper {
            position: relative;
            z-index: 2;
            animation: fadeInRight 1s ease 0.4s forwards;
            opacity: 0;
        }

        .hero-image-container {
            position: relative;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .hero-ring {
            width: 400px;
            height: 400px;
            border-radius: 50%;
            border: 2px solid rgba(105, 108, 255, 0.15);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: ringRotate 20s linear infinite;
        }

        .hero-ring::before {
            content: '';
            position: absolute;
            top: -5px;
            left: 50%;
            width: 10px;
            height: 10px;
            background: var(--primary);
            border-radius: 50%;
            box-shadow: 0 0 20px var(--primary);
        }

        .hero-ring-2 {
            width: 340px;
            height: 340px;
            border-color: rgba(212, 168, 83, 0.12);
            animation: ringRotate 15s linear infinite reverse;
        }

        .hero-ring-2::before {
            background: var(--gold);
            box-shadow: 0 0 20px var(--gold);
        }

        @keyframes ringRotate {
            from {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .hero-gold-item {
            width: 300px;
            height: 300px;
            position: relative;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: float 6s ease-in-out infinite;
        }

        .hero-gold-item i {
            font-size: 8rem;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold), var(--gold-light), #fff5cc, var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 20px 40px rgba(212, 168, 83, 0.3));
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            25% {
                transform: translateY(-15px) rotate(2deg);
            }

            75% {
                transform: translateY(10px) rotate(-2deg);
            }
        }

        /* Floating particles */
        .particles {
            position: absolute;
            inset: 0;
            overflow: hidden;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: var(--gold);
            border-radius: 50%;
            opacity: 0;
            animation: particleFloat linear infinite;
        }

        @keyframes particleFloat {
            0% {
                opacity: 0;
                transform: translateY(100vh) scale(0);
            }

            10% {
                opacity: 0.6;
            }

            90% {
                opacity: 0.2;
            }

            100% {
                opacity: 0;
                transform: translateY(-10vh) scale(1);
            }
        }

        /* Section Styling */
        .section-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .section-subtitle {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.5);
            max-width: 600px;
            margin: 0 auto 60px;
            line-height: 1.7;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(105, 108, 255, 0.1);
            border: 1px solid rgba(105, 108, 255, 0.2);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--primary-light);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        /* Products Section */
        .products-section {
            padding: 120px 0;
            position: relative;
            background: linear-gradient(180deg, var(--darker), var(--dark), var(--darker));
        }

        .product-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            margin-bottom: 30px;
        }

        .product-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 24px;
            padding: 1px;
            background: linear-gradient(135deg, rgba(105, 108, 255, 0), rgba(212, 168, 83, 0));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            transition: all 0.5s ease;
        }

        .product-card:hover::before {
            background: linear-gradient(135deg, rgba(105, 108, 255, 0.5), rgba(212, 168, 83, 0.5));
        }

        .product-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3), 0 0 40px rgba(105, 108, 255, 0.1);
        }

        .product-image {
            height: 280px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(105, 108, 255, 0.03), rgba(212, 168, 83, 0.05));
            position: relative;
            overflow: hidden;
        }

        .product-image::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40%;
            background: linear-gradient(to top, rgba(15, 15, 26, 0.9), transparent);
        }

        .product-image i {
            font-size: 5rem;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold), var(--gold-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 10px 20px rgba(212, 168, 83, 0.2));
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image i {
            transform: scale(1.1) rotate(5deg);
        }

        .product-tag {
            position: absolute;
            top: 16px;
            left: 16px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 2;
            box-shadow: 0 4px 12px rgba(105, 108, 255, 0.3);
        }

        .product-wishlist {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 50%;
            color: rgba(255, 255, 255, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .product-wishlist:hover {
            background: rgba(255, 59, 48, 0.2);
            color: #ff3b30;
        }

        .product-wishlist.active {
            background: rgba(255, 59, 48, 0.2);
            color: #ff3b30;
        }

        .product-info {
            padding: 24px;
        }

        .product-category {
            font-size: 0.8rem;
            color: var(--primary-light);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
        }

        .product-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #fff;
        }

        .product-rating {
            margin-bottom: 12px;
        }

        .product-rating i {
            color: var(--gold);
            font-size: 0.8rem;
        }

        .product-rating span {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.85rem;
            margin-left: 6px;
        }

        .product-price-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .product-price {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .product-old-price {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.35);
            text-decoration: line-through;
            margin-left: 8px;
        }

        .btn-add-cart {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: none;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(105, 108, 255, 0.3);
        }

        .btn-add-cart:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(105, 108, 255, 0.4);
        }

        /* Category filter tabs */
        .filter-tabs {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 50px;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 10px 28px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: transparent;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-tab:hover {
            border-color: rgba(105, 108, 255, 0.3);
            color: #fff;
        }

        .filter-tab.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 4px 15px rgba(105, 108, 255, 0.3);
        }

        /* Features Section */
        .features-section {
            padding: 100px 0;
            background: var(--darker);
            position: relative;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--gold));
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            border-color: rgba(105, 108, 255, 0.15);
            background: rgba(255, 255, 255, 0.04);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(105, 108, 255, 0.1), rgba(212, 168, 83, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            transition: all 0.4s ease;
        }

        .feature-icon i {
            font-size: 1.8rem;
            background: linear-gradient(135deg, var(--primary), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .feature-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .feature-description {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.7;
        }

        /* Testimonials Section */
        .testimonials-section {
            padding: 120px 0;
            background: linear-gradient(180deg, var(--darker), var(--dark));
            position: relative;
        }

        .testimonial-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 24px;
            padding: 40px;
            margin-bottom: 30px;
            transition: all 0.4s ease;
            position: relative;
        }

        .testimonial-card:hover {
            transform: translateY(-8px);
            border-color: rgba(105, 108, 255, 0.15);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        }

        .testimonial-quote {
            position: absolute;
            top: 24px;
            right: 30px;
            font-size: 4rem;
            background: linear-gradient(135deg, rgba(105, 108, 255, 0.1), rgba(212, 168, 83, 0.1));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-family: 'Playfair Display', serif;
            line-height: 1;
        }

        .testimonial-stars {
            margin-bottom: 20px;
        }

        .testimonial-stars i {
            color: var(--gold);
            font-size: 0.9rem;
            margin-right: 2px;
        }

        .testimonial-text {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.8;
            margin-bottom: 28px;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .testimonial-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--gold));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            color: #fff;
        }

        .testimonial-author-name {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 2px;
        }

        .testimonial-author-role {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.45);
        }

        .testimonial-verified {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: var(--primary-light);
            font-size: 0.8rem;
        }

        /* Big CTA Section */
        .cta-section {
            padding: 120px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-wrapper {
            background: linear-gradient(135deg, rgba(105, 108, 255, 0.15), rgba(212, 168, 83, 0.1));
            border: 1px solid rgba(105, 108, 255, 0.15);
            border-radius: 32px;
            padding: 80px 60px;
            position: relative;
            overflow: hidden;
        }

        .cta-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(105, 108, 255, 0.15) 0%, transparent 70%);
            animation: ctaGlow 6s ease-in-out infinite alternate;
        }

        .cta-wrapper::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(212, 168, 83, 0.1) 0%, transparent 70%);
            animation: ctaGlow 8s ease-in-out infinite alternate-reverse;
        }

        @keyframes ctaGlow {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.2);
            }
        }

        .cta-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .cta-text {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.6);
            max-width: 550px;
            margin: 0 auto 40px;
            line-height: 1.7;
            position: relative;
            z-index: 2;
        }

        .cta-buttons {
            position: relative;
            z-index: 2;
        }

        .btn-cta-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            border: none;
            padding: 18px 50px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.05rem;
            transition: all 0.4s ease;
            box-shadow: 0 8px 30px rgba(105, 108, 255, 0.4);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-cta-primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 50px rgba(105, 108, 255, 0.5);
            color: #fff;
        }

        .btn-cta-primary i {
            transition: transform 0.3s ease;
        }

        .btn-cta-primary:hover i {
            transform: translateX(4px);
        }

        /* Newsletter */
        .newsletter-form {
            max-width: 480px;
            margin: 30px auto 0;
            display: flex;
            gap: 12px;
            position: relative;
            z-index: 2;
        }

        .newsletter-form input {
            flex: 1;
            padding: 16px 24px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .newsletter-form input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .newsletter-form input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 20px rgba(105, 108, 255, 0.15);
        }

        .newsletter-form button {
            padding: 16px 32px;
            border-radius: 50px;
            border: none;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--darker);
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .newsletter-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 168, 83, 0.3);
        }

        /* Footer */
        .footer {
            background: var(--darker);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding: 80px 0 30px;
        }

        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--gold), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 16px;
        }

        .footer-description {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.45);
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .footer-social {
            display: flex;
            gap: 12px;
        }

        .footer-social a {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-social a:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            transform: translateY(-3px);
        }

        .footer h6 {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 24px;
            color: #fff;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.45);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .footer-links a:hover {
            color: var(--primary-light);
            transform: translateX(4px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 30px;
            margin-top: 60px;
        }

        .footer-bottom p {
            color: rgba(255, 255, 255, 0.3);
            font-size: 0.85rem;
            margin: 0;
        }

        .footer-bottom a {
            color: var(--primary-light);
            text-decoration: none;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .animate-on-scroll.animated {
            opacity: 1;
            transform: translateY(0);
        }

        /* Marquee */
        .marquee-section {
            padding: 30px 0;
            overflow: hidden;
            background: rgba(105, 108, 255, 0.03);
            border-top: 1px solid rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .marquee-content {
            display: flex;
            gap: 60px;
            animation: marquee 30s linear infinite;
            white-space: nowrap;
        }

        .marquee-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.25);
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .marquee-item i {
            color: var(--gold);
            opacity: 0.4;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        /* Price ticker */
        .price-ticker {
            background: rgba(105, 108, 255, 0.05);
            border: 1px solid rgba(105, 108, 255, 0.1);
            border-radius: 16px;
            padding: 20px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 50px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .ticker-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ticker-label {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .ticker-value {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--gold);
        }

        .ticker-change {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 50px;
        }

        .ticker-change.up {
            background: rgba(52, 199, 89, 0.1);
            color: #34c759;
        }

        .ticker-change.down {
            background: rgba(255, 59, 48, 0.1);
            color: #ff3b30;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 3rem;
            }

            .hero-image-wrapper {
                margin-top: 60px;
            }

            .hero-ring {
                width: 300px;
                height: 300px;
            }

            .hero-ring-2 {
                width: 250px;
                height: 250px;
            }

            .hero-gold-item {
                width: 230px;
                height: 230px;
            }

            .hero-gold-item i {
                font-size: 5rem;
            }

            .cta-wrapper {
                padding: 60px 30px;
            }

            .cta-title {
                font-size: 2.2rem;
            }

            .section-title {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-stats {
                gap: 24px;
            }

            .hero-stat-number {
                font-size: 1.6rem;
            }

            .newsletter-form {
                flex-direction: column;
            }

            .price-ticker {
                justify-content: center;
                text-align: center;
            }

            .cta-title {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .hero-stats {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        /* Back to top button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s ease;
            z-index: 999;
            box-shadow: 0 4px 15px rgba(105, 108, 255, 0.4);
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(105, 108, 255, 0.5);
        }

        /* Loading shimmer for price ticker */
        .shimmer {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.03) 25%, rgba(255, 255, 255, 0.06) 50%, rgba(255, 255, 255, 0.03) 75%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        /* Counter animation */
        .count-up {
            display: inline-block;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-gem me-2"></i>Gold Post
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#products">Collection</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Why Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Reviews</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
                <a href="{{ route('login') }}" class="btn btn-nav">
                    <i class="fas fa-lock me-1"></i> Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="particles" id="particles"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <div class="hero-badge">
                            <i class="fas fa-crown"></i>
                            Premium Gold Since 1998
                        </div>
                        <h1 class="hero-title">
                            Timeless<br>
                            <span class="highlight">Gold</span> for<br>
                            <span class="highlight-purple">Every Moment</span>
                        </h1>
                        <p class="hero-description">
                            Discover our exquisite collection of handcrafted gold jewelry,
                            coins, and bullion. Every piece tells a story of elegance and
                            enduring value.
                        </p>
                        <div class="hero-buttons">
                            <a href="#products" class="btn-primary-custom">
                                Explore Collection <i class="fas fa-arrow-right"></i>
                            </a>
                            <a href="#features" class="btn-outline-custom">
                                <i class="fas fa-play"></i> Our Story
                            </a>
                        </div>
                        <div class="hero-stats">
                            <div class="hero-stat">
                                <div class="hero-stat-number"><span class="count-up" data-target="25">0</span>+</div>
                                <div class="hero-stat-label">Years Experience</div>
                            </div>
                            <div class="hero-stat">
                                <div class="hero-stat-number"><span class="count-up" data-target="50">0</span>K+</div>
                                <div class="hero-stat-label">Happy Customers</div>
                            </div>
                            <div class="hero-stat">
                                <div class="hero-stat-number"><span class="count-up" data-target="999">0</span></div>
                                <div class="hero-stat-label">Purity Standard</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image-wrapper">
                        <div class="hero-image-container">
                            <div class="hero-ring"></div>
                            <div class="hero-ring hero-ring-2"></div>
                            <div class="hero-gold-item">
                                <i class="fas fa-ring"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Marquee -->
    <div class="marquee-section">
        <div class="marquee-content">
            <span class="marquee-item"><i class="fas fa-gem"></i> 24K Gold Jewelry</span>
            <span class="marquee-item"><i class="fas fa-star"></i> Premium Quality</span>
            <span class="marquee-item"><i class="fas fa-certificate"></i> BIS Hallmarked</span>
            <span class="marquee-item"><i class="fas fa-truck"></i> Free Shipping</span>
            <span class="marquee-item"><i class="fas fa-shield-halved"></i> Lifetime Exchange</span>
            <span class="marquee-item"><i class="fas fa-gem"></i> Investment Gold</span>
            <span class="marquee-item"><i class="fas fa-crown"></i> Bridal Collections</span>
            <span class="marquee-item"><i class="fas fa-gift"></i> Gift Wrapping</span>
            <span class="marquee-item"><i class="fas fa-gem"></i> 24K Gold Jewelry</span>
            <span class="marquee-item"><i class="fas fa-star"></i> Premium Quality</span>
            <span class="marquee-item"><i class="fas fa-certificate"></i> BIS Hallmarked</span>
            <span class="marquee-item"><i class="fas fa-truck"></i> Free Shipping</span>
            <span class="marquee-item"><i class="fas fa-shield-halved"></i> Lifetime Exchange</span>
            <span class="marquee-item"><i class="fas fa-gem"></i> Investment Gold</span>
            <span class="marquee-item"><i class="fas fa-crown"></i> Bridal Collections</span>
            <span class="marquee-item"><i class="fas fa-gift"></i> Gift Wrapping</span>
        </div>
    </div>

    <!-- Products Section -->
    <section class="products-section" id="products">
        <div class="container">
            <div class="text-center animate-on-scroll">
                <div class="section-badge">
                    <i class="fas fa-gem"></i> Our Collection
                </div>
                <h2 class="section-title">Curated Gold <span class="highlight">Masterpieces</span></h2>
                <p class="section-subtitle">
                    From timeless necklaces to contemporary rings, each piece is crafted with
                    precision and passion to become your treasured possession.
                </p>
            </div>

            <!-- Price Ticker -->
            <div class="price-ticker animate-on-scroll">
                <div class="ticker-item">
                    <div>
                        <div class="ticker-label">Gold 24K / oz</div>
                        <div class="ticker-value">$2,341.50</div>
                    </div>
                    <span class="ticker-change up"><i class="fas fa-arrow-up me-1"></i>1.2%</span>
                </div>
                <div class="ticker-item">
                    <div>
                        <div class="ticker-label">Gold 22K / oz</div>
                        <div class="ticker-value">$2,146.38</div>
                    </div>
                    <span class="ticker-change up"><i class="fas fa-arrow-up me-1"></i>0.8%</span>
                </div>
                <div class="ticker-item">
                    <div>
                        <div class="ticker-label">Gold 18K / oz</div>
                        <div class="ticker-value">$1,756.12</div>
                    </div>
                    <span class="ticker-change down"><i class="fas fa-arrow-down me-1"></i>0.3%</span>
                </div>
                <div class="ticker-item">
                    <div>
                        <div class="ticker-label">Silver / oz</div>
                        <div class="ticker-value">$27.45</div>
                    </div>
                    <span class="ticker-change up"><i class="fas fa-arrow-up me-1"></i>2.1%</span>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-tabs animate-on-scroll">
                <button class="filter-tab active" data-filter="all">All</button>
                <button class="filter-tab" data-filter="necklaces">Necklaces</button>
                <button class="filter-tab" data-filter="rings">Rings</button>
                <button class="filter-tab" data-filter="bracelets">Bracelets</button>
                <button class="filter-tab" data-filter="earrings">Earrings</button>
                <button class="filter-tab" data-filter="coins">Coins</button>
            </div>

            <!-- Product Grid -->
            <div class="row">
                <div class="col-lg-4 col-md-6 animate-on-scroll">
                    <div class="product-card">
                        <div class="product-image">
                            <span class="product-tag">Bestseller</span>
                            <button class="product-wishlist" onclick="toggleWishlist(this)">
                                <i class="far fa-heart"></i>
                            </button>
                            <i class="fas fa-crown"></i>
                        </div>
                        <div class="product-info">
                            <div class="product-category">Necklace</div>
                            <h4 class="product-name">Royal Heritage Necklace</h4>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(128)</span>
                            </div>
                            <div class="product-price-row">
                                <div>
                                    <span class="product-price">$4,299</span>
                                    <span class="product-old-price">$4,899</span>
                                </div>
                                <button class="btn-add-cart" title="Add to Cart">
                                    <i class="fas fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 animate-on-scroll">
                    <div class="product-card">
                        <div class="product-image">
                            <span class="product-tag"
                                style="background: linear-gradient(135deg, var(--gold), var(--gold-dark));">New</span>
                            <button class="product-wishlist" onclick="toggleWishlist(this)">
                                <i class="far fa-heart"></i>
                            </button>
                            <i class="fas fa-ring"></i>
                        </div>
                        <div class="product-info">
                            <div class="product-category">Ring</div>
                            <h4 class="product-name">Eternal Diamond Gold Ring</h4>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(95)</span>
                            </div>
                            <div class="product-price-row">
                                <div>
                                    <span class="product-price">$2,150</span>
                                </div>
                                <button class="btn-add-cart" title="Add to Cart">
                                    <i class="fas fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 animate-on-scroll">
                    <div class="product-card">
                        <div class="product-image">
                            <span class="product-tag"
                                style="background: linear-gradient(135deg, #ff3b30, #cc2e26);">-20%</span>
                            <button class="product-wishlist" onclick="toggleWishlist(this)">
                                <i class="far fa-heart"></i>
                            </button>
                            <i class="fas fa-link"></i>
                        </div>
                        <div class="product-info">
                            <div class="product-category">Bracelet</div>
                            <h4 class="product-name">Venetian Chain Bracelet</h4>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(204)</span>
                            </div>
                            <div class="product-price-row">
                                <div>
                                    <span class="product-price">$1,599</span>
                                    <span class="product-old-price">$1,999</span>
                                </div>
                                <button class="btn-add-cart" title="Add to Cart">
                                    <i class="fas fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 animate-on-scroll">
                    <div class="product-card">
                        <div class="product-image">
                            <button class="product-wishlist" onclick="toggleWishlist(this)">
                                <i class="far fa-heart"></i>
                            </button>
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="product-info">
                            <div class="product-category">Investment</div>
                            <h4 class="product-name">24K Gold Bullion Coin</h4>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(312)</span>
                            </div>
                            <div class="product-price-row">
                                <div>
                                    <span class="product-price">$2,350</span>
                                </div>
                                <button class="btn-add-cart" title="Add to Cart">
                                    <i class="fas fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 animate-on-scroll">
                    <div class="product-card">
                        <div class="product-image">
                            <span class="product-tag">Limited</span>
                            <button class="product-wishlist" onclick="toggleWishlist(this)">
                                <i class="far fa-heart"></i>
                            </button>
                            <i class="fas fa-ear-listen"></i>
                        </div>
                        <div class="product-info">
                            <div class="product-category">Earrings</div>
                            <h4 class="product-name">Celestial Drop Earrings</h4>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>(78)</span>
                            </div>
                            <div class="product-price-row">
                                <div>
                                    <span class="product-price">$899</span>
                                </div>
                                <button class="btn-add-cart" title="Add to Cart">
                                    <i class="fas fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 animate-on-scroll">
                    <div class="product-card">
                        <div class="product-image">
                            <span class="product-tag"
                                style="background: linear-gradient(135deg, var(--gold), var(--gold-dark));">Bridal</span>
                            <button class="product-wishlist" onclick="toggleWishlist(this)">
                                <i class="far fa-heart"></i>
                            </button>
                            <i class="fas fa-spa"></i>
                        </div>
                        <div class="product-info">
                            <div class="product-category">Set</div>
                            <h4 class="product-name">Maharani Bridal Set</h4>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(156)</span>
                            </div>
                            <div class="product-price-row">
                                <div>
                                    <span class="product-price">$12,499</span>
                                    <span class="product-old-price">$14,999</span>
                                </div>
                                <button class="btn-add-cart" title="Add to Cart">
                                    <i class="fas fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5 animate-on-scroll">
                <a href="#" class="btn-primary-custom">
                    View All Collection <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="text-center animate-on-scroll">
                <div class="section-badge">
                    <i class="fas fa-shield-halved"></i> Why Choose Us
                </div>
                <h2 class="section-title">The <span class="highlight-purple">Aureum</span> Promise</h2>
                <p class="section-subtitle">
                    With over 25 years of expertise, we deliver excellence in every piece.
                    Here's what sets us apart from the rest.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6 animate-on-scroll">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h5 class="feature-title">BIS Hallmarked</h5>
                        <p class="feature-description">
                            Every piece is BIS 916 hallmarked, guaranteeing authentic gold purity and quality you can
                            trust.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 animate-on-scroll">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <h5 class="feature-title">Lifetime Exchange</h5>
                        <p class="feature-description">
                            Enjoy 100% exchange value on all our gold jewelry, making your investment timeless and
                            flexible.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 animate-on-scroll">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-truck-fast"></i>
                        </div>
                        <h5 class="feature-title">Insured Delivery</h5>
                        <p class="feature-description">
                            Free insured shipping on all orders. Your precious purchase arrives safely at your doorstep.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 animate-on-scroll">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <h5 class="feature-title">Expert Craftsmanship</h5>
                        <p class="feature-description">
                            Each piece is handcrafted by master artisans with decades of experience in fine gold work.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section" id="testimonials">
        <div class="container">
            <div class="text-center animate-on-scroll">
                <div class="section-badge">
                    <i class="fas fa-heart"></i> Testimonials
                </div>
                <h2 class="section-title">Loved by <span class="highlight">Thousands</span></h2>
                <p class="section-subtitle">
                    Don't just take our word for it. Here's what our cherished customers
                    have to say about their Aureum experience.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6 animate-on-scroll">
                    <div class="testimonial-card">
                        <div class="testimonial-quote">"</div>
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">
                            "The Royal Heritage Necklace exceeded all my expectations. The craftsmanship is absolutely
                            stunning, and the gold quality is impeccable. My go-to gold shop from now on!"
                        </p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">SK</div>
                            <div>
                                <div class="testimonial-author-name">Sarah K.</div>
                                <div class="testimonial-author-role">Loyal Customer since 2019</div>
                                <div class="testimonial-verified">
                                    <i class="fas fa-check-circle"></i> Verified Purchase
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 animate-on-scroll">
                    <div class="testimonial-card">
                        <div class="testimonial-quote">"</div>
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">
                            "Bought my wife the Maharani Bridal Set and she was speechless! The intricate detailing and
                            the way it catches light is just magical. Worth every penny."
                        </p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">RM</div>
                            <div>
                                <div class="testimonial-author-name">Rajesh M.</div>
                                <div class="testimonial-author-role">Gold Investor</div>
                                <div class="testimonial-verified">
                                    <i class="fas fa-check-circle"></i> Verified Purchase
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 animate-on-scroll">
                    <div class="testimonial-card">
                        <div class="testimonial-quote">"</div>
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="testimonial-text">
                            "The investment coins from Aureum have been a fantastic addition to my portfolio.
                            Transparent pricing, certified purity, and beautiful packaging. Highly recommended!"
                        </p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">EP</div>
                            <div>
                                <div class="testimonial-author-name">Emily P.</div>
                                <div class="testimonial-author-role">Premium Member</div>
                                <div class="testimonial-verified">
                                    <i class="fas fa-check-circle"></i> Verified Purchase
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="row mt-5 g-3 justify-content-center animate-on-scroll">
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2 px-4 py-3"
                        style="background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                        <i class="fas fa-star" style="color: var(--gold);"></i>
                        <span style="font-weight: 600;">4.9/5</span>
                        <span style="color: rgba(255,255,255,0.4); font-size: 0.85rem;">Average Rating</span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2 px-4 py-3"
                        style="background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                        <i class="fas fa-users" style="color: var(--primary-light);"></i>
                        <span style="font-weight: 600;">50K+</span>
                        <span style="color: rgba(255,255,255,0.4); font-size: 0.85rem;">Happy Customers</span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2 px-4 py-3"
                        style="background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                        <i class="fas fa-shield-halved" style="color: #34c759;"></i>
                        <span style="font-weight: 600;">100%</span>
                        <span style="color: rgba(255,255,255,0.4); font-size: 0.85rem;">Certified Gold</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="contact">
        <div class="container">
            <div class="cta-wrapper text-center animate-on-scroll">
                <div class="section-badge mb-4">
                    <i class="fas fa-sparkles"></i> Special Offer
                </div>
                <h2 class="cta-title">
                    Start Your Gold Journey <span class="highlight">Today</span>
                </h2>
                <p class="cta-text">
                    Join our exclusive membership and get 10% off on your first purchase,
                    early access to new collections, and personalized gold investment advice.
                </p>
                <div class="cta-buttons mb-4">
                    <a href="#" class="btn-cta-primary">
                        Start Shopping <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="newsletter-form">
                    <input type="email" placeholder="Enter your email address" id="newsletterEmail">
                    <button onclick="subscribeNewsletter()">Subscribe</button>
                </div>
                <p
                    style="font-size: 0.8rem; color: rgba(255,255,255,0.3); margin-top: 16px; position: relative; z-index: 2;">
                    <i class="fas fa-lock me-1"></i> We respect your privacy. Unsubscribe anytime.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <i class="fas fa-gem me-2"></i>Aureum
                    </div>
                    <p class="footer-description">
                        Crafting timeless gold pieces since 1998. Every creation carries our
                        commitment to quality, authenticity, and unmatched elegance.
                    </p>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-pinterest-p"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6>Quick Links</h6>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> Home</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> Collection</a>
                        </li>
                        <li><a href="#"><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> About Us</a>
                        </li>
                        <li><a href="#"><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> Blog</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i> Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6>Categories</h6>
                    <ul class="footer-links">
                        <li><a href="#">Necklaces</a></li>
                        <li><a href="#">Rings</a></li>
                        <li><a href="#">Bracelets</a></li>
                        <li><a href="#">Earrings</a></li>
                        <li><a href="#">Gold Coins</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h6>Get in Touch</h6>
                    <ul class="footer-links">
                        <li>
                            <a href="#"><i class="fas fa-map-marker-alt me-2" style="color: var(--primary-light);"></i>
                                123 Gold Street, Jewelry District, NY 10001</a>
                        </li>
                        <li>
                            <a href="tel:+1234567890"><i class="fas fa-phone me-2"
                                    style="color: var(--primary-light);"></i> +1 (234) 567-890</a>
                        </li>
                        <li>
                            <a href="mailto:hello@aureum.com"><i class="fas fa-envelope me-2"
                                    style="color: var(--primary-light);"></i> hello@aureum.com</a>
                        </li>
                        <li>
                            <a href="#"><i class="fas fa-clock me-2" style="color: var(--primary-light);"></i> Mon -
                                Sat: 10AM - 8PM</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom d-flex flex-wrap justify-content-between align-items-center">
                <p>&copy; 2024 Aureum Gold. All rights reserved. Crafted with <i class="fas fa-heart"
                        style="color: var(--primary);"></i></p>
                <p>
                    <a href="#">Privacy Policy</a> &middot;
                    <a href="#">Terms of Service</a> &middot;
                    <a href="#">Refund Policy</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Create floating particles
        function createParticles() {
            const container = document.getElementById('particles');
            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDuration = (Math.random() * 10 + 8) + 's';
                particle.style.animationDelay = (Math.random() * 10) + 's';
                particle.style.width = (Math.random() * 4 + 2) + 'px';
                particle.style.height = particle.style.width;
                if (Math.random() > 0.5) {
                    particle.style.background = '#696cff';
                }
                container.appendChild(particle);
            }
        }
        createParticles();

        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('mainNav');
            const backToTop = document.getElementById('backToTop');

            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            if (window.scrollY > 400) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry, index) {
                if (entry.isIntersecting) {
                    setTimeout(function () {
                        entry.target.classList.add('animated');
                    }, index * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-on-scroll').forEach(function (el) {
            observer.observe(el);
        });

        // Counter animation
        function animateCounters() {
            const counters = document.querySelectorAll('.count-up');
            counters.forEach(function (counter) {
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;

                function update() {
                    current += step;
                    if (current < target) {
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(update);
                    } else {
                        counter.textContent = target;
                    }
                }
                update();
            });
        }

        // Trigger counter animation when hero is in view
        const heroObserver = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) {
                setTimeout(animateCounters, 800);
                heroObserver.unobserve(entries[0].target);
            }
        });
        heroObserver.observe(document.querySelector('.hero-stats'));

        // Filter tabs
        document.querySelectorAll('.filter-tab').forEach(function (tab) {
            tab.addEventListener('click', function () {
                document.querySelectorAll('.filter-tab').forEach(function (t) {
                    t.classList.remove('active');
                });
                this.classList.add('active');

                // Add a subtle animation to product cards
                document.querySelectorAll('.product-card').forEach(function (card, index) {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(function () {
                        card.style.transition = 'all 0.5s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            });
        });

        // Wishlist toggle
        function toggleWishlist(btn) {
            btn.classList.toggle('active');
            const icon = btn.querySelector('i');
            if (btn.classList.contains('active')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
            }
        }

        // Newsletter subscription
        function subscribeNewsletter() {
            const email = document.getElementById('newsletterEmail').value;
            if (email && email.includes('@')) {
                const btn = document.querySelector('.newsletter-form button');
                btn.innerHTML = '<i class="fas fa-check"></i> Subscribed!';
                btn.style.background = 'linear-gradient(135deg, #34c759, #28a745)';
                setTimeout(function () {
                    btn.innerHTML = 'Subscribe';
                    btn.style.background = '';
                    document.getElementById('newsletterEmail').value = '';
                }, 3000);
            }
        }

        // Scroll to top
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Smooth scroll for nav links
        document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offset = 80;
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: targetPosition, behavior: 'smooth' });
                }

                // Close mobile menu
                const navCollapse = document.querySelector('.navbar-collapse');
                if (navCollapse.classList.contains('show')) {
                    bootstrap.Collapse.getInstance(navCollapse).hide();
                }
            });
        });

        // Add to cart button animation
        document.querySelectorAll('.btn-add-cart').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const icon = this.querySelector('i');
                icon.classList.remove('fa-shopping-bag');
                icon.classList.add('fa-check');
                this.style.background = 'linear-gradient(135deg, #34c759, #28a745)';

                setTimeout(function () {
                    icon.classList.remove('fa-check');
                    icon.classList.add('fa-shopping-bag');
                    btn.style.background = '';
                }, 2000);
            });
        });
    </script>
</body>

</html>

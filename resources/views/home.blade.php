@extends('layouts/app')

@section('title', 'Home')
@section('content')
    <section class="hero">
        <div class="hero-content">
            <h1>
                MON Magasin
            </h1>
            <p class="hero-subtitle">La meilleure boutique en ligne</p>
            <div class="hero-scroll-indicator">
                <span></span>
            </div>
        </div>
    </section>

    <section class="featured-products">
        <div class="section-header">
            <h2>Meilleures Ventes du Mois</h2>
            <div class="divider"></div>
        </div>

        <div class="categories">
            @foreach ($categories as $category)
                <div class="category-section">
                    <div class="category-header">
                        <h3>{{ $category->name }}</h3>
                        <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="view-all">Voir tout</a>
                        <div class="category-divider"></div>
                    </div>

                    <div class="products-grid">
                        @foreach ($category->products()->orderBy('sales', 'desc')->take(3)->get() as $product)
                            <div class="product-card">
                                <div class="product-badge">Top Vente</div>
                                <a href="{{ route('products.show', $product) }}" class="product-link">
                                    @if ($product->image)
                                        <div class="product-image-container">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                class="product-image">
                                            <div class="product-overlay">
                                                <span class="view-details">Voir Détails</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="product-image-placeholder">
                                            <i class="fas fa-camera"></i>
                                            <span>Pas d'image disponible</span>
                                        </div>
                                    @endif
                                    <div class="product-info">
                                        <h4>{{ $product->name }}</h4>
                                        <p class="price">{{ number_format($product->price, 2) }}€</p>
                                        @if ($product->reviewCount() > 0)
                                            <div class="product-rating">
                                                @php $avgRating = round($product->averageRating()) @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $avgRating)
                                                        ★
                                                    @else
                                                        ☆
                                                    @endif
                                                @endfor
                                                <span class="rating-count">({{ $product->reviewCount() }})</span>
                                            </div>
                                        @else
                                            <div class="no-rating">Pas encore noté</div>
                                        @endif
                                    </div>
                                </a>
                                @if (auth()->check())
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="add-to-cart">
                                            <span class="cart-icon"><i class="fas fa-shopping-cart"></i></span>
                                            <span class="cart-text">Ajouter au panier</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <style>
        /* Base Styles - Unchanged */
        :root {
            --primary: #6c5ce7;
            --primary-dark: #5649c0;
            --secondary: #00cec9;
            --dark: #2d3436;
            --light: #f5f6fa;
            --gray: #636e72;
            --success: #00b894;
            --warning: #fdcb6e;
            --danger: #d63031;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Hero Section - Unchanged */
        .hero {
            position: relative;
            height: 80vh;
            min-height: 500px;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-bottom: 4rem;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><polygon fill="rgba(255,255,255,0.03)" points="0,100 100,0 100,100"/></svg>');
            background-size: cover;
            opacity: 0.5;
        }

        .hero-content {
            text-align: center;
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            animation: fadeInUp 1s ease;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .highlight {
            color: var(--secondary);
            position: relative;
            display: inline-block;
        }

        .highlight::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            height: 10px;
            background: rgba(0, 206, 201, 0.3);
            z-index: -1;
            transform: scaleX(1.05);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
        }

        .hero-scroll-indicator span {
            display: block;
            width: 20px;
            height: 20px;
            border-bottom: 2px solid white;
            border-right: 2px solid white;
            transform: rotate(45deg);
            margin: -10px;
            animation: scrollAnimation 2s infinite;
            opacity: 0.7;
        }

        .hero-scroll-indicator span:nth-child(2) {
            animation-delay: -0.2s;
        }

        .hero-scroll-indicator span:nth-child(3) {
            animation-delay: -0.4s;
        }

        /* Featured Products */
        .featured-products {
            padding: 0 2rem;
            max-width: 1400px;
            margin: 0 auto 6rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--dark);
            position: relative;
            display: inline-block;
        }

        .divider {
            width: 80px;
            height: 4px;
            background: var(--primary);
            margin: 0 auto;
            border-radius: 2px;
        }

        /* Category Section */
        .category-section {
            margin-bottom: 5rem;
        }

        .view-all {
            font-size: 0.9rem;
            color: var(--primary);
            margin-left: 1rem;
            transition: color 0.3s ease;
        }

        .view-all:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .category-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .category-section h3 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }



        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
            z-index: 2;
        }

        .product-link {
            display: block;
            color: inherit;
        }

        .product-image-container {
            position: relative;
            width: 100%;
            height: 250px;
            overflow: hidden;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .view-details {
            color: white;
            font-weight: bold;
            padding: 0.5rem 1rem;
            border: 2px solid white;
            border-radius: 30px;
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .product-card:hover .view-details {
            transform: translateY(0);
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-image-placeholder {
            width: 100%;
            height: 250px;
            background: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--gray);
        }

        .product-image-placeholder i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-card h4 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
        }

        .price {
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--primary);
            margin-bottom: 0.75rem;
        }

        /* Product Rating */
        .product-rating {
            color: var(--warning);
            margin: 0.5rem 0;
            font-size: 0.9rem;
            letter-spacing: 2px;
        }

        .rating-count {
            color: var(--gray);
            font-size: 0.8rem;
            margin-left: 0.5rem;
        }

        .no-rating {
            color: #ccc;
            font-size: 0.9rem;
            margin: 0.5rem 0;
            font-style: italic;
        }

        /* Add to Cart Button */
        .add-to-cart {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 1rem;
            background: var(--primary);
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .add-to-cart:hover {
            background: var(--primary-dark);
        }

        .cart-icon {
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }

        .cart-text {
            font-size: 0.9rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scrollAnimation {
            0% {
                opacity: 0;
                transform: rotate(45deg) translate(-10px, -10px);
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: rotate(45deg) translate(10px, 10px);
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero h1 {
                font-size: 2.8rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 768px) {
            .hero {
                height: 70vh;
            }

            .hero h1 {
                font-size: 2.2rem;
            }

            .featured-products {
                padding: 0 1.5rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 480px) {
            .hero {
                height: 60vh;
                min-height: 400px;
            }

            .hero h1 {
                font-size: 1.8rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .section-header h2 {
                font-size: 2rem;
            }

            .featured-products {
                padding: 0 1rem;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

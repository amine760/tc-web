<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- CSS remains exactly the same -->
    <style>
        /* Navbar Styles */
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 1rem 0;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #6c5ce7;
            text-decoration: none;
            order: 2;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            order: 1;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center;
            order: 1;
            flex: 1;
        }

        .nav-links a {
            color: #2d3436;
            font-weight: 500;
            transition: color 0.3s ease;
            text-decoration: none;
        }

        .nav-links a:hover {
            color: #6c5ce7;
        }

        .cart-count {
            background-color: #6c5ce7;
            color: white;
            border-radius: 50%;
            padding: 0.2rem 0.5rem;
            font-size: 0.8rem;
            margin-left: 0.3rem;
        }

        /* Footer Styles */
        footer {
            background-color: #4600a7;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        footer .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        footer p {
            margin: 0;
            color: rgba(255, 255, 255, 0.8);
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-links a {
            color: white;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: #6c5ce7;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
                order: 1;
            }

            .logo {
                order: 2;
                margin-left: auto;
            }

            .nav-links {
                display: none;
                flex-direction: column;
                width: 100%;
                padding: 1rem 0;
                gap: 1rem;
                order: 3;
            }

            .nav-links.active {
                display: flex;
            }

            nav {
                gap: 1rem;
            }

            footer .container {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <nav>
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="nav-links" id="navLinks">
                    <!-- Reordered and translated navigation -->
                    <li><a href="{{ route('shop.index') }}">Boutique</a></li>
                    <li><a href="{{ route('gallery.index') }}">Salons</a></li>

                    @guest
                        <li><a href="{{ route('login') }}">Connexion</a></li>
                        <li><a href="{{ route('register') }}">Inscription</a></li>
                    @else
                        @if (auth()->user()->isAdmin())
                            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('admin.users') }}">Utilisateurs</a></li>
                            <li><a href="{{ route('admin.products.pending') }}">Produits en attente</a>
                            </li>
                            <li><a href="{{ route('admin.gallery.pending') }}">Salons en attente</a>
                            </li>
                        @endif
                        @if (auth()->user()->isItCommercial())
                            <li><a href="{{ route('products.create') }}">Ajouter un produit</a></li>
                            <li><a href="{{ route('gallery.create') }}">Ajouter un Salon</a></li>
                        @endif
                        <li><a href="{{ route('orders.index') }}">Commandes</a></li>
                        <li><a href="{{ route('profile.edit') }}">Profil</a></li>
                        <li><a href="{{ route('cart.index') }}">
                                Panier
                                @if (count((array) session('cart')))
                                    <span class="cart-count">{{ count((array) session('cart')) }}</span>
                                @endif
                            </a></li>
                    @endguest
                </ul>
                <a href="{{ route('home') }}" class="logo">{{ config('app.name', 'Laravel') }}</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Tous droits réservés.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('active');
        });
    </script>
</body>

</html>

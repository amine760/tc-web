@extends('layouts/app')

@section('title', 'Boutique')
@section('content')
    <section class="shop-container">
        <div class="shop-header">
            <h1>Nos Produits</h1>

            <div class="category-links">
                <a href="{{ route('shop.index') }}" class="category-link {{ request('category') == null ? 'active' : '' }}">
                    Toutes les catégories
                </a>

                @foreach ($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->id]) }}"
                        class="category-link {{ request('category') == $category->id ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>


        <div id="products-container" class="products-grid">
            @forelse ($products as $product)
                <div class="product-card">
                    <a href="{{ route('products.show', $product) }}" class="product-link">
                        @if ($product->image)
                            <div class="product-image-container">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="product-image">
                                <div class="product-overlay">
                                    <span class="view-details">Voir détails</span>
                                </div>
                            </div>
                        @else
                            <div class="product-image-placeholder">
                                <i class="fas fa-camera"></i>
                                <span>Pas d'image</span>
                            </div>
                        @endif
                        <div class="product-info">
                            <h4>{{ $product->name }}</h4>
                            <p class="price">{{ number_format($product->price) }}€</p>
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
                    @if (auth()->check() && auth()->user()->isItCommercial())
                        <div class="product-actions">
                            <a href="{{ route('products.edit', $product->id) }}" class="action-btn edit-btn">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn"
                                    onclick="return confirm('Êtes-vous sûr ?')">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <div class="no-products">
                    <img src="{{ asset('images/empty-state.svg') }}" alt="Aucun produit" class="empty-state-img">
                    <p>Aucun produit trouvé dans cette catégorie.</p>
                    <a href="{{ route('shop.index') }}" class="btn-primary">Voir tous les produits</a>
                </div>
            @endforelse
        </div>

    </section>

    <script>
        $('.category-link').on('click', function(e) {
            e.preventDefault();

            let url = $(this).attr('href');

            // Update active class
            $('.category-link').removeClass('active');
            $(this).addClass('active');

            // Fetch and replace the product grid
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    $('#products-container').fadeOut(200, function() {
                        let newContent = $(response).find('#products-container').html();
                        $(this).html(newContent).fadeIn(200);
                    });
                },
                error: function() {
                    alert('Erreur lors du chargement des produits.');
                }
            });
        });
    </script>


    <style>
        /* Shop Container */
        .shop-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        /* Shop Header */
        .shop-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .category-links {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .category-link {
            text-decoration: none;
            padding: 0.5rem 1rem;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .category-link:hover {
            background-color: #f5f5f5;
            border-color: #888;
        }

        .category-link.active {
            background-color: #6c5ce7;
            color: #fff;
            border-color: #fff;
        }


        .shop-header h1 {
            font-size: 2.2rem;
            color: #2d3436;
            margin: 0;
        }

        /* Category Filter */
        .category-filter {
            position: relative;
            min-width: 250px;
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper select {
            appearance: none;
            width: 100%;
            padding: 0.8rem 1rem;
            padding-right: 2.5rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: white;
            font-size: 1rem;
            color: #2d3436;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .select-wrapper select:focus {
            outline: none;
            border-color: #6c5ce7;
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2);
        }

        .select-arrow {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            pointer-events: none;
            color: #636e72;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        /* Product Card */
        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #6c5ce7;
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
            height: 200px;
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
            height: 200px;
            background: #f5f6fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #636e72;
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
            color: #2d3436;
        }

        .price {
            font-size: 1.25rem;
            font-weight: bold;
            color: #6c5ce7;
            margin-bottom: 0.75rem;
        }

        /* Product Rating */
        .product-rating {
            color: #fdcb6e;
            margin: 0.5rem 0;
            font-size: 0.9rem;
            letter-spacing: 2px;
        }

        .rating-count {
            color: #636e72;
            font-size: 0.8rem;
            margin-left: 0.5rem;
        }

        .no-rating {
            color: #ccc;
            font-size: 0.9rem;
            margin: 0.5rem 0;
            font-style: italic;
        }

        /* Product Actions */
        .product-actions {
            display: flex;
            border-top: 1px solid #f0f0f0;
            padding: 0.75rem;
            gap: 0.5rem;
        }

        .action-btn {
            flex: 1;
            padding: 0.5rem;
            border: none;
            border-radius: 6px;
            font-size: 0.8rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .edit-btn {
            background: #f0f0f0;
            color: #2d3436;
        }

        .edit-btn:hover {
            background: #e0e0e0;
        }

        .delete-btn {
            background: #ffecec;
            color: #d63031;
        }

        .delete-btn:hover {
            background: #ffdada;
        }

        /* No Products */
        .no-products {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem 0;
        }

        .empty-state-img {
            width: 200px;
            height: auto;
            margin-bottom: 1.5rem;
            opacity: 0.7;
        }

        .no-products p {
            font-size: 1.1rem;
            color: #636e72;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #6c5ce7;
            color: white;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #5649c0;
            transform: translateY(-2px);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        .pagination .pagination {
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .shop-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .category-filter {
                width: 100%;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
        }

        @media (max-width: 480px) {
            .products-grid {
                grid-template-columns: 1fr;
            }

            .shop-container {
                padding: 0 1rem;
            }
        }
    </style>
@endsection

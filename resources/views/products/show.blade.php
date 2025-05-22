@extends('layouts.app')

@section('title', $product->name)
@section('content')
    <div class="product-detail-container">
        <div class="product-gallery">
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="main-image">
            @else
                <div class="image-placeholder">
                    <i class="fas fa-camera"></i>
                    <span>Pas d'images</span>
                </div>
            @endif
        </div>

        <div class="product-content">
            <div class="product-header">
                <h1>{{ $product->name }}</h1>
                <div class="price">$<span id="product-price">{{ number_format($product->price) }}</span></div>
                <div class="product-meta">
                    <span class="availability">Disponible</span>
                </div>
            </div>

            <div class="product-description">
                <h3>Details</h3>
                <p>{{ $product->description }}</p>
            </div>

            @auth
                <div class="product-actions">
                    <form action="{{ route('cart.add', $product) }}" method="POST" id="add-to-cart-form">
                        @csrf
                        <div class="quantity-selector">
                            <label>Quantité</label>
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn" id="decrease-qty">-</button>
                                <input type="number" id="quantity" name="quantity" min="1" value="1"
                                    class="quantity-input">
                                <button type="button" class="quantity-btn" id="increase-qty">+</button>
                            </div>
                        </div>

                        <div class="total-display">
                            <span>Prix total:</span>
                            <span class="amount">$<span id="total-price">{{ number_format($product->price) }}</span></span>
                        </div>

                        <button type="submit" class="action-btn add-to-cart">
                            <i class="fas fa-bag-shopping"></i> Ajouter au panier

                        </button>
                    </form>
                </div>
            @else
                <div class="auth-prompt">
                    <a href="{{ route('login') }}" class="auth-link">Se connecter</a>
                </div>
            @endauth

            <div class="product-features">
                <div class="feature">
                    <i class="fas fa-truck"></i>
                    <span>Livraison gratuite</span>
                </div>
                <div class="feature">
                    <i class="fas fa-undo"></i>
                    <span>Retour facile sous 30 jours</span>
                </div>
                <div class="feature">
                    <i class="fas fa-shield-alt"></i>
                    <span>Paiment a la livraison</span>
                </div>
            </div>
        </div>
    </div>

    @auth
        <div class="product-reviews">
            <div class="reviews-header">
                <h2>Avis clients</h2>
                <div class="rating-summary">
                    <div class="stars">
                        @php $avgRating = $product->reviews->avg('rating') ?? 0; @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($avgRating))
                                ★
                            @elseif ($i - 0.5 <= $avgRating)
                                ½
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>
                    <span class="average">{{ number_format($avgRating, 1) }} sur 5</span>
                    <span class="count">({{ $product->reviews->count() }} Avis)</span>
                </div>
            </div>

            <div class="review-form-container">
                <h3>Donnez votre avis</h3>
                <form action="{{ route('reviews.store', $product) }}" method="POST" class="review-form">
                    @csrf
                    <div class="form-group">
                        <label>Evalutation</label>
                        <div class="star-rating">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                                    {{ old('rating') == $i ? 'checked' : '' }}>
                                <label for="star{{ $i }}">★</label>
                            @endfor
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment">Commentaire</label>
                        <textarea id="comment" name="comment" placeholder="Commentaire..." rows="4">{{ old('comment') }}</textarea>
                    </div>
                    <button type="submit" class="submit-review">Evaluer</button>
                </form>
            </div>

            <div class="reviews-grid">
                @foreach ($product->reviews()->with('user')->latest()->get() as $review)
                    <div class="review-card">
                        <div class="reviewer-info">
                            <div class="avatar">{{ substr($review->user->name, 0, 1) }}</div>
                            <div class="reviewer-meta">
                                <span class="name">{{ $review->user->nom }}</span>
                                <span class="date">{{ $review->created_at->format('F j, Y') }}</span>
                            </div>
                        </div>
                        <div class="review-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review->rating)
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </div>
                        @if ($review->comment)
                            <div class="review-text">{{ $review->comment }}</div>
                        @endif
                    </div>
                @endforeach

                @if ($product->reviews->isEmpty())
                    <div class="no-reviews">
                        <i class="fas fa-comment-slash"></i>
                        <p>No reviews yet. Be the first to review this product!</p>
                    </div>
                @endif
            </div>
        </div>
    @endauth

    <style>
        :root {
            --primary: #3a0ca3;
            --primary-light: #4cc9f0;
            --secondary: #f72585;
            --dark: #14213d;
            --light: #f8f9fa;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --success: #4bb543;
            --warning: #ffcc00;
            --error: #dc3545;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--dark);
            line-height: 1.6;
            background-color: #fafafa;
        }

        .product-detail-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            max-width: 1400px;
            margin: 3rem auto;
            padding: 0 2rem;
        }

        .product-gallery {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background: white;
            height: fit-content;
        }

        .main-image {
            width: 100%;
            height: auto;
            display: block;
            aspect-ratio: 1/1;
            object-fit: contain;
        }

        .image-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 500px;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            color: var(--gray);
        }

        .image-placeholder i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--light-gray);
        }

        .product-content {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .product-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .price {
            font-size: 2rem;
            font-weight: 700;
            color: var(--secondary);
            margin: 1rem 0;
        }

        .product-meta {
            display: flex;
            gap: 1.5rem;
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        .availability {
            color: var(--success);
            font-weight: 500;
        }

        .product-description {
            padding: 1.5rem 0;
            border-top: 1px solid var(--light-gray);
            border-bottom: 1px solid var(--light-gray);
        }

        .product-description h3 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .product-description p {
            color: var(--gray);
        }

        .product-actions {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .quantity-selector {
            margin-bottom: 1.5rem;
        }

        .quantity-selector label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }

        .quantity-control {
            display: flex;
            align-items: center;
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            overflow: hidden;
            width: fit-content;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            background: var(--light);
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .quantity-btn:hover {
            background: var(--light-gray);
        }

        .quantity-input {
            width: 60px;
            height: 40px;
            text-align: center;
            border: none;
            border-left: 1px solid var(--light-gray);
            border-right: 1px solid var(--light-gray);
            font-size: 1rem;
            font-weight: 600;
            -moz-appearance: textfield;
        }

        .quantity-input::-webkit-outer-spin-button,
        .quantity-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .total-display {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1.5rem 0;
            padding: 1rem;
            background: var(--light);
            border-radius: 8px;
        }

        .total-display .amount {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--secondary);
        }

        .action-btn {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .add-to-cart {
            background: var(--primary);
            color: white;
        }

        .add-to-cart:hover {
            background: var(--dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(58, 12, 163, 0.3);
        }

        .product-features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .feature i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .feature span {
            font-size: 0.9rem;
            color: var(--gray);
        }

        .auth-prompt {
            text-align: center;
            padding: 1.5rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .auth-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .auth-link:hover {
            color: var(--secondary);
            text-decoration: underline;
        }

        /* Reviews Section */
        .product-reviews {
            grid-column: 1 / -1;
            margin-top: 4rem;
            padding: 3rem 0;
            border-top: 1px solid var(--light-gray);
        }

        .reviews-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 3rem;
        }

        .reviews-header h2 {
            font-size: 2rem;
            color: var(--dark);
        }

        .rating-summary {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stars {
            color: var(--warning);
            font-size: 1.5rem;
            letter-spacing: 2px;
        }

        .average {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .count {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .review-form-container {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 3rem;
        }

        .review-form-container h3 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }

        .review-form .form-group {
            margin-bottom: 1.5rem;
        }

        .review-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }

        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-start;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 2rem;
            color: var(--light-gray);
            cursor: pointer;
            transition: color 0.2s;
            margin-right: 0.5rem;
        }

        .star-rating input:checked~label,
        .star-rating input:hover~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: var(--warning);
        }

        .review-form textarea {
            width: 100%;
            padding: 1rem;
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
        }

        .submit-review {
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .submit-review:hover {
            background: var(--dark);
            transform: translateY(-2px);
        }

        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .review-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .reviewer-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .reviewer-meta {
            display: flex;
            flex-direction: column;
        }

        .name {
            font-weight: 600;
        }

        .date {
            font-size: 0.8rem;
            color: var(--gray);
        }

        .review-rating {
            color: var(--warning);
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .review-text {
            color: var(--gray);
            line-height: 1.6;
        }

        .no-reviews {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .no-reviews i {
            font-size: 3rem;
            color: var(--light-gray);
            margin-bottom: 1rem;
        }

        .no-reviews p {
            color: var(--gray);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .product-detail-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .product-features {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .product-detail-container {
                padding: 0 1rem;
                margin: 1.5rem auto;
            }

            .product-header h1 {
                font-size: 2rem;
            }

            .price {
                font-size: 1.5rem;
            }

            .reviews-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-gallery,
        .product-content,
        .product-reviews {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .product-content {
            animation-delay: 0.1s;
        }

        .product-reviews {
            animation-delay: 0.2s;
        }
    </style>

    @auth
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Quantity controls
                const quantityInput = document.getElementById('quantity');
                const decreaseBtn = document.getElementById('decrease-qty');
                const increaseBtn = document.getElementById('increase-qty');
                const productPrice = parseFloat(document.getElementById('product-price').textContent.replace(
                    /[^0-9.-]/g, ''));
                const totalPriceElement = document.getElementById('total-price');
                const addToCartForm = document.getElementById('add-to-cart-form');

                // Update quantity
                decreaseBtn.addEventListener('click', function() {
                    let value = parseInt(quantityInput.value);
                    if (value > 1) {
                        quantityInput.value = value - 1;
                        updateTotalPrice();
                    }
                });

                increaseBtn.addEventListener('click', function() {
                    let value = parseInt(quantityInput.value);
                    quantityInput.value = value + 1;
                    updateTotalPrice();
                });

                // Update total price
                function updateTotalPrice() {
                    const quantity = parseInt(quantityInput.value) || 1;
                    const totalPrice = (productPrice * quantity).toFixed(2);
                    totalPriceElement.textContent = totalPrice;
                }

                quantityInput.addEventListener('input', updateTotalPrice);

                // AJAX form submission
                addToCartForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const form = this;
                    const formData = new FormData(form);
                    const submitButton = form.querySelector('button[type="submit"]');
                    const originalButtonText = submitButton.innerHTML;

                    // Loading state
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                    submitButton.disabled = true;

                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        })
                        .then(async response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Create floating cart item effect
                                const productImage = document.querySelector('.main-image') || document
                                    .querySelector('.image-placeholder');
                                const cartIcon = document.querySelector('.cart-link');

                                if (productImage && cartIcon) {
                                    const flyer = productImage.cloneNode(true);
                                    flyer.style.position = 'fixed';
                                    flyer.style.width = '50px';
                                    flyer.style.height = '50px';
                                    flyer.style.borderRadius = '50%';
                                    flyer.style.objectFit = 'cover';
                                    flyer.style.zIndex = '9999';
                                    flyer.style.transition = 'all 1s ease-out';
                                    flyer.style.boxShadow = '0 5px 15px rgba(0,0,0,0.3)';

                                    const productRect = productImage.getBoundingClientRect();
                                    const cartRect = cartIcon.getBoundingClientRect();

                                    flyer.style.left = `${productRect.left}px`;
                                    flyer.style.top = `${productRect.top}px`;
                                    document.body.appendChild(flyer);

                                    setTimeout(() => {
                                        flyer.style.left = `${cartRect.left}px`;
                                        flyer.style.top = `${cartRect.top}px`;
                                        flyer.style.opacity = '0.5';
                                        flyer.style.transform = 'scale(0.2)';
                                    }, 50);

                                    setTimeout(() => {
                                        document.body.removeChild(flyer);
                                    }, 1050);
                                }

                                updateCartCount(data.cart_count);
                                showToast('Added to cart!', 'success');
                            } else {
                                showToast(data.message || 'Failed to add to cart', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Failed to add to cart. Please try again.', 'error');
                        })
                        .finally(() => {
                            submitButton.innerHTML = originalButtonText;
                            submitButton.disabled = false;
                        });
                });

                function updateCartCount(count) {
                    const cartCountElement = document.querySelector('.cart-count');
                    if (cartCountElement) {
                        cartCountElement.textContent = count;
                        cartCountElement.classList.add('pulse');
                        setTimeout(() => {
                            cartCountElement.classList.remove('pulse');
                        }, 500);
                    }
                }

                function showToast(message, type) {
                    const toast = document.createElement('div');
                    toast.className = `toast toast-${type}`;
                    toast.textContent = message;
                    document.body.appendChild(toast);

                    setTimeout(() => {
                        toast.classList.add('show');
                    }, 10);

                    setTimeout(() => {
                        toast.classList.remove('show');
                        setTimeout(() => {
                            document.body.removeChild(toast);
                        }, 300);
                    }, 3000);
                }
            });
        </script>

        <style>
            .toast {
                position: fixed;
                bottom: 30px;
                right: 30px;
                padding: 15px 25px;
                border-radius: 8px;
                color: white;
                font-weight: 500;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                z-index: 1000;
                transform: translateY(100px);
                opacity: 0;
                transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            }

            .toast.show {
                transform: translateY(0);
                opacity: 1;
            }

            .toast-success {
                background: var(--success);
            }

            .toast-error {
                background: var(--error);
            }

            .pulse {
                animation: pulse 0.5s ease-in-out;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.2);
                }

                100% {
                    transform: scale(1);
                }
            }
        </style>
    @endauth
@endsection

@extends('layouts.app')

@section('title', 'Your Shopping Cart')
@section('content')
    <div class="cart-container">
        <h1>Panier</h1>

        @if (count($cart) > 0)
            <div class="cart-items">
                @foreach ($cart as $id => $details)
                    <div class="cart-item">
                        <div class="item-image">
                            @if ($details['image'])
                                <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}">
                            @else
                                <div class="image-placeholder">Pas d'images</div>
                            @endif
                        </div>

                        <div class="item-details">
                            <h3>{{ $details['name'] }}</h3>
                            <div class="price">${{ number_format($details['price']) }}</div>
                            Quantité: {{ $details['quantity'] }}
                        </div>

                        <div class="item-total">
                            ${{ number_format($details['price'] * $details['quantity']) }}
                        </div>

                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="remove-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-btn">&times;</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="cart-summary">
                <div class="subtotal">
                    <span>Total:</span>
                    <span>${{ number_format(array_sum(array_map(function ($item) {return $item['price'] * $item['quantity'];}, $cart))) }}</span>
                </div>

                <div class="cart-actions">
                    <form action="{{ route('orders.storeFromCart') }}" method="POST">
                        @csrf
                        <button type="submit" class="checkout-btn">Commander</button>
                    </form>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <p>Panier Vide</p>
            </div>
        @endif
    </div>

    <style>
        .cart-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .cart-container h1 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 30px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
            padding: 20px;
            border-radius: 12px;
            background: #f9f9ff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .item-image img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            object-fit: cover;
        }

        .image-placeholder {
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ddd;
            border-radius: 10px;
            font-size: 0.8em;
            color: #555;
        }

        .item-details {
            flex-grow: 1;
        }

        .item-details h3 {
            margin: 0;
            font-size: 1.2em;
        }

        .price {
            color: #666;
            margin: 10px 0;
        }

        .quantity-form {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 6px;
            overflow: hidden;
        }

        .quantity-input {
            width: 40px;
            border: none;
            text-align: center;
        }

        .quantity-btn {
            background: #eee;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
        }

        .quantity-btn:hover {
            background: #ccc;
        }

        .update-btn {
            padding: 6px 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .update-btn:hover {
            background: #0056b3;
        }

        .item-total {
            font-size: 1.1em;
            font-weight: bold;
        }

        .remove-form {
            margin-left: 20px;
        }

        .remove-btn {
            background: transparent;
            border: none;
            font-size: 24px;
            color: #ff4d4f;
            cursor: pointer;
        }

        .cart-summary {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .subtotal {
            display: flex;
            justify-content: space-between;
            font-size: 1.3em;
            margin-bottom: 20px;
        }

        .cart-actions {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .continue-shopping,
        .checkout-btn {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.2s;
        }

        .continue-shopping {
            background: #6c757d;
            color: white;
        }

        .continue-shopping:hover {
            background: #5a6268;
        }

        .checkout-btn {
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        .checkout-btn:hover {
            background: #218838;
        }

        .empty-cart {
            text-align: center;
            padding: 40px;
            color: #888;
        }

        .empty-cart a {
            display: inline-block;
            margin-top: 15px;
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
        }

        .empty-cart a:hover {
            background: #0056b3;
        }

        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .remove-form {
                align-self: flex-end;
            }
        }
    </style>


@endsection

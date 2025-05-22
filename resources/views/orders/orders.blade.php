@extends('layouts.app')

@section('title', 'My Orders')
@section('content')
    <div class="orders-container">
        <h1>Mes Commandes</h1>

        @if ($orders->isEmpty())
            <div class="empty-orders">
                <p>Pas de commande</p>
            </div>
        @else
            <div class="orders-list">
                @foreach ($orders as $order)
                    <div class="order-card {{ $order->status }}">
                        <div class="order-header">
                            <div class="order-meta">
                                <span class="order-number">Commande #{{ $order->id }}</span>
                            </div>
                        </div>

                        <div class="order-items">
                            @foreach ($order->items as $item)
                                <div class="order-item">
                                    <div class="item-image">
                                        @if ($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                alt="{{ $item->product->name }}">
                                        @else
                                            <div class="image-placeholder">Pas d'images</div>
                                        @endif
                                    </div>
                                    <div class="item-details">
                                        <h3>{{ $item->product->name }}</h3>
                                        <div class="item-quantity">Quantité: {{ $item->quantity }}</div>
                                        <div class="item-price">${{ number_format($item->price) }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="order-footer">
                            <div class="order-total">
                                Total: ${{ number_format($order->total) }}
                            </div>

                            @if ($order->status === 'pending')
                                <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cancel-order-btn">Annuler la commande</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        .orders-container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
        }

        h1 {
            text-align: center;
            font-size: 3rem;
            margin-bottom: 2rem;
            color: #000000;
        }

        .empty-orders {
            text-align: center;
            font-size: 1.4rem;
        }

        .empty-orders a {
            display: inline-block;
            margin-top: 1rem;
            background-color: #000000;
            color: #000;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .empty-orders a:hover {
            background-color: #000000;
        }

        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .order-card {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .order-number,
        .order-date {
            display: block;
            font-size: 1rem;
        }

        .order-items {
            display: grid;
            gap: 1rem;
        }

        .order-item {
            display: flex;
            gap: 1rem;
            align-items: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1rem;
        }

        .item-image img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
        }

        .image-placeholder {
            width: 80px;
            height: 80px;
            background: #333;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
        }

        .item-details h3 {
            margin: 0;
            font-size: 1.1rem;
        }

        .item-quantity,
        .item-price {
            font-size: 0.9rem;
        }

        .order-footer {
            margin-top: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .order-total {
            font-size: 1.2rem;
            font-weight: bold;
            color: #7700c1;
        }

        .cancel-order-btn {
            background-color: #ff4c4c;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .cancel-order-btn:hover {
            background-color: #ff1c1c;
        }
    </style>
@endsection

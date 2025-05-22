@extends('layouts.app')

@section('content')
    <div class="pending-container">
        <h1 class="pending-title">Produit en attente</h1>

        @if ($products->isEmpty())
            <p class="no-products">Pas de produit en attente</p>
        @else
            <div class="table-wrapper">
                <table class="pending-table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="product-cell">
                                    <div class="product-info">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="product-image">
                                        <span class="product-name">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td class="price-cell">${{ number_format($product->price) }}</td>
                                <td class="price-cell">{{ $product->description }}</td>
                                <td class="actions-cell">
                                    <div class="action-buttons">
                                        <form action="{{ route('admin.products.approve', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="approve-btn">
                                                Approuvé
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.products.reject', $product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="reject-btn">
                                                Rejeté
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <style>
        /* Container styling */
        .pending-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Title styling */
        .pending-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 30px;
            color: #333;
        }

        /* No products message */
        .no-products {
            text-align: center;
            font-size: 1.1rem;
            color: #777;
        }

        /* Table wrapper for responsive overflow */
        .table-wrapper {
            overflow-x: auto;
        }

        /* Table styling */
        .pending-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        .pending-table thead {
            background-color: #4a90e2;
            color: #fff;
        }

        .pending-table th,
        .pending-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .pending-table tr:hover {
            background-color: #f1f7ff;
        }

        /* Product cell with image */
        .product-cell .product-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .product-name {
            font-weight: 600;
            color: #333;
        }

        /* Price and submitter */
        .price-cell,
        .submitter-cell {
            color: #555;
        }

        /* Actions */
        .actions-cell .action-buttons {
            display: flex;
            gap: 10px;
        }

        /* Buttons */
        .approve-btn,
        .reject-btn {
            padding: 8px 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            color: white;
            transition: background-color 0.2s ease;
        }

        .approve-btn {
            background-color: #28a745;
        }

        .approve-btn:hover {
            background-color: #218838;
        }

        .reject-btn {
            background-color: #dc3545;
        }

        .reject-btn:hover {
            background-color: #c82333;
        }
    </style>
    <script>
        // Add data-labels for mobile view
        document.addEventListener('DOMContentLoaded', function() {
            const headers = document.querySelectorAll('.pending-table thead th');
            const rows = document.querySelectorAll('.pending-table tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                cells.forEach((cell, index) => {
                    if (headers[index]) {
                        cell.setAttribute('data-label', headers[index].textContent);
                    }
                });
            });
        });
    </script>
@endsection

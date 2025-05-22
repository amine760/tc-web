@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('content')
    <div class="admin-container">
        <h1>Admin Dashboard</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Sales</h3>
                <p>${{ number_format($stats['total_sales']) }}</p>
            </div>
            <div class="stat-card">
                <h3>Total Orders</h3>
                <p>{{ $stats['total_orders'] }}</p>
            </div>
            <div class="stat-card">
                <h3>Pending Products</h3>
                <p>{{ $stats['pending_products'] }}</p>
            </div>
            <div class="stat-card">
                <h3>Pending Galleries</h3>
                <p>{{ $stats['pending_galleries'] }}</p>
            </div>
        </div>
    </div>
    <div class="user-orders">
        <h2>Users and Their Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Number of Orders</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userOrders as $user)
                    <tr>
                        <td>{{ $user->nom }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->orders_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <style>
        .user-orders {
            margin-top: 40px;
        }

        .user-orders h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }

        .user-orders table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .user-orders th,
        .user-orders td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid #eaeaea;
        }

        .user-orders th {
            background-color: #f1f1f1;
            color: #34495e;
        }

        .user-orders tr:hover {
            background-color: #f9f9f9;
        }

        .admin-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 30px;
            background-color: #f9fafb;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .admin-container h1 {
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
            color: #2c3e50;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease-in-out;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #34495e;
        }

        .stat-card p {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2ecc71;
        }

        .admin-links {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .admin-link {
            padding: 12px 20px;
            background-color: #3498db;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .admin-link:hover {
            background-color: #2980b9;
        }
    </style>
@endsection

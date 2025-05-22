@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>User Management</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->nom }} {{ $user->prenom }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <style>
        /* Container styling */

        /* Heading styling */
        .container h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
            color: #333;
        }

        /* Table styling */
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        .table thead {
            background-color: #f5f5f5;
        }

        .table th,
        .table td {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .table tr:hover {
            background-color: #f9f9f9;
        }

        /* Delete button styling */
        .btn-danger {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        /* Responsive behavior */
        @media (max-width: 768px) {

            .table th,
            .table td {
                padding: 10px;
                font-size: 14px;
            }

            .btn-danger {
                padding: 6px 10px;
                font-size: 14px;
            }

            .container {
                padding: 15px;
            }
        }
    </style>
@endsection

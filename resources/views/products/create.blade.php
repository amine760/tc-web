@extends('layouts.app')

@section('title', 'Create Product')
@section('content')
    <div class="product-form-container">
        <div class="form-header">
            <h1>Ajouter un produit</h1>
            <div class="header-accent"></div>
        </div>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="neumorphic-form">
            @csrf
            <div class="form-group floating">
                <input type="text" id="name" name="name" required class="form-control" placeholder=" ">
                <label for="name">Nom</label>
                <span class="focus-border"></span>
            </div>

            <div class="form-group floating">
                <textarea id="description" name="description" required class="form-control" rows="3" placeholder=" "></textarea>
                <label for="description">Description</label>
                <span class="focus-border"></span>
            </div>

            <div class="form-row">
                <div class="form-group floating">
                    <input type="number" id="price" name="price" step="0.01" min="0" required
                        class="form-control" placeholder=" ">
                    <label for="price">Prix</label>
                    <span class="focus-border"></span>
                </div>

                <div class="form-group floating">
                    <input type="number" id="stock" name="stock" min="0" required class="form-control"
                        placeholder=" ">
                    <label for="stock">Stock</label>
                    <span class="focus-border"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="categories">Category</label>
                <div class="select-wrapper">
                    <select name="categories[]" id="categories" multiple class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="select-arrow"></div>
                </div>
            </div>

            <div class="form-group file-upload">
                <label for="image">Image</label>
                <div class="upload-area">
                    <input type="file" id="image" name="image" class="upload-input">
                </div>
            </div>

            <button type="submit" class="submit-btn">
                <span>Ajouter</span>
                <svg viewBox="0 0 24 24" class="submit-icon">
                    <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                </svg>
            </button>
        </form>
    </div>

    <style>
        :root {
            --primary: #6c5ce7;
            --primary-dark: #5649c0;
            --secondary: #00cec9;
            --dark: #2d3436;
            --light: #f5f6fa;
            --shadow: 8px 8px 16px rgba(0, 0, 0, 0.2),
                -8px -8px 16px rgba(255, 255, 255, 0.05);
            --inset-shadow: inset 3px 3px 6px rgba(0, 0, 0, 0.2),
                inset -3px -3px 6px rgba(255, 255, 255, 0.05);
        }

        body {
            background-color: #1a1a2e;
            color: var(--light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .product-form-container {
            max-width: 700px;
            margin: 3rem auto;
            padding: 2rem;
            background: #16213e;
            border-radius: 20px;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
        }

        .product-form-container:hover {
            transform: translateY(-5px);
        }

        .form-header {
            position: relative;
            margin-bottom: 2.5rem;
            text-align: center;
        }

        .form-header h1 {
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 700;
        }

        .header-accent {
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            margin: 0 auto;
            border-radius: 2px;
        }

        .neumorphic-form {
            display: flex;
            flex-direction: column;
            gap: 1.8rem;
        }

        .form-row {
            display: flex;
            gap: 1.5rem;
        }

        .form-row .form-group {
            flex: 1;
        }

        .form-group {
            position: relative;
        }

        .form-group.floating label {
            position: absolute;
            top: 1rem;
            left: 1rem;
            color: rgba(255, 255, 255, 0.7);
            pointer-events: none;
            transition: all 0.3s ease;
            padding: 0 0.25rem;
            background: #16213e;
        }

        .form-group.floating input:focus~label,
        .form-group.floating input:not(:placeholder-shown)~label,
        .form-group.floating textarea:focus~label,
        .form-group.floating textarea:not(:placeholder-shown)~label {
            top: -0.6rem;
            left: 0.8rem;
            font-size: 0.8rem;
            color: var(--secondary);
        }

        .form-control {
            width: 100%;
            padding: 1rem;
            background: #16213e;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: var(--light);
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: var(--inset-shadow);
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: var(--inset-shadow), 0 0 0 2px rgba(108, 92, 231, 0.2);
        }

        .focus-border {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .form-control:focus~.focus-border {
            width: 100%;
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper::after {
            content: '';
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid rgba(255, 255, 255, 0.7);
            pointer-events: none;
        }

        select.form-control {
            appearance: none;
            padding-right: 2.5rem;
        }

        .hint {
            display: block;
            margin-top: 0.5rem;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
        }

        .submit-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
            padding: 1rem 2rem;
            background: linear-gradient(45deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
            overflow: hidden;
            position: relative;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(108, 92, 231, 0.4);
        }

        .submit-btn:active {
            transform: translateY(1px);
        }

        .submit-icon {
            width: 20px;
            height: 20px;
            fill: white;
            transition: transform 0.3s ease;
        }

        .submit-btn:hover .submit-icon {
            transform: translateX(5px);
        }

        /* Animation for form elements */
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

        .form-group {
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
        }

        .form-group:nth-child(1) {
            animation-delay: 0.1s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.3s;
        }

        .form-group:nth-child(4) {
            animation-delay: 0.4s;
        }

        .form-group:nth-child(5) {
            animation-delay: 0.5s;
        }

        .form-group:nth-child(6) {
            animation-delay: 0.6s;
        }

        .submit-btn {
            animation: fadeInUp 0.5s ease 0.7s forwards;
        }
    </style>
@endsection

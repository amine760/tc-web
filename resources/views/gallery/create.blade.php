@extends('layouts.app')

@section('title', 'Add Gallery')
@section('content')
    <div class="glass-form-container-container">
        <div class="glass-form-container">
            <h1 class="form-title">📸 Ajouter un salon</h1>

            <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="glass-form">
                @csrf

                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" name="title" id="title" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="images">Ajouter des Images</label>
                    <input type="file" name="images[]" id="images" multiple required accept="image/*">
                </div>

                <button type="submit" class="submit-btn">🚀 Créer</button>
            </form>
        </div>
    </div>

    <style>
        .glass-form-container-container {
            background: linear-gradient(135deg, #667eea, #764ba2);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .glass-form-container {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            color: white;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            animation: slideIn 1s ease-out;
        }

        .form-title {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #ffffff;
        }

        .glass-form .form-group {
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .glass-form label {
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .glass-form input,
        .glass-form textarea {
            padding: 0.75rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            outline: none;
            transition: background 0.3s;
        }

        .glass-form input::placeholder,
        .glass-form textarea::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .glass-form input:focus,
        .glass-form textarea:focus {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .submit-btn {
            background-color: #560098;
            color: white;
            font-size: 1rem;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.3s;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #02b79c;
            transform: scale(1.05);
        }

        /* Animations */
        @keyframes slideIn {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 576px) {
            .gallery-form-container {
                padding: 1rem;
                margin: 1rem;
            }

            .form-group input[type="text"],
            .form-group textarea,
            .form-group select {
                padding: 0.6rem;
            }

            .submit-btn {
                padding: 0.6rem;
            }
        }

        /* Medium devices (tablets, 768px and up) */
        @media (min-width: 577px) and (max-width: 768px) {
            .gallery-form-container {
                max-width: 500px;
            }
        }

        /* Large devices (desktops, 992px and up) */
        @media (min-width: 769px) and (max-width: 992px) {
            .gallery-form-container {
                max-width: 700px;
            }
        }

        /* Extra large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) {
            .gallery-form-container {
                max-width: 800px;
            }
        }

        /* Mobile landscape orientation */
        @media (max-width: 768px) and (orientation: landscape) {
            .gallery-form-container {
                margin: 0.5rem auto;
                padding: 1rem;
            }

            .form-group textarea {
                min-height: 80px;
            }
        }

        /* High resolution displays */
        @media (-webkit-min-device-pixel-ratio: 2),
        (min-resolution: 192dpi) {
            .submit-btn {
                border-width: 1px;
            }
        }
    </style>
@endsection

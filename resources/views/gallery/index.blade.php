@extends('layouts.app')

@section('title', 'Gallery')
@section('content')
    <div class="gallery-container">
        <h1>Salons et événements</h1>
        <div class="gallery-grid">
            @forelse($galleries as $gallery)
                <div class="gallery-item">
                    <a href="{{ route('gallery.show', $gallery) }}">
                        <img src="{{ asset('storage/' . $gallery->featured_image) }}" alt="{{ $gallery->title }}">
                        <div class="gallery-info">
                            <h3>{{ $gallery->title }}</h3>
                            <p>{{ Str::limit($gallery->description, 100) }}</p>
                            <small>Images: {{ $gallery->images->count() }}</small>
                            @if (auth()->check() && auth()->user()->isItCommercial())
                                <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endif
                        </div>
                    </a>
                </div>
            @empty
                <p>No galleries found.</p>
            @endforelse
        </div>

        {{ $galleries->links() }}
    </div>

    <style>
        .gallery-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .gallery-container h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: #333;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .gallery-item {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-info {
            padding: 1rem;
            color: #444;
        }

        .gallery-info h3 {
            margin: 0 0 0.5rem;
            font-size: 1.25rem;
            color: #222;
        }

        .gallery-info p {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .gallery-info small {
            display: block;
            font-size: 0.85rem;
            color: #777;
        }

        .btn {
            display: inline-block;
            background-color: #e74c3c;
            color: #fff;
            padding: 0.4rem 0.8rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #c0392b;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .pagination .page-link {
            padding: 0.6rem 1rem;
            margin: 0 5px;
            border-radius: 6px;
            border: 1px solid #ddd;
            color: #333;
            transition: background-color 0.2s, color 0.2s;
        }

        .pagination .page-link:hover {
            background-color: #f0f0f0;
        }

        .pagination .active .page-link {
            background-color: #333;
            color: #fff;
            border-color: #333;
        }


        /* Small devices (phones, 576px and below) */
        @media (max-width: 576px) {
            .gallery-container {
                padding: 0.5rem;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .gallery-item {
                margin-bottom: 1rem;
            }

            .gallery-info h3 {
                font-size: 1rem;
            }

            .gallery-info p {
                font-size: 0.8rem;
            }
        }

        /* Medium devices (tablets, 577px to 768px) */
        @media (min-width: 577px) and (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.25rem;
            }
        }

        /* Large devices (small laptops, 769px to 992px) */
        @media (min-width: 769px) and (max-width: 992px) {
            .gallery-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 1.5rem;
            }
        }

        /* Extra large devices (desktops, 993px to 1200px) */
        @media (min-width: 993px) and (max-width: 1200px) {
            .gallery-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Super large devices (large desktops, 1201px and up) */
        @media (min-width: 1201px) {
            .gallery-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        /* Mobile landscape orientation */
        @media (max-width: 768px) and (orientation: landscape) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .gallery-item img {
                max-height: 150px;
            }
        }

        /* High DPI devices */
        @media (-webkit-min-device-pixel-ratio: 2),
        (min-resolution: 192dpi) {
            .gallery-item img {
                border: 1px solid rgba(0, 0, 0, 0.05);
            }
        }
    </style>

    <script>
        // Fade in animation on scroll
        document.addEventListener("DOMContentLoaded", function() {
            const items = document.querySelectorAll('.gallery-item');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, {
                threshold: 0.1
            });

            items.forEach(item => observer.observe(item));
        });
    </script>

    <style>
        .gallery-item {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .gallery-item.fade-in {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

@endsection

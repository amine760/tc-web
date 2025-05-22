@extends('layouts.app')

@section('title', $gallery->title)
@section('content')
    <div class="gallery-show-container">
        <div class="gallery-header">
            <h1>{{ $gallery->title }}</h1>
            <div class="gallery-meta">
                <span class="gallery-type">{{ ucfirst($gallery->type) }}</span>
                <span class="gallery-date">{{ $gallery->created_at->format('F j, Y') }}</span>
            </div>
        </div>

        <!-- Main Carousel -->
        <div class="gallery-carousel">
            <div class="carousel-images">
                @foreach ($gallery->images as $image)
                    <div class="carousel-slide">
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                            alt="{{ $gallery->title }} - Image {{ $loop->iteration }}">
                        <div class="slide-number">{{ $loop->iteration }}/{{ count($gallery->images) }}</div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-prev">❮</button>
            <button class="carousel-next">❯</button>
            <div class="carousel-indicators">
                @foreach ($gallery->images as $image)
                    <button class="indicator {{ $loop->first ? 'active' : '' }}" data-index="{{ $loop->index }}"></button>
                @endforeach
            </div>
        </div>

        <div class="gallery-description">
            <p>{{ $gallery->description }}</p>
        </div>
    </div>

    <style>
        :root {
            --primary: #6c5ce7;
            --secondary: #1a1a2e;
            --accent: #e6e6e6;
            --text: #e6e6e6;
            --bg: #0f0f1a;
        }

        body {
            background-color: var(--bg);
            color: var(--text);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .gallery-show-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            background: linear-gradient(145deg, #161622, #1e1e2e);
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .gallery-show-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 77, 77, 0.1) 0%, rgba(0, 0, 0, 0) 70%);
            z-index: -1;
        }

        .gallery-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .gallery-header h1 {
            font-size: 3.5rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 800;
            letter-spacing: -0.05em;
        }

        .gallery-meta {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .gallery-type {
            background: var(--secondary);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            color: var(--accent);
            border: 1px solid rgba(0, 255, 136, 0.3);
        }

        .gallery-date {
            color: rgba(230, 230, 230, 0.7);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .gallery-carousel {
            position: relative;
            width: 100%;
            height: 70vh;
            margin: 0 auto 3rem;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .carousel-images {
            display: flex;
            transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
            height: 100%;
        }

        .carousel-slide {
            min-width: 100%;
            height: 100%;
            position: relative;
        }

        .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .slide-number {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .carousel-prev,
        .carousel-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(26, 26, 46, 0.8);
            backdrop-filter: blur(10px);
            color: white;
            border: none;
            width: 60px;
            height: 60px;
            font-size: 1.8rem;
            cursor: pointer;
            border-radius: 50%;
            z-index: 10;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.8;
        }

        .carousel-prev:hover,
        .carousel-next:hover {
            background: var(--primary);
            opacity: 1;
            transform: translateY(-50%) scale(1.1);
        }

        .carousel-prev {
            left: 30px;
        }

        .carousel-next {
            right: 30px;
        }

        .carousel-indicators {
            position: absolute;
            bottom: 30px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 12px;
            z-index: 10;
        }

        .carousel-indicators .indicator {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.5);
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0;
        }

        .carousel-indicators .indicator:hover {
            border-color: var(--accent);
        }

        .carousel-indicators .indicator.active {
            background: var(--primary);
            border-color: var(--primary);
            transform: scale(1.2);
        }

        .gallery-description {
            max-width: 800px;
            margin: 3rem auto 0;
            padding: 2rem;
            line-height: 1.8;
            font-size: 1.1rem;
            background: rgba(26, 26, 46, 0.5);
            border-radius: 12px;
            border-left: 4px solid var(--primary);
            backdrop-filter: blur(10px);
        }

        @media (max-width: 768px) {
            .gallery-show-container {
                padding: 1rem;
                border-radius: 0;
            }

            .gallery-header h1 {
                font-size: 2.5rem;
            }

            .gallery-carousel {
                height: 50vh;
            }

            .carousel-prev,
            .carousel-next {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.querySelector('.gallery-carousel');
            const images = carousel.querySelector('.carousel-images');
            const prevBtn = carousel.querySelector('.carousel-prev');
            const nextBtn = carousel.querySelector('.carousel-next');
            const indicators = carousel.querySelectorAll('.indicator');
            let currentIndex = 0;
            const totalSlides = images.children.length;
            let autoSlideInterval;
            let isAnimating = false;

            function updateCarousel() {
                isAnimating = true;
                images.style.transform = `translateX(-${currentIndex * 100}%)`;

                // Update indicators
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('active', index === currentIndex);
                });

                setTimeout(() => {
                    isAnimating = false;
                }, 700);
            }

            function nextSlide() {
                if (isAnimating) return;
                currentIndex = (currentIndex + 1) % totalSlides;
                updateCarousel();
            }

            function prevSlide() {
                if (isAnimating) return;
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateCarousel();
            }

            // Button controls
            nextBtn.addEventListener('click', nextSlide);
            prevBtn.addEventListener('click', prevSlide);

            // Indicator controls
            indicators.forEach(indicator => {
                indicator.addEventListener('click', () => {
                    if (isAnimating) return;
                    currentIndex = parseInt(indicator.dataset.index);
                    updateCarousel();
                });
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowRight') nextSlide();
                if (e.key === 'ArrowLeft') prevSlide();
            });

            // Auto-advance
            function startAutoSlide() {
                autoSlideInterval = setInterval(nextSlide, 6000);
            }

            function stopAutoSlide() {
                clearInterval(autoSlideInterval);
            }

            // Start auto-slide and pause on hover
            startAutoSlide();
            carousel.addEventListener('mouseenter', stopAutoSlide);
            carousel.addEventListener('mouseleave', startAutoSlide);

            // Touch support for mobile
            let touchStartX = 0;
            let touchEndX = 0;

            carousel.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
                stopAutoSlide();
            }, {
                passive: true
            });

            carousel.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
                startAutoSlide();
            }, {
                passive: true
            });

            function handleSwipe() {
                if (touchEndX < touchStartX - 50) nextSlide();
                if (touchEndX > touchStartX + 50) prevSlide();
            }
        });
    </script>
@endsection

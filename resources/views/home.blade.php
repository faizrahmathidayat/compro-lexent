@extends('layouts.app')

@section('title', 'LEXENT')
@section('meta_description', 'LEXENT - kaca film mobil, kaca film bangunan, dan paint protection film (PPF) premium. UV rejection hingga 99%, heat rejection tinggi, garansi resmi hingga 8 tahun.')

@section('content')

    {{-- ============================= HERO ============================= --}}
    <section class="hero" id="heroSection">
        @foreach($highlights as $i => $slide)
            <div class="hero-slide{{ $i === 0 ? ' is-active' : '' }}" data-index="{{ $i }}">
                <div class="hero-media">
                    <img src="{{ asset($slide['image']) }}" alt="{{ $slide['alt'] }}" {{ $i === 0 ? '' : 'loading="lazy"' }}>
                </div>
                <div class="container hero-content">
                    <span class="hero-kicker">{!! $slide['kicker'] !!}</span>
                    <h1 class="hero-title">{!! $slide['headline'] !!}</h1>
                    <p class="hero-text">{{ $slide['text'] }}</p>
                    <div class="hero-actions">
                        <a href="{{ $slide['cta_url'] }}" class="btn btn-gold btn-arrow">{{ $slide['cta_label'] }}</a>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="hero-dots" id="heroDots">
            @foreach($highlights as $i => $slide)
                <button type="button" class="hero-dot{{ $i === 0 ? ' is-active' : '' }}" data-index="{{ $i }}" aria-label="Ke slide {{ $i + 1 }}"></button>
            @endforeach
        </div>
    </section>

    {{-- ============================= SOLUSI KAMI ============================= --}}
    <section class="solution-section" id="products">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Solusi Kami</span>
                <h2 class="section-title">Perlindungan Lengkap untuk Setiap Kebutuhan</h2>
            </div>

            <div class="solution-grid">
                <a href="{{ route('products.automotive') }}" class="solution-card">
                    <img src="{{ asset('images/hero/car-porsche.jpg') }}" alt="" loading="lazy">
                    <span class="icon-badge">@include('partials.icon', ['name' => 'car'])</span>
                    <h3>Kaca Film Mobil</h3>
                    <p>Tolak panas, privasi lebih terjaga, berkendara lebih nyaman.</p>
                    <span class="round-arrow">@include('partials.icon', ['name' => 'arrow-right'])</span>
                </a>

                <a href="{{ route('products.building') }}" class="solution-card">
                    <img src="{{ asset('images/hero/building-glass.jpg') }}" alt="" loading="lazy">
                    <span class="icon-badge">@include('partials.icon', ['name' => 'building'])</span>
                    <h3>Kaca Film Bangunan</h3>
                    <p>Blokir panas, hemat energi, dan tampilan lebih elegan.</p>
                    <span class="round-arrow">@include('partials.icon', ['name' => 'arrow-right'])</span>
                </a>

                <a href="{{ route('ppf.index') }}" class="solution-card">
                    <img src="{{ asset('images/hero/ppf-peel.jpg') }}" alt="" loading="lazy">
                    <span class="icon-badge">@include('partials.icon', ['name' => 'shield-check'])</span>
                    <h3>Paint Protection Film (PPF)</h3>
                    <p>Lindungi cat mobil dari goresan, benturan, dan noda.</p>
                    <span class="round-arrow">@include('partials.icon', ['name' => 'arrow-right'])</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ============================= PRODUK UNGGULAN ============================= --}}
    <section class="feature-section">
        <div class="container">
            <div class="feature-grid">
                <div class="feature-copy">
                    <span class="eyebrow">Produk Unggulan</span>
                    <h2 class="section-title">Kaca Film Premium dengan <span>Teknologi Terkini</span></h2>
                    <p>Performa terbaik dengan perlindungan UV, peredam panas optimal, dan visibilitas jernih.</p>

                    <ul class="check-list">
                        <li><span class="check-dot">&#10003;</span> UV Protection hingga 99%</li>
                        <li><span class="check-dot">&#10003;</span> Heat Rejection hingga 99%</li>
                        <li><span class="check-dot">&#10003;</span> Crystal Clear Visibility</li>
                        <li><span class="check-dot">&#10003;</span> Garansi hingga 8 Tahun</li>
                    </ul>

                    <a href="{{ route('products.index') }}" class="btn btn-gold btn-arrow">Jelajahi Produk</a>
                </div>

                <div class="film-visual" aria-hidden="true">
                    <svg viewBox="0 0 700 380" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="filmSheet" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0" stop-color="#ffffff" stop-opacity="0.02"/>
                                <stop offset="0.6" stop-color="#bcd2ee" stop-opacity="0.2"/>
                                <stop offset="1" stop-color="#ffffff" stop-opacity="0.36"/>
                            </linearGradient>
                            <linearGradient id="filmEdge" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0" stop-color="#ffffff" stop-opacity="0.95"/>
                                <stop offset="1" stop-color="#7fa2cf" stop-opacity="0.3"/>
                            </linearGradient>
                            <radialGradient id="filmCore" cx="0.5" cy="0.5" r="0.5">
                                <stop offset="0" stop-color="#0b0d12"/>
                                <stop offset="1" stop-color="#1b2230"/>
                            </radialGradient>
                        </defs>
                        <path d="M30 352 C170 318 300 296 470 336 L470 28 C320 66 190 56 60 116 Z" fill="url(#filmSheet)" stroke="url(#filmEdge)" stroke-width="1.5"/>
                        <path d="M90 326 C220 296 330 280 470 312" fill="none" stroke="#fff" stroke-opacity="0.45" stroke-width="1.2"/>
                        <path d="M110 150 C240 104 340 92 470 72" fill="none" stroke="#fff" stroke-opacity="0.35" stroke-width="1.2"/>
                        <path d="M60 240 C200 220 330 214 470 226" fill="none" stroke="#fff" stroke-opacity="0.2" stroke-width="1"/>
                        <ellipse cx="470" cy="182" rx="96" ry="154" fill="url(#filmSheet)" stroke="url(#filmEdge)" stroke-width="2"/>
                        <ellipse cx="470" cy="182" rx="72" ry="120" fill="none" stroke="#fff" stroke-opacity="0.55"/>
                        <ellipse cx="470" cy="182" rx="50" ry="86" fill="none" stroke="#fff" stroke-opacity="0.45"/>
                        <ellipse cx="470" cy="182" rx="28" ry="48" fill="url(#filmCore)" stroke="#fff" stroke-opacity="0.65"/>
                        <path d="M500 38 C560 80 574 120 570 170" fill="none" stroke="#fff" stroke-opacity="0.4" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                </div>

                <div class="stat-column">
                    <div class="stat">
                        <span class="stat-label">UV</span>
                        <span class="stat-value">99%</span>
                        <span class="stat-note">Protection</span>
                    </div>
                    <div class="stat">
                        <span class="stat-label">IR</span>
                        <span class="stat-value">99%</span>
                        <span class="stat-note">Heat Rejection</span>
                    </div>
                    <div class="stat">
                        <span class="stat-label">TSER hingga</span>
                        <span class="stat-value">75%</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================= MENGAPA LEXENT ============================= --}}
    <section class="why-section" id="why-lexent">
        <div class="why-bg" aria-hidden="true">
            <img src="{{ asset('images/hero/hero-home.jpg') }}" alt="" loading="lazy">
        </div>
        <div class="container">
            <span class="eyebrow">Mengapa LEXENT?</span>
            <h2>Kualitas Terpercaya, Perlindungan Maksimal</h2>

            <div class="why-grid">
                <div class="why-item">@include('partials.icon', ['name' => 'diamond']) <span>Produk<br>Premium</span></div>
                <div class="why-item">@include('partials.icon', ['name' => 'shield-check']) <span>Garansi<br>hingga 8 Tahun</span></div>
                <div class="why-item">@include('partials.icon', ['name' => 'gear']) <span>Instalasi<br>Profesional</span></div>
                <div class="why-item">@include('partials.icon', ['name' => 'headset']) <span>Dukungan<br>Purna Jual</span></div>
            </div>
        </div>
    </section>

    {{-- ============================= GALERI ============================= --}}
    <section id="galeri" style="padding-top: var(--space-5); padding-bottom: var(--space-4);">
        <div class="container">
            <div class="gallery-head">
                <div>
                    <span class="eyebrow">Galeri Kami</span>
                    <h2>Hasil Pemasangan untuk Kepuasan Anda</h2>
                </div>
                <a href="{{ route('portfolio') }}" class="text-link">Lihat Galeri Lengkap @include('partials.icon', ['name' => 'arrow-right'])</a>
            </div>

            <div class="gallery-grid">
                <a href="{{ route('portfolio') }}" class="gallery-item"><img src="{{ asset('images/hero/car-porsche.jpg') }}" alt="Hasil pemasangan kaca film mobil" loading="lazy"></a>
                <a href="{{ route('portfolio') }}" class="gallery-item"><img src="{{ asset('images/hero/hero-home.jpg') }}" alt="Hasil pemasangan kaca film sedan hitam" loading="lazy"></a>
                <a href="{{ route('portfolio') }}" class="gallery-item"><img src="{{ asset('images/hero/building-glass.jpg') }}" alt="Hasil pemasangan kaca film bangunan" loading="lazy"></a>
                <a href="{{ route('portfolio') }}" class="gallery-item"><img src="{{ asset('images/hero/ppf-peel.jpg') }}" alt="Proses pemasangan paint protection film" loading="lazy"></a>
            </div>
        </div>
    </section>

    {{-- ============================= CEK GARANSI ============================= --}}
    <section class="warranty-strip-section">
        <div class="container">
            <div class="warranty-strip">
                <span class="warranty-strip-icon">@include('partials.icon', ['name' => 'shield-check'])</span>
                <div class="warranty-strip-copy">
                    <h3>Cek Garansi Anda</h3>
                    <p>Pastikan perlindungan Anda tetap berlaku dengan mudah.</p>
                </div>
                <a href="{{ route('cek-garansi') }}" class="btn btn-gold btn-arrow">Cek Garansi</a>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        (function () {
            var section = document.getElementById('heroSection');
            var slides = document.querySelectorAll('#heroSection .hero-slide');
            var dots = document.querySelectorAll('#heroDots .hero-dot');
            var total = slides.length;
            var current = 0;
            var timer = null;
            var AUTOPLAY_MS = 6000;

            function goTo(index) {
                current = (index + total) % total;

                slides.forEach(function (slide, i) {
                    slide.classList.toggle('is-active', i === current);
                });
                dots.forEach(function (dot, i) {
                    dot.classList.remove('is-active');
                    dot.classList.remove('is-done');
                    if (i === current) {
                        dot.classList.add('is-active');
                    } else if (i < current) {
                        dot.classList.add('is-done');
                    }
                });
            }

            function next() { goTo(current + 1); }

            function startAutoplay() {
                stopAutoplay();
                timer = setInterval(next, AUTOPLAY_MS);
            }

            function stopAutoplay() {
                if (timer) {
                    clearInterval(timer);
                    timer = null;
                }
            }

            dots.forEach(function (dot) {
                dot.addEventListener('click', function () {
                    goTo(parseInt(dot.getAttribute('data-index'), 10));
                    startAutoplay();
                });
            });

            section.addEventListener('mouseenter', stopAutoplay);
            section.addEventListener('mouseleave', startAutoplay);

            goTo(0);
            startAutoplay();
        })();
    </script>
@endsection

@extends('layouts.app')

@section('title', 'Portfolio')
@section('meta_description', 'Portfolio proyek LEXENT — instalasi kaca film mobil, kaca film bangunan, dan PPF oleh tim profesional.')

@section('content')

    <section class="page-header page-header--wide page-header--tall">
        <div class="page-header-media">
            <img src="{{ asset('images/hero/hero-building.jpg') }}" alt="" style="object-position: right 42%;">
        </div>
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a> <span aria-hidden="true">&rsaquo;</span> <span aria-current="page">Portfolio</span>
            </nav>
            <h1 class="page-title">Portfolio <span>Karya Terbaik Kami</span></h1>
            <p class="page-lead">Lihat hasil nyata dari berbagai proyek pemasangan kaca film dan PPF oleh tim profesional LEXENT.</p>
        </div>
    </section>

    <section style="padding-top: 0;">
        <div class="container">
            @if(!empty($categories))
                <nav class="cms-filter" aria-label="Filter kategori portfolio">
                    <a href="{{ route('portfolio') }}" class="{{ $activeCategory === '' ? 'is-active' : '' }}">Semua</a>
                    @foreach($categories as $category)
                        <a href="{{ route('portfolio', ['category' => $category]) }}" class="{{ strcasecmp($activeCategory, $category) === 0 ? 'is-active' : '' }}">{{ $category }}</a>
                    @endforeach
                </nav>
            @endif

            @if(empty($items))
                <p class="section-subtitle" style="margin: var(--space-4) 0;">{{ $activeCategory !== '' ? 'Belum ada portfolio untuk kategori ini.' : 'Konten belum tersedia saat ini.' }}</p>
            @else
                <div class="cms-grid cms-grid--portfolio">
                    @foreach($items as $item)
                        @php
                            $categoryName = strtolower($item['category'] ?? '');
                            $categoryIcon = null;
                            if (str_contains($categoryName, 'bangunan') || str_contains($categoryName, 'building')) {
                                $categoryIcon = 'building';
                            } elseif (str_contains($categoryName, 'mobil') || str_contains($categoryName, 'automotive')) {
                                $categoryIcon = 'car';
                            } elseif (str_contains($categoryName, 'ppf')) {
                                $categoryIcon = 'shield-check';
                            }
                        @endphp
                        <a href="{{ route('portfolio.show', $item['slug']) }}" class="cms-card cms-card--overlay cms-card--portfolio">
                            <div class="cms-card-media">
                                @if(!empty($item['cover']))
                                    <img src="{{ $item['cover']['url'] ?? $item['cover']['thumbnail_url'] }}" alt="{{ $item['cover']['alt_text'] ?? $item['title'] }}" loading="lazy">
                                @else
                                    <div class="cms-card-media-placeholder"></div>
                                @endif
                            </div>
                            <div class="cms-card-body">
                                @if(!empty($item['category']))
                                    <span class="cms-card-tagchip">
                                        @if($categoryIcon) @include('partials.icon', ['name' => $categoryIcon]) @endif
                                        {{ $item['category'] }}
                                    </span>
                                @endif
                                <h4>{{ $item['title'] }}</h4>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($meta && $meta['last_page'] > 1)
                    <nav class="cms-pagination">
                        @for($p = 1; $p <= $meta['last_page']; $p++)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $p]) }}" class="{{ $p === $meta['current_page'] ? 'is-active' : '' }}">{{ $p }}</a>
                        @endfor
                    </nav>
                @endif
            @endif
        </div>
    </section>

@endsection

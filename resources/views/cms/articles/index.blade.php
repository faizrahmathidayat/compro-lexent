@extends('layouts.app')

@section('title', 'Artikel')
@section('meta_description', 'Artikel dan tips seputar kaca film mobil, kaca film bangunan, dan PPF dari LEXENT.')

@section('content')

    <section class="page-header page-header--wide">
        <div class="page-header-media">
            <img src="{{ asset('images/hero/article-header.jpg') }}" alt="">
        </div>
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a> <span aria-hidden="true">&rsaquo;</span> <span aria-current="page">Artikel</span>
            </nav>
            <h1 class="page-title">Artikel &amp; Tips <span>Seputar Kaca Film &amp; PPF</span></h1>
            <p class="page-lead">Dapatkan informasi terbaru, tips perawatan, dan wawasan seputar kaca film dan PPF dari LEXENT.</p>
        </div>
    </section>

    <section style="padding-top: 0;">
        <div class="container">
            @if(!empty($categories))
                <nav class="cms-filter" aria-label="Filter kategori artikel">
                    <a href="{{ route('articles.index') }}" class="{{ $activeCategory === '' ? 'is-active' : '' }}">Semua</a>
                    @foreach($categories as $category)
                        <a href="{{ route('articles.index', ['category' => $category]) }}" class="{{ strcasecmp($activeCategory, $category) === 0 ? 'is-active' : '' }}">{{ $category }}</a>
                    @endforeach
                </nav>
            @endif

            @if(empty($items))
                <p class="section-subtitle" style="margin: var(--space-4) 0;">{{ $activeCategory !== '' ? 'Belum ada artikel untuk kategori ini.' : 'Konten belum tersedia saat ini.' }}</p>
            @else
                <div class="cms-grid">
                    @foreach($items as $item)
                        <a href="{{ route('articles.show', $item['slug']) }}" class="cms-card cms-card--overlay">
                            <div class="cms-card-media">
                                @if(!empty($item['cover']))
                                    <img src="{{ $item['cover']['thumbnail_url'] }}" alt="{{ $item['cover']['alt_text'] ?? $item['title'] }}" loading="lazy">
                                @else
                                    <div class="cms-card-media-placeholder"></div>
                                @endif
                            </div>
                            <div class="cms-card-body">
                                @if(!empty($item['published_at']))
                                    <span class="cms-card-date">{{ \Carbon\Carbon::parse($item['published_at'])->format('d M Y') }}</span>
                                @endif
                                <h4>{{ $item['title'] }}</h4>
                                <span class="cms-card-more">Baca Selengkapnya</span>
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

@extends('layouts.app')

@section('title', $page['title'])
@section('meta_description', $page['title'] . ' - katalog produk LEXENT.')

@php
    $kind = ['products.building' => 'building', 'products.automotive' => 'automotive', 'ppf.index' => 'ppf'][$page['route']] ?? 'all';
@endphp

@section('content')

    @include('partials.category-hero', ['kind' => $kind])

    <section style="padding-top: 0;" id="katalog">
        <div class="container">
            <h2 class="section-title-row">{{ $kind === 'ppf' ? 'Pilihan Produk PPF' : 'Pilih Jenis Produk' }}</h2>

            <nav class="series-filter series-filter--tabs" aria-label="Filter kategori produk">
                <a href="{{ route($page['route']) }}" class="{{ $activeCategory === '' ? 'is-active' : '' }}">Semua Seri</a>
                @foreach($categories as $category)
                    <a href="{{ route($page['route'], ['category' => $category]) }}" class="{{ strcasecmp($activeCategory, $category) === 0 ? 'is-active' : '' }}">{{ $category }}</a>
                @endforeach
            </nav>

            @if(empty($items))
                <p class="section-subtitle" style="margin: var(--space-4) 0 0;">{{ $activeCategory !== '' ? 'Tidak ada produk untuk kategori ini.' : 'Konten belum tersedia saat ini.' }}</p>
            @else
                <div class="product-grid">
                    @foreach($items as $item)
                        <div class="product-card">
                            @if(!empty($item['category']))
                                <span class="product-badge">{{ $item['category'] }}</span>
                            @endif
                            @if(!empty($item['cover']))
                                <a href="{{ route('sorotan.show', $item['slug']) }}" class="product-cover">
                                    <img src="{{ $item['cover']['thumbnail_url'] }}" alt="{{ $item['cover']['alt_text'] ?? $item['title'] }}" loading="lazy">
                                </a>
                            @else
                                <div class="product-visual {{ $kind === 'ppf' ? 'product-visual--ppf' : 'product-visual--' . $kind }}" data-series="{{ $item['category'] ?? '' }}"></div>
                            @endif
                            <h3>{{ $item['title'] }}</h3>
                            @if(!empty($item['excerpt']))
                                <p class="product-desc">{{ $item['excerpt'] }}</p>
                            @endif

                            @if(!empty($item['spec_highlights']))
                                <div class="spec-meters">
                                    @foreach($item['spec_highlights'] as $spec)
                                        <div class="spec-meter-head"><span>{{ $spec['label'] }}</span> <b>{{ $spec['value'] }}</b></div>
                                    @endforeach
                                </div>
                            @endif

                            <a href="{{ route('sorotan.show', $item['slug']) }}" class="btn btn-outline btn-block btn-arrow">Lihat Detail</a>
                        </div>
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

            @include('partials.category-extras', ['kind' => $kind])
        </div>
    </section>

@endsection

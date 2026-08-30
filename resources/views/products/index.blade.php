@extends('layouts.app')

@section('title', 'Produk')
@section('meta_description', 'Katalog lengkap kaca film Lexent - Automotive Series dan Architectural Series.')

@section('content')

    <section class="page-header">
        <div class="container">
            <span class="eyebrow">Product Lineup</span>
            <h1 class="section-title">Automotive &amp; Architectural Series</h1>
        </div>
    </section>

    <section style="padding-top: 0;">
        <div class="container">
            @foreach(['automotive' => 'Automotive Series', 'architectural' => 'Architectural Series'] as $category => $label)
                <div class="product-segment">
                    <div class="segment-head">
                        <h3>{{ $label }}</h3>
                        <span>{{ $category === 'automotive' ? 'Kaca Film Mobil' : 'Kaca Film Gedung & Komersial' }}</span>
                    </div>

                    <div class="product-grid">
                        @foreach($products as $product)
                            @continue($product['category'] !== $category)
                            <div class="product-card glass">
                                <span class="product-badge">{{ $product['badge'] }}</span>
                                <div class="product-visual {{ $product['accent'] }}">{{ $product['vlt'] }}</div>
                                <h3>{{ $product['name'] }}</h3>
                                <div class="product-tagline">{{ $product['tagline'] }}</div>
                                <p class="product-desc">{{ $product['short_description'] }}</p>

                                <div class="product-specs">
                                    <div>
                                        <b>{{ $product['vlt'] }}</b>
                                        <span>VLT</span>
                                    </div>
                                    <div>
                                        <b>{{ $product['heat_rejection'] }}</b>
                                        <span>Heat Reject</span>
                                    </div>
                                    <div>
                                        <b>{{ $product['irr'] }}</b>
                                        <span>IRR</span>
                                    </div>
                                </div>

                                <a href="{{ route('products.show', $product['slug']) }}" class="btn btn-outline btn-block">Lihat Detail</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection

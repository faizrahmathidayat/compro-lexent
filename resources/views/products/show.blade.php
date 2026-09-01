@extends('layouts.app')

@section('title', $product['name'])
@section('meta_description', $product['short_description'])

@section('content')

    <section style="padding-top: 160px;">
        <div class="container">
            <a href="{{ route('products.index') }}" class="back-link">&larr; Kembali ke Produk</a>

            <div class="product-detail-grid">
                <div class="product-detail-visual {{ $product['accent'] }}">{{ $product['vlt'] }}</div>

                <div>
                    <span class="product-badge" style="position: static; display: inline-block; margin-bottom: var(--space-2);">{{ $product['badge'] }}</span>
                    <span class="eyebrow" style="display: block;">{{ $product['category_label'] }}</span>
                    <h1 class="section-title">{{ $product['name'] }}</h1>
                    <p class="product-tagline" style="font-size: 1rem;">{{ $product['tagline'] }}</p>
                    <p class="section-subtitle" style="margin: var(--space-3) 0;">{{ $product['description'] }}</p>

                    <div class="product-detail-meters">
                        <div>
                            <div class="spec-meter-head"><span>VLT (Visible Light Transmission)</span> <b>{{ $product['vlt'] }}</b></div>
                            <div class="spec-meter-track"><div class="spec-meter-fill" style="width: {{ $product['vlt'] }};"></div></div>
                        </div>
                        <div>
                            <div class="spec-meter-head"><span>TSER (Heat Rejection)</span> <b>{{ $product['heat_rejection'] }}</b></div>
                            <div class="spec-meter-track"><div class="spec-meter-fill" style="width: {{ $product['heat_rejection'] }};"></div></div>
                        </div>
                        <div>
                            <div class="spec-meter-head"><span>IRR (Infrared Rejection)</span> <b>{{ $product['irr'] }}</b></div>
                            <div class="spec-meter-track"><div class="spec-meter-fill" style="width: {{ $product['irr'] }};"></div></div>
                        </div>
                        <div>
                            <div class="spec-meter-head"><span>UV Rejection</span> <b>{{ $product['uv'] }}</b></div>
                            <div class="spec-meter-track"><div class="spec-meter-fill" style="width: {{ $product['uv'] }};"></div></div>
                        </div>
                    </div>

                    <ul class="about-list">
                        @foreach($product['features'] as $feature)
                            <li><span class="check-dot">&#10003;</span> <span>{{ $feature }}</span></li>
                        @endforeach
                    </ul>

                    <div class="hero-actions" style="margin-top: var(--space-4);">
                        <a href="{{ route('dealers') }}" class="btn btn-cyan">Cari Dealer Terdekat</a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline">Bandingkan Varian Lain</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

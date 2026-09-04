@extends('layouts.app')

@section('title', $product['name'])
@section('meta_description', $product['name'] . ' - ' . $product['tagline'] . '. VLT ' . $product['vlt'] . ', TSER ' . $product['tser'] . ', UV rejection ' . $product['uv'] . ', infrared rejection ' . $product['irr'] . '.')

@section('content')

    <section style="padding-top: 160px;">
        <div class="container">
            <a href="{{ route('products.index') }}" class="back-link">&larr; Kembali ke Katalog</a>

            <div class="product-detail-grid">
                <div class="product-detail-visual {{ $product['accent'] }}" data-series="{{ $product['series_label'] }}">{{ $product['number'] }}</div>

                <div>
                    <span class="series-tag">{{ $product['series_label'] }}</span>
                    <h1 class="section-title">{{ $product['name'] }}</h1>
                    <p class="product-tagline" style="font-size: 1rem;">{{ $product['tagline'] }} &mdash; {{ $product['darkness'] }}</p>

                    <div class="attr-chips">
                        @foreach($product['attributes'] as $attr)
                            <span class="attr-chip">{{ $attr }}</span>
                        @endforeach
                    </div>

                    <p class="section-subtitle" style="margin: var(--space-3) 0;">{{ $product['series_description'] }}</p>

                    <div class="product-detail-meters">
                        <div class="spec-meter-head"><span>VLT (Visible Light Transmission)</span> <b>{{ $product['vlt'] }}</b></div>
                        <div class="spec-meter-head"><span>VLR (Visible Light Reflectance)</span> <b>{{ $product['vlr'] }}</b></div>
                        <div class="spec-meter-head"><span>TSER (Total Solar Energy Rejected)</span> <b>{{ $product['tser'] }}</b></div>
                        <div class="spec-meter-head"><span>UV Rejection</span> <b>{{ $product['uv'] }}</b></div>
                        <div class="spec-meter-head"><span>IRR Rejection (Infrared)</span> <b>{{ $product['irr'] }}</b></div>
                        <div class="spec-meter-head"><span>Thickness</span> <b>{{ $product['thickness'] }}</b></div>
                        <div class="spec-meter-head"><span>Garansi Resmi</span> <b>{{ $product['warranty_years'] }} Tahun</b></div>
                    </div>

                    <div class="hero-slide-actions" style="margin-top: var(--space-4);">
                        <a href="{{ route('dealers') }}" class="btn btn-gold">Cari Dealer Terdekat</a>
                        <a href="{{ route('cek-garansi') }}" class="btn btn-outline">Cek Garansi</a>
                    </div>

                    @if(!empty($related))
                        <div style="margin-top: var(--space-5);">
                            <span class="eyebrow">Varian Lain di Seri {{ $product['series'] }}</span>
                            <div class="series-filter" style="justify-content: flex-start; margin-bottom: 0;">
                                @foreach($related as $r)
                                    <a href="{{ route('products.show', $r['slug']) }}" class="tint-option" style="text-decoration: none;">{{ $r['series'] }} {{ $r['number'] }} &middot; VLT {{ $r['vlt'] }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection

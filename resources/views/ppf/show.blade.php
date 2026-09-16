@extends('layouts.app')

@section('title', $product['name'])
@section('meta_description', $product['name'] . ' - ' . $product['tagline'] . '. Ketebalan ' . $product['thickness'] . ', garansi resmi hingga ' . $product['warranty_years'] . ' tahun.')

@section('content')

    <section style="padding-top: 160px;">
        <div class="container">
            <a href="{{ route('ppf.index') }}" class="back-link">&larr; Paint Protection Film</a>

            <div class="product-detail-grid">
                <div class="product-detail-visual {{ $product['accent'] }}" data-series="Paint Protection Film">{{ $product['code'] }}</div>

                <div>
                    <span class="series-tag">Paint Protection Film</span>
                    <h1 class="section-title">{{ $product['name'] }}</h1>
                    <p class="product-tagline" style="font-size: 1rem;">{{ $product['tagline'] }}</p>

                    <div class="attr-chips">
                        @foreach($product['features'] as $feature)
                            <span class="attr-chip">{{ $feature }}</span>
                        @endforeach
                    </div>

                    <p class="section-subtitle" style="margin: var(--space-3) 0;">{{ $product['description'] }}</p>

                    <div class="product-detail-meters">
                        <div class="spec-meter-head"><span>Ketebalan</span> <b>{{ $product['thickness'] }}</b></div>
                        <div class="spec-meter-head"><span>Garansi Resmi</span> <b>{{ $product['warranty_years'] }} Tahun</b></div>
                        <div class="spec-meter-head"><span>Finishing</span> <b>{{ $product['finish'] }}</b></div>
                    </div>

                    <div class="hero-slide-actions" style="margin-top: var(--space-4);">
                        <a href="{{ route('cek-garansi') }}" class="btn btn-gold">Cek Garansi</a>
                    </div>

                    @if(!empty($related))
                        <div style="margin-top: var(--space-5);">
                            <span class="eyebrow">Tipe Lain Paint Protection Film</span>
                            <div class="series-filter" style="justify-content: flex-start; margin-bottom: 0;">
                                @foreach($related as $r)
                                    <a href="{{ route('ppf.show', $r['slug']) }}" class="tint-option" style="text-decoration: none;">{{ $r['label'] }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="section-head" style="margin-top: var(--space-6);">
                <span class="eyebrow">Keunggulan Material</span>
                <h2 class="section-title" style="font-size: 1.8rem;">Kenapa {{ $product['label'] }}</h2>
            </div>

            <div class="ppf-rating-grid">
                @foreach($product['attributes'] as $attr)
                    <div class="ppf-rating-card glass">
                        <span class="ppf-rating-label">{{ $attr['label'] }}</span>
                        <span class="ppf-rating-value">{{ $attr['rating'] }}</span>
                        <div class="ppf-rating-bar"><span style="width: 92%;"></span></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

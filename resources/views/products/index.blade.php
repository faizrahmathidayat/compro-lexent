@extends('layouts.app')

@section('title', 'Produk')
@section('meta_description', 'Katalog lengkap kaca film Lexent - Automotive Film dan Architectural Film.')

@section('content')

    <section class="page-header">
        <div class="container">
            <span class="eyebrow">Product Lineup</span>
            <h1 class="section-title">Automotive &amp; Architectural Film</h1>
        </div>
    </section>

    <section style="padding-top: 0;">
        <div class="container">
            <div class="tab-switcher" id="productTabs">
                <button type="button" class="tab-btn is-active" data-tab="automotive">Automotive Film</button>
                <button type="button" class="tab-btn" data-tab="architectural">Architectural Film</button>
            </div>

            @foreach(['automotive', 'architectural'] as $category)
                <div class="tab-panel {{ $category === 'automotive' ? 'is-active' : '' }}" data-panel="{{ $category }}">
                    <div class="product-grid">
                        @foreach($products as $product)
                            @continue($product['category'] !== $category)
                            <div class="product-card glass">
                                <span class="product-badge">{{ $product['badge'] }}</span>
                                <div class="product-visual {{ $product['accent'] }}">{{ $product['vlt'] }}</div>
                                <h3>{{ $product['name'] }}</h3>
                                <div class="product-tagline">{{ $product['tagline'] }}</div>
                                <p class="product-desc">{{ $product['short_description'] }}</p>

                                <div class="spec-meters">
                                    <div>
                                        <div class="spec-meter-head"><span>VLT</span> <b>{{ $product['vlt'] }}</b></div>
                                        <div class="spec-meter-track"><div class="spec-meter-fill" style="width: {{ $product['vlt'] }};"></div></div>
                                    </div>
                                    <div>
                                        <div class="spec-meter-head"><span>TSER</span> <b>{{ $product['heat_rejection'] }}</b></div>
                                        <div class="spec-meter-track"><div class="spec-meter-fill" style="width: {{ $product['heat_rejection'] }};"></div></div>
                                    </div>
                                    <div>
                                        <div class="spec-meter-head"><span>IRR</span> <b>{{ $product['irr'] }}</b></div>
                                        <div class="spec-meter-track"><div class="spec-meter-fill" style="width: {{ $product['irr'] }};"></div></div>
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

@section('scripts')
    <script>
        (function () {
            var tabs = document.querySelectorAll('#productTabs .tab-btn');
            var panels = document.querySelectorAll('.tab-panel');

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    var target = tab.getAttribute('data-tab');

                    tabs.forEach(function (t) { t.classList.remove('is-active'); });
                    tab.classList.add('is-active');

                    panels.forEach(function (panel) {
                        panel.classList.toggle('is-active', panel.getAttribute('data-panel') === target);
                    });
                });
            });
        })();
    </script>
@endsection

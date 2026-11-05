@extends('layouts.app')

@section('title', $segment === 'building' ? 'Kaca Film Bangunan' : ($segment === 'automotive' ? 'Kaca Film Mobil' : 'Produk'))
@section('meta_description', 'Katalog lengkap kaca film LEXENT - 32 varian VLT dari delapan seri, dua kategori: Automotive (BP, HT, MK, IR99) dan Building (Black Vision, Reflective, High Performance, Ultra Protect).')

@section('content')

    @include('partials.category-hero', ['kind' => $segment ?: 'all'])

    <section style="padding-top: 0;" id="katalog">
        <div class="container">
            <h2 class="section-title-row">Pilih Jenis Produk</h2>

            @if(!$segment)
                <div class="series-filter" id="segmentFilter">
                    <button type="button" class="is-active" data-segment="all">Semua Kategori</button>
                    <button type="button" data-segment="automotive">Automotive</button>
                    <button type="button" data-segment="building">Building</button>
                </div>
            @endif

            <div class="series-filter{{ $segment ? ' series-filter--tabs' : '' }}" id="seriesFilter">
                <button type="button" class="is-active" data-series="all">Semua Seri</button>
                @foreach($series as $s)
                    <button type="button" data-series="{{ $s['code'] }}" data-segment="{{ $s['segment'] }}">{{ $s['label'] }}</button>
                @endforeach
            </div>

            <div class="product-grid" id="productGrid">
                @foreach($products as $product)
                    <div class="product-card" data-series="{{ $product['series'] }}" data-segment="{{ $product['segment'] }}">
                        <span class="product-badge">{{ $product['badge'] }}</span>
                        <div class="product-visual product-visual--{{ $product['segment'] }} {{ $product['accent'] }}" data-series="{{ $product['series_label'] }}"><span>{{ $product['number'] }}</span></div>
                        <h3>{{ $product['name'] }}</h3>
                        <div class="product-tagline">{{ $product['tagline'] }}</div>
                        <p class="product-desc">{{ $product['darkness'] }}</p>

                        <div class="spec-meters">
                            <div class="spec-meter-head"><span>VLT</span> <b>{{ $product['vlt'] }}</b></div>
                            <div class="spec-meter-head"><span>TSER</span> <b>{{ $product['tser'] }}</b></div>
                            <div class="spec-meter-head"><span>UV Rejection</span> <b>{{ $product['uv'] }}</b></div>
                            <div class="spec-meter-head"><span>IRR Rejection</span> <b>{{ $product['irr'] }}</b></div>
                        </div>

                        <a href="{{ route('products.show', $product['slug']) }}" class="btn btn-outline btn-block">Lihat Detail</a>
                    </div>
                @endforeach
            </div>

            <p id="productEmpty" class="section-subtitle" style="display: none; margin: var(--space-4) 0 0;">
                Tidak ada varian untuk pilihan ini.
            </p>

            @include('partials.category-extras', ['kind' => $segment ?: 'all'])
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        (function () {
            var segmentButtons = document.querySelectorAll('#segmentFilter button');
            var seriesButtons = document.querySelectorAll('#seriesFilter button');
            var cards = document.querySelectorAll('#productGrid .product-card');
            var empty = document.getElementById('productEmpty');

            var currentSegment = 'all';
            var currentSeries = 'all';

            function applyFilters() {
                var visible = 0;

                cards.forEach(function (card) {
                    var matchSegment = currentSegment === 'all' || card.getAttribute('data-segment') === currentSegment;
                    var matchSeries = currentSeries === 'all' || card.getAttribute('data-series') === currentSeries;
                    var match = matchSegment && matchSeries;
                    card.style.display = match ? '' : 'none';
                    if (match) { visible++; }
                });

                empty.style.display = visible === 0 ? 'block' : 'none';
            }

            function refreshSeriesVisibility() {
                seriesButtons.forEach(function (btn) {
                    var series = btn.getAttribute('data-series');
                    var segment = btn.getAttribute('data-segment');
                    var show = series === 'all' || currentSegment === 'all' || segment === currentSegment;
                    btn.classList.toggle('is-hidden-filter', !show);
                });
            }

            function setSegment(segment) {
                currentSegment = segment;
                currentSeries = 'all';

                segmentButtons.forEach(function (b) { b.classList.toggle('is-active', b.getAttribute('data-segment') === segment); });
                seriesButtons.forEach(function (b) { b.classList.toggle('is-active', b.getAttribute('data-series') === 'all'); });

                refreshSeriesVisibility();
                applyFilters();
            }

            function setSeries(series) {
                currentSeries = series;
                seriesButtons.forEach(function (b) { b.classList.toggle('is-active', b.getAttribute('data-series') === series); });
                applyFilters();
            }

            segmentButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    setSegment(btn.getAttribute('data-segment'));
                });
            });

            seriesButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    setSeries(btn.getAttribute('data-series'));
                });
            });

            var requestedSegment = new URLSearchParams(window.location.search).get('segment');
            if (segmentButtons.length && (requestedSegment === 'automotive' || requestedSegment === 'building')) {
                setSegment(requestedSegment);
            } else {
                refreshSeriesVisibility();
            }

            // Deep link from the navbar dropdown, e.g. /kaca-film-mobil?series=HT
            var requestedSeries = new URLSearchParams(window.location.search).get('series');
            if (requestedSeries) {
                var seriesMatch = Array.prototype.find.call(seriesButtons, function (btn) {
                    return btn.getAttribute('data-series').toLowerCase() === requestedSeries.toLowerCase()
                        && !btn.classList.contains('is-hidden-filter');
                });
                if (seriesMatch) {
                    setSeries(seriesMatch.getAttribute('data-series'));
                }
            }
        })();
    </script>
@endsection

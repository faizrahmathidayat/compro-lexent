@extends('layouts.app')

@section('title', 'Dealer')
@section('meta_description', 'Temukan Authorized Outlet dan dealer resmi Lexent di seluruh Indonesia.')

@section('content')

    <section class="page-header">
        <div class="container">
            <span class="eyebrow">Dealer Locator</span>
            <h1 class="section-title">Authorized Outlet Lexent Seluruh Indonesia</h1>
        </div>
    </section>

    <section style="padding-top: 0;">
        <div class="container">
            <div class="dealer-filter" id="dealerFilter">
                <button type="button" class="is-active" data-city="all">Semua Kota</button>
                @foreach($cities as $city)
                    <button type="button" data-city="{{ $city }}">{{ $city }}</button>
                @endforeach
            </div>

            <div class="dealer-grid" id="dealerGrid">
                @foreach($dealers as $dealer)
                    <div class="dealer-card glass" data-city="{{ $dealer['city'] }}">
                        <div>
                            <span class="dealer-city">{{ $dealer['city'] }}</span>
                            <h4>{{ $dealer['name'] }}</h4>
                            <p>{{ $dealer['address'] }}</p>
                            <p>{{ $dealer['phone'] }}</p>
                        </div>
                        <a href="{{ $dealer['maps_url'] }}" target="_blank" rel="noopener" class="btn btn-outline">Buka Peta</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        (function () {
            var filterButtons = document.querySelectorAll('#dealerFilter button');
            var dealerCards = document.querySelectorAll('#dealerGrid .dealer-card');

            filterButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var city = btn.getAttribute('data-city');

                    filterButtons.forEach(function (b) { b.classList.remove('is-active'); });
                    btn.classList.add('is-active');

                    dealerCards.forEach(function (card) {
                        var match = city === 'all' || card.getAttribute('data-city') === city;
                        card.classList.toggle('is-hidden', !match);
                    });
                });
            });
        })();
    </script>
@endsection

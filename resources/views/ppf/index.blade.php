@extends('layouts.app')

@section('title', 'Paint Protection Film')
@section('meta_description', 'LEXENT Paint Protection Film - empat tipe PPF untuk melindungi cat mobil dari goresan, kerikil, dan noda: Type S, Type T Plus, Type L, dan Type L Matte. Garansi resmi hingga 10 tahun.')

@section('content')

    @include('partials.category-hero', ['kind' => 'ppf'])

    <section style="padding-top: 0;" id="katalog">
        <div class="container">
            <h2 class="section-title-row">Pilihan Produk PPF</h2>

            <div class="product-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <span class="product-badge">Garansi {{ $product['warranty_years'] }} Tahun</span>
                        <div class="product-visual product-visual--ppf {{ $product['accent'] }}" data-series="Paint Protection Film"><span>{{ $product['code'] }}</span></div>
                        <h3>{{ $product['name'] }}</h3>
                        <div class="product-tagline">{{ $product['tagline'] }}</div>
                        <p class="product-desc">{{ $product['description'] }}</p>

                        <div class="spec-meters">
                            <div class="spec-meter-head"><span>Ketebalan</span> <b>{{ $product['thickness'] }}</b></div>
                            <div class="spec-meter-head"><span>Finishing</span> <b>{{ $product['finish'] }}</b></div>
                        </div>

                        <a href="{{ route('ppf.show', $product['slug']) }}" class="btn btn-outline btn-block btn-arrow">Lihat Detail</a>
                    </div>
                @endforeach
            </div>

            @include('partials.category-extras', ['kind' => 'ppf'])
        </div>
    </section>

@endsection

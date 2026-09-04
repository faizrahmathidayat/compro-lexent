@extends('layouts.app')

@section('title', 'Paint Protection Film')
@section('meta_description', 'LEXENT Paint Protection Film - empat tipe PPF untuk melindungi cat mobil dari goresan, kerikil, dan noda: Type S, Type T Plus, Type L, dan Type L Matte. Garansi resmi hingga 10 tahun.')

@section('content')

    <section class="page-header">
        <div class="container">
            <span class="eyebrow">Automotive Accessory</span>
            <h1 class="section-title">LEXENT Paint Protection Film</h1>
            <p class="section-subtitle" style="max-width: 640px;">
                Lapisan TPU pelindung cat mobil dari goresan, kerikil, dan noda harian &mdash;
                empat tipe dengan karakter self-healing, kilau, dan finishing yang berbeda.
            </p>
        </div>
    </section>

    <section style="padding-top: 0;">
        <div class="container">
            <div class="product-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <span class="product-badge">Garansi {{ $product['warranty_years'] }} Tahun</span>
                        <div class="product-visual {{ $product['accent'] }}" data-series="Paint Protection Film">{{ $product['code'] }}</div>
                        <h3>{{ $product['name'] }}</h3>
                        <div class="product-tagline">{{ $product['tagline'] }}</div>
                        <p class="product-desc">{{ $product['description'] }}</p>

                        <div class="spec-meters">
                            <div class="spec-meter-head"><span>Ketebalan</span> <b>{{ $product['thickness'] }}</b></div>
                            <div class="spec-meter-head"><span>Finishing</span> <b>{{ $product['finish'] }}</b></div>
                        </div>

                        <a href="{{ route('ppf.show', $product['slug']) }}" class="btn btn-outline btn-block">Lihat Detail</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

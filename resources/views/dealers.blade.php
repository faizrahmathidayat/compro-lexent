@extends('layouts.app')

@section('title', 'Alamat')
@section('meta_description', 'Alamat kantor resmi LEXENT untuk kebutuhan konsultasi dan pemasangan Automotive & Building Windowfilm.')

@section('content')

    <section class="page-header">
        <div class="page-header-media">
            <img src="{{ asset('images/category/building.jpg') }}" alt="">
        </div>
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a> <span aria-hidden="true">&rsaquo;</span> <span aria-current="page">Kontak</span>
            </nav>
            <h1 class="page-title">Hubungi Kami <span>Lokasi Kantor LEXENT</span></h1>
            <p class="page-lead">Kunjungi kantor resmi LEXENT atau hubungi kami untuk konsultasi produk kaca film dan PPF.</p>
        </div>
    </section>

    <section style="padding-top: 0;">
        <div class="container">
            <div class="map-embed" style="margin-bottom: var(--space-3);">
                <iframe src="{{ $address['maps_embed'] }}" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" title="Lokasi {{ $address['name'] }}"></iframe>
            </div>

            <div class="dealer-card-h glass">
                <div class="dealer-main">
                    <div class="dealer-info">
                        <h4>{{ $address['name'] }}</h4>
                        <p>{{ $address['address'] }}</p>
                        <p>{{ $address['phone'] }}</p>
                        <p>{{ $address['email'] }}</p>
                    </div>
                </div>
                <a href="{{ $address['maps_url'] }}" target="_blank" rel="noopener" class="btn btn-outline btn-sm">Buka Peta</a>
            </div>
        </div>
    </section>

@endsection

@extends('layouts.app')

@section('title', 'Cek Garansi')
@section('meta_description', 'Cek status garansi resmi film LEXENT menggunakan kode warranty Anda.')

@section('content')

    <section class="page-header page-header--warranty">
        <div class="page-header-media">
            <img src="{{ asset('images/hero/hero-home.jpg') }}" alt="">
        </div>
        <span class="warranty-hero-shield" aria-hidden="true">
            <svg viewBox="0 0 200 240" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="shieldRim" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0" stop-color="#fff0a8"/>
                        <stop offset="0.45" stop-color="#ffc20e"/>
                        <stop offset="1" stop-color="#b57a00"/>
                    </linearGradient>
                    <linearGradient id="shieldFace" x1="0" y1="0" x2="1" y2="0">
                        <stop offset="0" stop-color="#34353b"/>
                        <stop offset="0.5" stop-color="#17181c"/>
                        <stop offset="0.5" stop-color="#0e0f12"/>
                        <stop offset="1" stop-color="#050506"/>
                    </linearGradient>
                    <linearGradient id="shieldCheck" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0" stop-color="#ffe27a"/>
                        <stop offset="1" stop-color="#e0a000"/>
                    </linearGradient>
                </defs>
                <path d="M100 6 C128 28 158 33 190 34 V118 C190 180 150 214 100 234 C50 214 10 180 10 118 V34 C42 33 72 28 100 6 Z" fill="url(#shieldRim)"/>
                <path d="M100 20 C124 38 148 43 176 44 V118 C176 170 143 199 100 217 C57 199 24 170 24 118 V44 C52 43 76 38 100 20 Z" fill="url(#shieldFace)"/>
                <path d="M62 120 L90 148 L140 92" fill="none" stroke="url(#shieldCheck)" stroke-width="17" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a> <span aria-hidden="true">&rsaquo;</span> <span aria-current="page">Warranty</span>
            </nav>
            <h1 class="page-title">Cek Garansi Anda <span>dengan Mudah</span></h1>
            <p class="page-lead">Masukkan kode warranty Anda untuk melihat detail dan masa garansi produk LEXENT.</p>

            <div class="check-warranty-card">
                <form class="check-warranty-form" id="checkWarrantyForm">
                    <span class="check-warranty-badge" aria-hidden="true">@include('partials.icon', ['name' => 'shield-check'])</span>
                    <label class="check-warranty-field">
                        <input
                            type="text"
                            id="warrantyCode"
                            name="warranty_code"
                            placeholder="Masukkan Kode Warranty"
                            aria-label="Kode warranty"
                            autocomplete="off"
                            required>
                    </label>
                    <button type="submit" class="btn btn-gold btn-arrow" id="checkWarrantyBtn">Cek Sekarang</button>
                </form>

                <p class="check-warranty-message" id="checkWarrantyMessage" role="status"></p>
            </div>
        </div>
    </section>

    <section class="trust-section">
        <div class="container">
            <div class="trust-row">
                <div class="trust-item">
                    @include('partials.icon', ['name' => 'shield-plus'])
                    <div><b>Garansi Resmi</b><span>Produk LEXENT</span></div>
                </div>
                <div class="trust-item">
                    @include('partials.icon', ['name' => 'shield-tick'])
                    <div><b>Perlindungan Maksimal</b><span>untuk Jangka Panjang</span></div>
                </div>
                <div class="trust-item">
                    @include('partials.icon', ['name' => 'shield-plus'])
                    <div><b>Layanan Profesional</b><span>untuk Anda</span></div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        (function () {
            var DASHBOARD_BASE_URL = @json($dashboardBaseUrl);

            var form = document.getElementById('checkWarrantyForm');
            var input = document.getElementById('warrantyCode');
            var button = document.getElementById('checkWarrantyBtn');
            var message = document.getElementById('checkWarrantyMessage');

            function setMessage(text, type) {
                message.textContent = text;
                message.className = 'check-warranty-message' + (type ? ' is-' + type : '');
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                var kode = input.value.trim().toUpperCase();

                if (!kode) {
                    setMessage('Silakan masukkan kode warranty terlebih dahulu.', 'error');
                    return;
                }

                button.disabled = true;
                button.textContent = 'Memeriksa...';
                setMessage('', '');

                fetch(DASHBOARD_BASE_URL + '/warranty/' + encodeURIComponent(kode) + '/check')
                    .then(function (res) {
                        if (!res.ok) {
                            throw new Error('request_failed');
                        }
                        return res.json();
                    })
                    .then(function (data) {
                        if (data.valid) {
                            setMessage('Kode warranty ditemukan. Mengalihkan...', 'success');
                            window.location.href = DASHBOARD_BASE_URL + '/warranty/' + encodeURIComponent(kode);
                        } else {
                            setMessage('Kode warranty tidak ditemukan atau sudah tidak berlaku.', 'error');
                        }
                    })
                    .catch(function () {
                        setMessage('Gagal menghubungi server. Silakan coba lagi.', 'error');
                    })
                    .finally(function () {
                        button.disabled = false;
                        button.textContent = 'Cek Sekarang';
                    });
            });
        })();
    </script>
@endsection

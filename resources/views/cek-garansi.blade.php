@extends('layouts.app')

@section('title', 'Cek Garansi')
@section('meta_description', 'Cek status garansi resmi film LEXENT menggunakan kode warranty Anda.')

@section('content')

    <section class="page-header page-header--warranty">
        <div class="page-header-media">
            <img src="{{ asset('images/hero/warranty-header.jpg') }}" alt="">
        </div>
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

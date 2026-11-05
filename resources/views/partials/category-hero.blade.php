{{-- Hero for the catalog pages. Expects $kind: building | automotive | ppf | all --}}
@php
    $heroes = [
        'building' => ['kicker' => 'Kaca Film Bangunan', 'top' => 'Kaca Film', 'hl' => 'Bangunan', 'text' => 'Reduksi panas, perlindungan UV, privasi dan efisiensi energi.', 'image' => 'images/hero/building-tower.jpg'],
        'automotive' => ['kicker' => 'Kaca Film Mobil', 'top' => 'Kaca Film', 'hl' => 'Mobil', 'text' => 'Kenyamanan berkendara, reduksi panas, dan privasi lebih maksimal.', 'image' => 'images/hero/car-porsche.jpg'],
        'ppf' => ['kicker' => 'Paint Protection Film', 'top' => 'Paint Protection', 'hl' => 'Film', 'text' => 'Lindungi cat kendaraan Anda dari goresan, batu kecil, dan noda sehari-hari.', 'image' => 'images/hero/ppf-peel.jpg'],
        'all' => ['kicker' => 'Katalog Produk', 'top' => 'Katalog', 'hl' => 'Film LEXENT', 'text' => 'Kaca film mobil, kaca film bangunan, dan paint protection film dalam satu katalog.', 'image' => 'images/hero/hero-home.jpg'],
    ];
    $hero = $heroes[$kind] ?? $heroes['all'];
@endphp
<section class="page-header page-header--category">
    <div class="page-header-media">
        <img src="{{ asset($hero['image']) }}" alt="">
    </div>
    <div class="container">
        <span class="eyebrow">{{ $hero['kicker'] }}</span>
        <h1 class="page-title">{{ $hero['top'] }} <span>{{ $hero['hl'] }}</span></h1>
        <p class="page-lead">{{ $hero['text'] }}</p>
        <div class="hero-actions">
            <a href="https://wa.me/6285888899558" target="_blank" rel="noopener" class="btn btn-gold btn-arrow">Konsultasi Sekarang</a>
            <a href="#katalog" class="btn btn-ghost">Lihat Detail @include('partials.icon', ['name' => 'info'])</a>
        </div>
    </div>
</section>

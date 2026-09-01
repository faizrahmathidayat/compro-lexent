@extends('layouts.app')

@section('title', 'About')
@section('meta_description', 'Mengenal lebih dekat Lexent - brand kaca film otomotif & arsitektural premium.')

@section('content')

    <section class="page-header">
        <div class="container">
            <span class="eyebrow">About Lexent</span>
            <h1 class="section-title">Keunggulan yang Terlihat, Perlindungan yang Terasa</h1>
        </div>
    </section>

    <section>
        <div class="container about-grid">
            <div>
                <span class="eyebrow">Our Philosophy</span>
                <h2 class="section-title">Lebih dari Sekadar Kaca Film</h2>
                <p class="section-subtitle" style="margin-bottom: var(--space-3);">
                    Lexent lahir dari keyakinan bahwa setiap ruang — baik kabin kendaraan
                    maupun gedung perkantoran — layak mendapatkan perlindungan terbaik.
                    Kami memadukan riset material tingkat lanjut dengan estetika platinum
                    yang mewah, menghadirkan produk yang tidak hanya melindungi, tetapi
                    juga meningkatkan karakter ruang Anda.
                </p>
                <ul class="about-list">
                    <li><span class="check-dot">&#10003;</span> <span><b>Riset &amp; Pengembangan</b> — material diuji pada iklim tropis ekstrem.</span></li>
                    <li><span class="check-dot">&#10003;</span> <span><b>Kontrol Kualitas Ketat</b> — setiap gulungan melalui inspeksi berlapis.</span></li>
                    <li><span class="check-dot">&#10003;</span> <span><b>Layanan Purna Jual</b> — garansi resmi di seluruh jaringan dealer.</span></li>
                </ul>
            </div>

            <div class="about-visual">
                <div class="about-visual-inner">LX</div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Visi &amp; Misi</span>
                <h2 class="section-title">Komitmen Jangka Panjang Lexent</h2>
            </div>

            <div class="tech-grid">
                <div class="tech-card glass">
                    <div class="tech-icon">&#127919;</div>
                    <h4>Visi</h4>
                    <p>Menjadi merek kaca film premium terpercaya nomor satu di Indonesia untuk sektor otomotif dan arsitektural.</p>
                </div>
                <div class="tech-card glass">
                    <div class="tech-icon">&#128295;</div>
                    <h4>Misi</h4>
                    <p>Menghadirkan inovasi material pelindung yang teruji secara laboratorium dan dipasang oleh jaringan installer bersertifikat.</p>
                </div>
                <div class="tech-card glass">
                    <div class="tech-icon">&#129309;</div>
                    <h4>Komitmen</h4>
                    <p>Memberikan garansi resmi yang transparan dan dapat diverifikasi kapan saja oleh setiap pelanggan Lexent.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-band">
        <div class="container">
            <div class="glass">
                <h2>Jelajahi Lini Produk Lexent</h2>
                <p>Temukan varian yang paling sesuai dengan kebutuhan kendaraan atau gedung Anda.</p>
                <a href="{{ route('products.index') }}" class="btn btn-cyan">Lihat Produk</a>
            </div>
        </div>
    </section>

@endsection

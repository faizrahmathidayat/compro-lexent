@extends('layouts.app')

@section('title', 'About')
@section('meta_description', 'Mengenal LEXENT - Superior Windowfilm Solution untuk otomotif. Empat seri film, penolakan UV 99%, garansi resmi hingga 7 tahun.')

@section('content')

    <section class="page-header">
        <div class="container">
            <span class="eyebrow">About LEXENT</span>
            <h1 class="section-title">Superior Windowfilm Solution</h1>
        </div>
    </section>

    <section>
        <div class="container about-grid">
            <div>
                <span class="eyebrow">Our Philosophy</span>
                <h2 class="section-title">Clear Vision. Cool Comfort. Lasting Protection.</h2>
                <p class="section-subtitle" style="margin-bottom: var(--space-3);">
                    LEXENT fokus pada satu kategori dan menguasainya: kaca film otomotif.
                    Setiap seri &mdash; BP, HT, MK, dan IR99 &mdash; punya teknologi inti yang
                    berbeda, namun standar yang sama: menolak 99% sinar UV, menahan panas
                    dan inframatahari, serta menjaga pandangan tetap jernih di segala kondisi.
                </p>
                <ul class="about-list">
                    <li><span class="check-dot">&#10003;</span> <span><b>Nano Ceramic &amp; UV400</b> &mdash; perlindungan UV maksimal tanpa mengorbankan kejernihan.</span></li>
                    <li><span class="check-dot">&#10003;</span> <span><b>Magnetron Sputter</b> &mdash; insulasi panas tinggi, non-metal, bebas gangguan sinyal.</span></li>
                    <li><span class="check-dot">&#10003;</span> <span><b>Low Haze &amp; High Definition</b> &mdash; visibilitas aman siang dan malam.</span></li>
                </ul>
            </div>

            <div class="about-visual">
                <div class="about-visual-inner">LEX<span>ENT</span></div>
            </div>
        </div>
    </section>

    <section class="section-alt">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Tiga Janji LEXENT</span>
                <h2 class="section-title">Enhance &middot; Protect &middot; Elevate</h2>
            </div>

            <div class="tech-grid">
                <div class="tech-card glass">
                    <div class="tech-icon">&#10052;</div>
                    <h4>Enhance Comfort</h4>
                    <p>Menahan panas dan inframatahari sebelum menembus kabin, sehingga suhu di dalam kendaraan tetap terkendali.</p>
                </div>
                <div class="tech-card glass">
                    <div class="tech-icon">&#128737;</div>
                    <h4>Protect What Matters</h4>
                    <p>UV rejection 99% di seluruh seri melindungi kulit penumpang dan mencegah interior cepat pudar serta getas.</p>
                </div>
                <div class="tech-card glass">
                    <div class="tech-icon">&#9889;</div>
                    <h4>Elevate Every Drive</h4>
                    <p>Kejernihan HD, low haze, dan tampilan yang bersih membuat setiap perjalanan terasa lebih tenang dan berkelas.</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Garansi</span>
                <h2 class="section-title">Terlindungi Hingga 7 Tahun</h2>
                <p class="section-subtitle">
                    Film LEXENT yang dipasang di dealer resmi tercatat sejak hari pemasangan
                    dan dapat diverifikasi kapan saja lewat halaman Cek Garansi.
                </p>
            </div>
        </div>
    </section>

    <section class="cta-band">
        <div class="container">
            <div class="glass">
                <h2>Jelajahi Katalog LEXENT</h2>
                <p>18 varian VLT dari empat seri &mdash; temukan yang paling sesuai dengan kendaraan Anda.</p>
                <a href="{{ route('products.index') }}" class="btn btn-gold">Lihat Produk</a>
            </div>
        </div>
    </section>

@endsection

@extends('layouts.app')

@section('title', 'Lexent')
@section('meta_description', 'Lexent - kaca film otomotif & arsitektural premium dengan Solar Control dan Security Film kelas atas.')

@section('content')

    {{-- ============================= HERO ============================= --}}
    <section class="hero">
        <div class="container hero-content">
            <span class="eyebrow">Solar Control &amp; Security Films</span>
            <h1 class="hero-title">
                Perlindungan Premium untuk <span class="highlight">Setiap Ruang &amp; Perjalanan</span>
            </h1>
            <p class="hero-subtext">
                Lexent menghadirkan kaca film kelas atas untuk kendaraan dan gedung —
                menyatukan proteksi panas maksimal, keamanan struktural, dan estetika
                platinum yang tak lekang oleh waktu.
            </p>
            <div class="hero-actions">
                <a href="{{ route('products.index') }}" class="btn btn-gold">Lihat Lini Produk</a>
                <a href="{{ route('dealers') }}" class="btn btn-outline">Find Authorized Dealer</a>
            </div>

            <div class="hero-stats">
                <div class="hero-stat">
                    <b>98%</b>
                    <span>Infrared Rejection</span>
                </div>
                <div class="hero-stat">
                    <b>200+</b>
                    <span>Authorized Dealer</span>
                </div>
                <div class="hero-stat">
                    <b>12 Thn</b>
                    <span>Garansi Resmi</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================= ABOUT / BRAND STORY ============================= --}}
    <section id="about">
        <div class="container about-grid">
            <div>
                <span class="eyebrow">Brand Story</span>
                <h2 class="section-title">Rekayasa Presisi untuk Ruang &amp; Jalanan Indonesia</h2>
                <p class="section-subtitle" style="margin-bottom: var(--space-3);">
                    Lexent berkomitmen menghadirkan kaca film dengan standar optik dan
                    termal tertinggi, untuk kendaraan maupun gedung. Setiap lapisan
                    diproduksi melalui proses sputtering multi-layer untuk memastikan
                    konsistensi warna, ketahanan jangka panjang, dan performa penolakan
                    panas yang terukur secara laboratorium.
                </p>
                <ul class="about-list">
                    <li><span class="check-dot">&#10003;</span> <span><b>Sputtering Technology</b> — lapisan metal presisi tanpa gangguan sinyal.</span></li>
                    <li><span class="check-dot">&#10003;</span> <span><b>Superior Heat Rejection</b> — menahan panas sebelum menembus kaca.</span></li>
                    <li><span class="check-dot">&#10003;</span> <span><b>Anti-Shatter Safety</b> — mengikat pecahan kaca saat terjadi benturan.</span></li>
                </ul>
            </div>

            <div class="about-visual">
                <div class="about-visual-inner">LX</div>
            </div>
        </div>
    </section>

    {{-- ============================= PRODUCT LINEUP ============================= --}}
    <section id="products">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Product Lineup</span>
                <h2 class="section-title">Automotive &amp; Architectural Series</h2>
                <p class="section-subtitle" style="margin: 0 auto;">
                    Dua lini Lexent dirancang untuk kebutuhan berbeda — dari kendaraan
                    pribadi hingga gedung komersial berskala besar.
                </p>
            </div>

            @foreach(['automotive' => 'Automotive Series', 'architectural' => 'Architectural Series'] as $category => $label)
                <div class="product-segment">
                    <div class="segment-head">
                        <h3>{{ $label }}</h3>
                        <span>{{ $category === 'automotive' ? 'Kaca Film Mobil' : 'Kaca Film Gedung & Komersial' }}</span>
                    </div>

                    <div class="product-grid">
                        @foreach($products as $product)
                            @continue($product['category'] !== $category)
                            <div class="product-card glass">
                                <span class="product-badge">{{ $product['badge'] }}</span>
                                <div class="product-visual {{ $product['accent'] }}">{{ $product['vlt'] }}</div>
                                <h3>{{ $product['name'] }}</h3>
                                <div class="product-tagline">{{ $product['tagline'] }}</div>
                                <p class="product-desc">{{ $product['short_description'] }}</p>

                                <div class="product-specs">
                                    <div>
                                        <b>{{ $product['vlt'] }}</b>
                                        <span>VLT</span>
                                    </div>
                                    <div>
                                        <b>{{ $product['heat_rejection'] }}</b>
                                        <span>Heat Reject</span>
                                    </div>
                                    <div>
                                        <b>{{ $product['irr'] }}</b>
                                        <span>IRR</span>
                                    </div>
                                </div>

                                <a href="{{ route('products.show', $product['slug']) }}" class="btn btn-outline btn-block">Lihat Detail</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============================= TECHNOLOGY SHOWCASE ============================= --}}
    <section id="technology">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Why Lexent</span>
                <h2 class="section-title">Teknologi di Balik Setiap Lapisan</h2>
                <p class="section-subtitle" style="margin: 0 auto;">
                    Tiga pilar teknologi yang membedakan Lexent dari kaca film pada umumnya.
                </p>
            </div>

            <div class="tech-grid">
                <div class="tech-card glass">
                    <div class="tech-icon">&#9889;</div>
                    <h4>Sputtering Technology</h4>
                    <p>Lapisan metal presisi multi-layer, dilapiskan lewat proses vakum untuk konsistensi optik dan termal.</p>
                </div>
                <div class="tech-card glass">
                    <div class="tech-icon">&#9728;</div>
                    <h4>Superior Heat Rejection</h4>
                    <p>Memantulkan radiasi matahari sebelum diserap oleh kaca kendaraan maupun gedung.</p>
                </div>
                <div class="tech-card glass">
                    <div class="tech-icon">&#128737;</div>
                    <h4>Anti-Shatter Safety</h4>
                    <p>Lapisan polyester berkekuatan tinggi yang mengikat pecahan kaca akibat benturan.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================= TINT SIMULATOR ============================= --}}
    <section id="simulator">
        <div class="container simulator">
            <div class="simulator-preview">
                <div class="simulator-window">
                    <div class="simulator-overlay" id="tintOverlay"></div>
                </div>
            </div>

            <div class="simulator-controls">
                <span class="eyebrow">Interactive Preview</span>
                <h3 class="section-title" style="font-size: 1.8rem;">Simulasi Kegelapan Kaca Film Lexent</h3>
                <p>Pilih persentase kegelapan Lexent dan lihat pratinjaunya secara langsung.</p>

                <div class="tint-options" id="tintOptions">
                    <button type="button" class="tint-option" data-tint="20">20%</button>
                    <button type="button" class="tint-option is-active" data-tint="40">40%</button>
                    <button type="button" class="tint-option" data-tint="60">60%</button>
                    <button type="button" class="tint-option" data-tint="80">80%</button>
                </div>

                <p class="simulator-readout">Tingkat kegelapan terpilih: <b id="tintReadout">40%</b></p>
            </div>
        </div>
    </section>

    {{-- ============================= DEALER / WORKSHOP LOCATOR ============================= --}}
    <section id="dealers">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Dealer Locator</span>
                <h2 class="section-title">Authorized Dealer &amp; Workshop Lexent</h2>
                <p class="section-subtitle" style="margin: 0 auto;">
                    Pemasangan hanya dilakukan oleh installer resmi bersertifikat Lexent.
                </p>
            </div>

            <div class="dealer-filter" id="dealerFilter">
                <button type="button" class="is-active" data-city="all">Semua Kota</button>
                @foreach(collect($dealers)->pluck('city')->unique() as $city)
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

    {{-- ============================= WARRANTY INFO & CONTACT BANNER ============================= --}}
    <section class="warranty-banner">
        <div class="container">
            <div class="glass">
                <div>
                    <span class="eyebrow">Official Warranty</span>
                    <h2 class="section-title" style="font-size: 1.8rem;">Garansi Resmi Lexent</h2>
                    <p style="color: var(--color-text-muted);">
                        Setiap produk Lexent yang dipasang di jaringan dealer resmi
                        dilindungi garansi resmi hingga 12 tahun, tercatat dan dapat
                        diverifikasi kapan saja secara online.
                    </p>

                    <div class="warranty-points">
                        <div><span class="check-dot">&#10003;</span> <span>Garansi hingga 12 tahun</span></div>
                        <div><span class="check-dot">&#10003;</span> <span>Verifikasi kode online</span></div>
                        <div><span class="check-dot">&#10003;</span> <span>Klaim di seluruh dealer resmi</span></div>
                        <div><span class="check-dot">&#10003;</span> <span>Terdaftar sejak hari pemasangan</span></div>
                    </div>
                </div>

                <div class="warranty-actions">
                    <a href="{{ route('cek-garansi') }}" class="btn btn-gold">Cek Garansi Saya</a>
                    <a href="{{ route('dealers') }}" class="btn btn-outline">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        (function () {
            var overlay = document.getElementById('tintOverlay');
            var readout = document.getElementById('tintReadout');
            var options = document.querySelectorAll('#tintOptions .tint-option');

            function applyTint(percent) {
                overlay.style.opacity = percent / 100;
                readout.textContent = percent + '%';
            }

            options.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    options.forEach(function (b) { b.classList.remove('is-active'); });
                    btn.classList.add('is-active');
                    applyTint(parseInt(btn.getAttribute('data-tint'), 10));
                });
            });

            applyTint(40);
        })();

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

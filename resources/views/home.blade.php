@extends('layouts.app')

@section('title', 'LEXENT')
@section('meta_description', 'LEXENT - Superior Windowfilm Solution untuk Automotive & Building. Delapan seri, 32 varian VLT. UV rejection hingga 99%, heat rejection hingga 81%, garansi resmi hingga 8 tahun.')

@section('content')

    {{-- ============================= HERO ============================= --}}
    <section class="hero" id="heroSection">
        @foreach($highlights as $i => $slide)
            <div class="hero-slide{{ $i === 0 ? ' is-active' : '' }}" data-index="{{ $i }}">
                <div class="hero-media">
                    <img src="{{ asset($slide['image']) }}" alt="{{ $slide['alt'] }}" {{ $i === 0 ? '' : 'loading="lazy"' }}>
                </div>
                <div class="container hero-content">
                    <span class="eyebrow">{{ $slide['tag'] }}</span>
                    <h1 class="hero-title">{!! $slide['headline'] !!}</h1>
                    <p class="hero-subtext">{{ $slide['subtext'] }}</p>

                    <div class="hero-actions">
                        <a href="{{ route('products.index', ['segment' => $slide['segment']]) }}" class="btn btn-gold">{{ $slide['cta_label'] }}</a>
                    </div>

                    <div class="hero-stats">
                        @foreach($slide['metrics'] as $metric)
                            <div class="hero-stat">
                                <b>{{ $metric['value'] }}</b>
                                <span>{{ $metric['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <button type="button" class="hero-arrow hero-arrow-prev" id="heroPrev" aria-label="Slide sebelumnya">&#8249;</button>
        <button type="button" class="hero-arrow hero-arrow-next" id="heroNext" aria-label="Slide berikutnya">&#8250;</button>

        <div class="hero-dots" id="heroDots">
            @foreach($highlights as $i => $slide)
                <button type="button" class="hero-dot{{ $i === 0 ? ' is-active' : '' }}" data-index="{{ $i }}" aria-label="Ke slide {{ $i + 1 }}"></button>
            @endforeach
        </div>
    </section>

    {{-- ============================= BRAND STORY ============================= --}}
    <section id="about" class="section-alt">
        <div class="container about-grid">
            <div>
                <span class="eyebrow">Superior Windowfilm Solution</span>
                <h2 class="section-title">Enhance Comfort. Protect What Matters. Elevate Every Space.</h2>
                <p class="section-subtitle" style="margin-bottom: var(--space-3);">
                    LEXENT hadir untuk dua dunia: kendaraan dan gedung. Delapan seri film
                    &mdash; empat untuk Automotive (BP, HT, MK, IR99) dan empat untuk Building
                    (Black Vision, Reflective, High Performance, Ultra Protect) &mdash; menutup
                    kebutuhan dari privasi maksimal hingga efisiensi energi, semuanya dengan
                    penolakan sinar UV hingga 99%.
                </p>
                <ul class="about-list">
                    <li><span class="check-dot">&#10003;</span> <span><b>UV Rejection s/d 99%</b> &mdash; melindungi kulit dan interior, di kendaraan maupun gedung, dari radiasi ultraviolet.</span></li>
                    <li><span class="check-dot">&#10003;</span> <span><b>Heat &amp; Infrared Rejection tinggi</b> &mdash; menahan panas sebelum menembus kabin atau ruangan.</span></li>
                    <li><span class="check-dot">&#10003;</span> <span><b>Nano Ceramic &amp; Magnetron Sputter</b> &mdash; jernih, low haze, dan performa konsisten di kedua lini.</span></li>
                </ul>
            </div>

            <div class="about-visual">
                <div class="about-visual-inner">LEX<span>ENT</span></div>
            </div>
        </div>
    </section>

    {{-- ============================= SERIES SHOWCASE ============================= --}}
    <section id="products">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Product Lineup</span>
                <h2 class="section-title">Delapan Seri, Dua Lini, Satu Standar</h2>
                <p class="section-subtitle">
                    Setiap seri LEXENT dibangun di atas teknologi yang berbeda &mdash; pilih
                    sesuai kebutuhan Anda: kendaraan atau gedung, privasi, insulasi panas,
                    kejernihan, atau efisiensi energi.
                </p>
            </div>

            <div class="category-grid">
                <a href="{{ route('products.index', ['segment' => 'automotive']) }}" class="category-tile">
                    <img src="{{ asset('images/category/automotive.jpg') }}" alt="Kaca Film Otomotif" loading="lazy">
                    <div class="category-tile-overlay">
                        <h3>Kaca Film Otomotif</h3>
                        <span class="btn btn-outline-light btn-sm">Selengkapnya &rsaquo;</span>
                    </div>
                </a>

                <a href="{{ route('products.index', ['segment' => 'building']) }}" class="category-tile">
                    <img src="{{ asset('images/category/building.jpg') }}" alt="Kaca Film Bangunan" loading="lazy">
                    <div class="category-tile-overlay">
                        <h3>Kaca Film Bangunan</h3>
                        <span class="btn btn-outline-light btn-sm">Selengkapnya &rsaquo;</span>
                    </div>
                </a>

                <a href="{{ route('ppf.index') }}" class="category-tile category-tile-wide">
                    <img src="{{ asset('images/category/ppf.jpg') }}" alt="Paint Protection Film" loading="lazy">
                    <div class="category-tile-overlay">
                        <h3>Paint Protection Film</h3>
                        <span class="btn btn-gold btn-sm">Selengkapnya &rsaquo;</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- ============================= WHY LEXENT ============================= --}}
    <section id="why-lexent" class="section-alt">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Why LEXENT</span>
                <h2 class="section-title">Kaca Film Biasa vs LEXENT</h2>
                <p class="section-subtitle">
                    Perbandingan langsung berdasarkan spesifikasi katalog resmi LEXENT.
                </p>
            </div>

            <div class="tab-switcher" id="matrixSwitcher">
                <button type="button" class="tab-btn is-active" data-tab="automotive">Automotive</button>
                <button type="button" class="tab-btn" data-tab="building">Building</button>
            </div>

            @foreach($matrix as $segment => $rows)
                <div class="matrix tab-panel {{ $segment === 'automotive' ? 'is-active' : '' }}" data-tab-panel="{{ $segment }}">
                    <div class="matrix-row matrix-head">
                        <div class="matrix-cell is-label">Parameter</div>
                        <div class="matrix-cell is-conventional">Kaca Film Biasa</div>
                        <div class="matrix-cell is-lexent">LEXENT</div>
                    </div>
                    @foreach($rows as $row)
                        <div class="matrix-row">
                            <div class="matrix-cell is-label">{{ $row['label'] }}</div>
                            <div class="matrix-cell is-conventional">
                                <span class="matrix-icon is-cross">&#10005;</span>
                                <span>{{ $row['conventional']['text'] }}</span>
                            </div>
                            <div class="matrix-cell is-lexent">
                                <span class="matrix-icon is-check">&#10003;</span>
                                <span>{{ $row['lexent']['text'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============================= TINT SIMULATOR ============================= --}}
    <section id="simulator">
        <div class="container simulator-layout">
            <div class="simulator-dual">
                <div class="simulator-pane simulator-pane-exterior">
                    <span class="simulator-pane-label">Tampak Luar</span>
                    <div class="simulator-pane-overlay" id="tintOverlayExterior"></div>
                </div>
                <div class="simulator-pane simulator-pane-interior">
                    <span class="simulator-pane-label">Tampak Dalam</span>
                    <div class="simulator-pane-overlay" id="tintOverlayInterior"></div>
                </div>
            </div>

            <div class="simulator-controls">
                <span class="eyebrow">Interactive Preview</span>
                <h3>Simulasi Tingkat Kegelapan (VLT)</h3>
                <p>Bandingkan tampak luar dan tampak dalam pada beberapa nilai VLT LEXENT &mdash; berlaku untuk kaca kendaraan maupun gedung.</p>

                <div class="tint-options" id="tintOptions">
                    <button type="button" class="tint-option" data-tint="5">VLT 5%</button>
                    <button type="button" class="tint-option" data-tint="20">VLT 20%</button>
                    <button type="button" class="tint-option is-active" data-tint="35">VLT 35%</button>
                    <button type="button" class="tint-option" data-tint="50">VLT 50%</button>
                    <button type="button" class="tint-option" data-tint="70">VLT 70%</button>
                </div>

                <p class="simulator-readout">VLT terpilih: <b id="tintReadout">35%</b> &mdash; makin kecil, makin gelap &amp; privat.</p>
            </div>
        </div>
    </section>

    {{-- ============================= ALAMAT ============================= --}}
    <section id="dealers" class="section-alt">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Alamat</span>
                <h2 class="section-title">Lokasi Kantor LEXENT</h2>
                <p class="section-subtitle">
                    Kunjungi kantor resmi LEXENT untuk konsultasi produk Automotive maupun
                    Building Windowfilm.
                </p>
            </div>

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

    {{-- ============================= WARRANTY BANNER ============================= --}}
    <section class="warranty-banner">
        <div class="container">
            <div class="glass">
                <div>
                    <span class="eyebrow">Official Warranty</span>
                    <h2 class="section-title" style="font-size: 1.9rem;">Garansi Resmi Hingga 8 Tahun</h2>
                    <p style="color: var(--ink-soft);">
                        Setiap film LEXENT yang dipasang di jaringan gallery resmi dilindungi
                        garansi resmi &mdash; hingga 7 tahun untuk lini Automotive, dan hingga
                        8 tahun untuk lini Building &mdash; tercatat sejak hari pemasangan dan
                        dapat diverifikasi kapan saja secara online.
                    </p>

                    <div class="warranty-points">
                        <div><span class="check-dot">&#10003;</span> <span>Automotive hingga 7 tahun</span></div>
                        <div><span class="check-dot">&#10003;</span> <span>Building hingga 8 tahun</span></div>
                        <div><span class="check-dot">&#10003;</span> <span>Verifikasi kode online</span></div>
                        <div><span class="check-dot">&#10003;</span> <span>Klaim di seluruh gallery resmi</span></div>
                    </div>
                </div>

                <div class="warranty-actions">
                    <a href="{{ route('cek-garansi') }}" class="btn btn-gold">Cek Garansi Saya</a>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        (function () {
            var section = document.getElementById('heroSection');
            var slides = document.querySelectorAll('#heroSection .hero-slide');
            var dots = document.querySelectorAll('#heroDots .hero-dot');
            var prevBtn = document.getElementById('heroPrev');
            var nextBtn = document.getElementById('heroNext');
            var total = slides.length;
            var current = 0;
            var timer = null;
            var AUTOPLAY_MS = 6000;

            function goTo(index) {
                current = (index + total) % total;

                slides.forEach(function (slide, i) {
                    slide.classList.toggle('is-active', i === current);
                });
                dots.forEach(function (dot, i) {
                    dot.classList.remove('is-active');
                    dot.classList.remove('is-done');
                    if (i === current) {
                        dot.classList.add('is-active');
                    } else if (i < current) {
                        dot.classList.add('is-done');
                    }
                });
            }

            function next() { goTo(current + 1); }
            function prev() { goTo(current - 1); }

            function startAutoplay() {
                stopAutoplay();
                timer = setInterval(next, AUTOPLAY_MS);
            }

            function stopAutoplay() {
                if (timer) {
                    clearInterval(timer);
                    timer = null;
                }
            }

            dots.forEach(function (dot) {
                dot.addEventListener('click', function () {
                    goTo(parseInt(dot.getAttribute('data-index'), 10));
                    startAutoplay();
                });
            });

            nextBtn.addEventListener('click', function () { next(); startAutoplay(); });
            prevBtn.addEventListener('click', function () { prev(); startAutoplay(); });

            section.addEventListener('mouseenter', stopAutoplay);
            section.addEventListener('mouseleave', startAutoplay);

            goTo(0);
            startAutoplay();
        })();

        (function () {
            var buttons = document.querySelectorAll('#matrixSwitcher .tab-btn');
            var panels = document.querySelectorAll('.matrix.tab-panel');

            buttons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var tab = btn.getAttribute('data-tab');

                    buttons.forEach(function (b) { b.classList.remove('is-active'); });
                    btn.classList.add('is-active');

                    panels.forEach(function (panel) {
                        panel.classList.toggle('is-active', panel.getAttribute('data-tab-panel') === tab);
                    });
                });
            });
        })();

        (function () {
            var exterior = document.getElementById('tintOverlayExterior');
            var interior = document.getElementById('tintOverlayInterior');
            var readout = document.getElementById('tintReadout');
            var options = document.querySelectorAll('#tintOptions .tint-option');

            function applyTint(vlt) {
                // lower VLT = darker glass = heavier overlay
                var darkness = (100 - vlt) / 100;
                exterior.style.opacity = Math.min(0.92, 0.18 + darkness * 0.7);
                interior.style.opacity = Math.min(0.6, darkness * 0.35);
                readout.textContent = vlt + '%';
            }

            options.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    options.forEach(function (b) { b.classList.remove('is-active'); });
                    btn.classList.add('is-active');
                    applyTint(parseInt(btn.getAttribute('data-tint'), 10));
                });
            });

            applyTint(35);
        })();
    </script>
@endsection

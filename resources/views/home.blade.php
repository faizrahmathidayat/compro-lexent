@extends('layouts.app')

@section('title', 'Lexent')
@section('meta_description', 'Lexent - kaca film otomotif & arsitektural premium dengan Nano-Sputter Technology kelas atas.')

@section('content')

    {{-- ============================= HERO SLIDER ============================= --}}
    <section class="hero" id="heroSection">
        <div class="container hero-slider">
            <div class="hero-slides" id="heroSlides">
                @foreach($slides as $i => $slide)
                    <div class="hero-slide {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}">
                        <span class="hero-slide-badge">Precision Nano-Sputter Technology</span>
                        <h1 class="hero-slide-title">{!! $slide['title'] !!}</h1>
                        <p class="hero-slide-subtext">{{ $slide['subtext'] }}</p>

                        <div class="hero-slide-actions">
                            <a href="{{ route($slide['cta_route'], $slide['cta_param']) }}" class="btn btn-cyan">{{ $slide['cta_text'] }}</a>
                            <a href="{{ route('dealers') }}" class="btn btn-outline">Find Authorized Dealer</a>
                        </div>

                        <div class="hero-metrics">
                            @foreach($slide['metrics'] as $metric)
                                <div class="hero-metric">
                                    <b>{{ $metric['value'] }}</b>
                                    <span>{{ $metric['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="hero-visual hud-frame" id="heroVisual">
                @foreach($slides as $i => $slide)
                    <div class="hero-visual-frame {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}">
                        <div class="hero-visual-code">{{ $slide['code'] }}</div>
                        <div class="hero-visual-tag">{{ $slide['tag'] }}</div>
                    </div>
                @endforeach
            </div>

            <div class="hero-controls">
                <button type="button" class="hero-arrow hero-arrow-prev" id="heroPrev" aria-label="Slide sebelumnya">&#8249;</button>
                <div class="hero-slider-dots" id="heroDots">
                    @foreach($slides as $i => $slide)
                        <button type="button" class="hero-dot {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}" aria-label="Ke slide {{ $i + 1 }}"></button>
                    @endforeach
                </div>
                <button type="button" class="hero-arrow hero-arrow-next" id="heroNext" aria-label="Slide berikutnya">&#8250;</button>
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
                    diproduksi melalui proses Nano-Sputtering multi-layer untuk memastikan
                    konsistensi warna, ketahanan jangka panjang, dan performa penolakan
                    panas yang terukur secara laboratorium.
                </p>
                <ul class="about-list">
                    <li><span class="check-dot">&#10003;</span> <span><b>Precision Nano-Sputter Technology</b> — lapisan metal presisi tanpa gangguan sinyal.</span></li>
                    <li><span class="check-dot">&#10003;</span> <span><b>Superior Heat Rejection</b> — menahan panas sebelum menembus kaca.</span></li>
                    <li><span class="check-dot">&#10003;</span> <span><b>Anti-Shatter Safety</b> — mengikat pecahan kaca saat terjadi benturan.</span></li>
                </ul>
            </div>

            <div class="about-visual">
                <div class="about-visual-inner">LX</div>
            </div>
        </div>
    </section>

    {{-- ============================= PRODUCT SHOWCASE (TAB SWITCHER) ============================= --}}
    <section id="products" class="section-alt">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Product Lineup</span>
                <h2 class="section-title">Automotive &amp; Architectural Film</h2>
                <p class="section-subtitle" style="margin: 0 auto;">
                    Dua lini Lexent dirancang untuk kebutuhan berbeda — dari kendaraan
                    pribadi hingga gedung komersial berskala besar.
                </p>
            </div>

            <div class="tab-switcher" id="productTabs">
                <button type="button" class="tab-btn is-active" data-tab="automotive">Automotive Film</button>
                <button type="button" class="tab-btn" data-tab="architectural">Architectural Film</button>
            </div>

            @foreach(['automotive', 'architectural'] as $category)
                <div class="tab-panel {{ $category === 'automotive' ? 'is-active' : '' }}" data-panel="{{ $category }}">
                    <div class="product-grid">
                        @foreach($products as $product)
                            @continue($product['category'] !== $category)
                            <div class="product-card glass">
                                <span class="product-badge">{{ $product['badge'] }}</span>
                                <div class="product-visual {{ $product['accent'] }}">{{ $product['vlt'] }}</div>
                                <h3>{{ $product['name'] }}</h3>
                                <div class="product-tagline">{{ $product['tagline'] }}</div>
                                <p class="product-desc">{{ $product['short_description'] }}</p>

                                <div class="spec-meters">
                                    <div>
                                        <div class="spec-meter-head"><span>VLT</span> <b>{{ $product['vlt'] }}</b></div>
                                        <div class="spec-meter-track"><div class="spec-meter-fill" style="width: {{ $product['vlt'] }};"></div></div>
                                    </div>
                                    <div>
                                        <div class="spec-meter-head"><span>TSER</span> <b>{{ $product['heat_rejection'] }}</b></div>
                                        <div class="spec-meter-track"><div class="spec-meter-fill" style="width: {{ $product['heat_rejection'] }};"></div></div>
                                    </div>
                                    <div>
                                        <div class="spec-meter-head"><span>IRR</span> <b>{{ $product['irr'] }}</b></div>
                                        <div class="spec-meter-track"><div class="spec-meter-fill" style="width: {{ $product['irr'] }};"></div></div>
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

    {{-- ============================= COMPARISON MATRIX ("WHY LEXENT") ============================= --}}
    <section id="why-lexent">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Why Lexent</span>
                <h2 class="section-title">Kaca Film Konvensional vs Lexent Nano-Sputter</h2>
                <p class="section-subtitle" style="margin: 0 auto;">
                    Perbandingan langsung yang menunjukkan mengapa Lexent unggul di setiap aspek performa.
                </p>
            </div>

            <div class="matrix">
                <div class="matrix-row matrix-head">
                    <div class="matrix-cell is-label">Parameter</div>
                    <div class="matrix-cell is-conventional">Kaca Film Konvensional</div>
                    <div class="matrix-cell is-lexent">Lexent Nano-Sputter</div>
                </div>
                @foreach($matrix as $row)
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
        </div>
    </section>

    {{-- ============================= DUAL-VIEW TINT SIMULATOR ============================= --}}
    <section id="simulator" class="section-alt">
        <div class="container simulator-layout">
            <div class="simulator-dual">
                <div class="simulator-pane simulator-pane-exterior">
                    <span class="simulator-pane-label">Exterior View</span>
                    <div class="simulator-pane-overlay" id="tintOverlayExterior"></div>
                </div>
                <div class="simulator-pane simulator-pane-interior">
                    <span class="simulator-pane-label">Interior View</span>
                    <div class="simulator-pane-overlay" id="tintOverlayInterior"></div>
                </div>
            </div>

            <div class="simulator-controls">
                <span class="eyebrow">Interactive Preview</span>
                <h3 class="section-title" style="font-size: 1.8rem;">Simulasi Kegelapan Kaca Film Lexent</h3>
                <p>Bandingkan tampak luar dan tampak dalam pada setiap tingkat kegelapan Lexent.</p>

                <div class="tint-options" id="tintOptions">
                    <button type="button" class="tint-option" data-tint="15">15%</button>
                    <button type="button" class="tint-option" data-tint="30">30%</button>
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

            <div class="dealer-list" id="dealerGrid">
                @foreach($dealers as $dealer)
                    <div class="dealer-card-h glass" data-city="{{ $dealer['city'] }}">
                        <div class="dealer-main">
                            <span class="dealer-outlet-badge">Official Outlet</span>
                            <div class="dealer-info">
                                <span class="dealer-city">{{ $dealer['city'] }}</span>
                                <h4>{{ $dealer['name'] }}</h4>
                                <p>{{ $dealer['address'] }}</p>
                                <p>{{ $dealer['phone'] }}</p>
                            </div>
                        </div>
                        <a href="{{ $dealer['maps_url'] }}" target="_blank" rel="noopener" class="btn btn-outline btn-sm">Buka Peta</a>
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
                    <a href="{{ route('cek-garansi') }}" class="btn btn-cyan">Cek Garansi Saya</a>
                    <a href="{{ route('dealers') }}" class="btn btn-outline">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        (function () {
            var section = document.getElementById('heroSection');
            var slides = document.querySelectorAll('#heroSlides .hero-slide');
            var frames = document.querySelectorAll('#heroVisual .hero-visual-frame');
            var dots = document.querySelectorAll('#heroDots .hero-dot');
            var prevBtn = document.getElementById('heroPrev');
            var nextBtn = document.getElementById('heroNext');
            var total = slides.length;
            var current = 0;
            var timer = null;
            var AUTOPLAY_MS = 5000;

            function goTo(index) {
                current = (index + total) % total;

                slides.forEach(function (slide, i) {
                    slide.classList.toggle('is-active', i === current);
                });
                frames.forEach(function (frame, i) {
                    frame.classList.toggle('is-active', i === current);
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

            function next() {
                goTo(current + 1);
            }

            function prev() {
                goTo(current - 1);
            }

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

            nextBtn.addEventListener('click', function () {
                next();
                startAutoplay();
            });

            prevBtn.addEventListener('click', function () {
                prev();
                startAutoplay();
            });

            section.addEventListener('mouseenter', stopAutoplay);
            section.addEventListener('mouseleave', startAutoplay);

            goTo(0);
            startAutoplay();
        })();

        (function () {
            var tabs = document.querySelectorAll('#productTabs .tab-btn');
            var panels = document.querySelectorAll('.tab-panel');

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    var target = tab.getAttribute('data-tab');

                    tabs.forEach(function (t) { t.classList.remove('is-active'); });
                    tab.classList.add('is-active');

                    panels.forEach(function (panel) {
                        panel.classList.toggle('is-active', panel.getAttribute('data-panel') === target);
                    });
                });
            });
        })();

        (function () {
            var exterior = document.getElementById('tintOverlayExterior');
            var interior = document.getElementById('tintOverlayInterior');
            var readout = document.getElementById('tintReadout');
            var options = document.querySelectorAll('#tintOptions .tint-option');

            function applyTint(percent) {
                exterior.style.opacity = Math.min(0.9, 0.25 + percent / 130);
                interior.style.opacity = percent / 400;
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
            var dealerCards = document.querySelectorAll('#dealerGrid .dealer-card-h');

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

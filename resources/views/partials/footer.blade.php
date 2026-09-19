<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-logo">
                    LEX<span>ENT</span>
                </div>
                <p class="footer-about">
                    Superior Windowfilm Solution. LEXENT menghadirkan kaca film untuk
                    Automotive &amp; Building dengan penolakan panas &amp; sinar UV hingga
                    99%, kejernihan tinggi, dan garansi resmi hingga 8 tahun.
                </p>
                <div class="footer-social">
                    <a href="#" aria-label="Instagram">IG</a>
                    <a href="#" aria-label="Facebook">FB</a>
                    <a href="#" aria-label="TikTok">TT</a>
                    <a href="#" aria-label="WhatsApp">WA</a>
                </div>
            </div>

            <div class="footer-col">
                <h5>Sitemap</h5>
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('products.index') }}">Produk</a>
                <a href="{{ route('ppf.index') }}">Paint Protection Film</a>
                <a href="{{ route('articles.index') }}">Artikel</a>
                <a href="{{ route('sorotan.index') }}">Sorotan Produk</a>
                <a href="{{ route('dealers') }}">Alamat</a>
                <a href="{{ route('cek-garansi') }}">Cek Garansi</a>
            </div>

            <div class="footer-col">
                <h5>Kategori Produk</h5>
                <a href="{{ route('products.index', ['segment' => 'automotive']) }}">Window Film Automotive</a>
                <a href="{{ route('products.index', ['segment' => 'building']) }}">Window Film Building</a>
                <a href="{{ route('ppf.index') }}">Paint Protection Film</a>
            </div>

            <div class="footer-col">
                <h5>Kontak</h5>
                <p>Ruko La Valle, Citra Garden Serpong No.66 Blk B17, Cisauk, Kota Tangerang Selatan, Banten 15341</p>
                <p>0858-8889-9558</p>
                <p>hello@lexent.id</p>
            </div>
        </div>

        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} LEXENT. All rights reserved.</span>
            <span>Clear Vision &middot; Cool Comfort &middot; Lasting Protection</span>
        </div>
    </div>
</footer>

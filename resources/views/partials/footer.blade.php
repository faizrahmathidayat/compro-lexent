<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-logo">LEX<span>ENT</span></div>
                <p class="footer-about">
                    Lexent menghadirkan kaca film premium untuk otomotif dan arsitektural
                    dengan teknologi penolak panas terkini, dirancang untuk kenyamanan,
                    keamanan, dan efisiensi energi kelas atas.
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
                <a href="{{ route('dealers') }}">Dealer</a>
                <a href="{{ route('cek-garansi') }}">Cek Garansi</a>
            </div>

            <div class="footer-col">
                <h5>Produk</h5>
                <a href="{{ route('products.show', 'black-phantom') }}">Lexent Black Phantom</a>
                <a href="{{ route('products.show', 'lx-series') }}">Lexent LX Series</a>
                <a href="{{ route('products.show', 'archishield-pro') }}">Lexent ArchiShield Pro</a>
            </div>

            <div class="footer-col">
                <h5>Kontak</h5>
                <p>Jl. Jenderal Sudirman Kav. 52, Jakarta Selatan</p>
                <p>(021) 555-0177</p>
                <p>hello@lexent.id</p>
            </div>
        </div>

        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} Lexent. All rights reserved.</span>
            <span>Engineered for clarity, protection, and prestige.</span>
        </div>
    </div>
</footer>

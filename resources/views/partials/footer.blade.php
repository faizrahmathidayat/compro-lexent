<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-logo">
                    <img src="{{ asset('images/lexent-logo-light.png') }}" alt="LEXENT">
                </div>
                <p class="footer-about">Better Comfort Everyday</p>
            </div>

            <div class="footer-col">
                <h5>Solusi Kami</h5>
                <a href="{{ route('products.building') }}">Kaca Film Bangunan</a>
                <a href="{{ route('products.automotive') }}">Kaca Film Mobil</a>
                <a href="{{ route('ppf.index') }}">Paint Protection Film (PPF)</a>
            </div>

            <div class="footer-col">
                <h5>Tautan Cepat</h5>
                <a href="{{ route('about') }}">Tentang Kami</a>
                <a href="{{ route('cek-garansi') }}">Garansi</a>
                <a href="{{ route('portfolio') }}">Portfolio</a>
                <a href="{{ route('articles.index') }}">Artikel</a>
                <a href="{{ route('dealers') }}">Hubungi Kami</a>
            </div>

            <div class="footer-col">
                <h5>Follow Kami</h5>
                <div class="footer-social">
                    <a href="#" aria-label="Instagram">@include('partials.icon', ['name' => 'instagram'])</a>
                    <a href="#" aria-label="YouTube">@include('partials.icon', ['name' => 'youtube'])</a>
                    <a href="#" aria-label="TikTok">@include('partials.icon', ['name' => 'tiktok'])</a>
                </div>
            </div>

            <div class="footer-col">
                <a href="https://wa.me/6285888899558" target="_blank" rel="noopener" class="footer-wa">@include('partials.icon', ['name' => 'whatsapp']) Chat via WA</a>
            </div>
        </div>

        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} LEXENT. All rights reserved.</span>
            <nav aria-label="Legal">
                <a href="#">Kebijakan Privasi</a>
                <span aria-hidden="true">|</span>
                <a href="#">Syarat &amp; Ketentuan</a>
            </nav>
        </div>
    </div>
</footer>

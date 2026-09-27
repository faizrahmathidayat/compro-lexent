<header class="navbar navbar-transparent" id="mainNavbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-logo" aria-label="LEXENT — beranda">
            <img src="{{ asset('images/lexent-logo.png') }}" alt="LEXENT">
        </a>

        <nav class="navbar-links" id="navbarLinks">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'is-active' : '' }}">About</a>
            <a href="{{ route('products.building') }}" class="{{ request()->routeIs('products.building') ? 'is-active' : '' }}">Kaca Film Bangunan</a>
            <a href="{{ route('products.automotive') }}" class="{{ request()->routeIs('products.automotive') ? 'is-active' : '' }}">Kaca Film Mobil</a>
            <a href="{{ route('ppf.index') }}" class="{{ request()->routeIs('ppf.*') ? 'is-active' : '' }}">PPF</a>
            <a href="{{ route('articles.index') }}" class="{{ request()->routeIs('articles.*') ? 'is-active' : '' }}">Artikel</a>
            <a href="{{ route('sorotan.index') }}" class="{{ request()->routeIs('sorotan.*') ? 'is-active' : '' }}">Produk</a>
            <a href="{{ route('portfolio') }}" class="{{ request()->routeIs('portfolio') ? 'is-active' : '' }}">Portfolio</a>
            <a href="{{ route('cek-garansi') }}" class="{{ request()->routeIs('cek-garansi') ? 'is-active' : '' }}">Warranty</a>
        </nav>

        <div class="navbar-cta">
            <button type="button" class="navbar-toggle" id="navbarToggle" aria-label="Buka menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>

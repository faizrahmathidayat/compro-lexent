<header class="navbar" id="mainNavbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-logo" aria-label="LEXENT — beranda">
            LEX<span>ENT</span>
        </a>

        <nav class="navbar-links" id="navbarLinks">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'is-active' : '' }}">About</a>

            <div class="navbar-dropdown">
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'is-active' : '' }}">Produk</a>
                <div class="navbar-dropdown-menu">
                    <a href="{{ route('products.index', ['segment' => 'automotive']) }}">Automotive</a>
                    <a href="{{ route('products.index', ['segment' => 'building']) }}">Building</a>
                </div>
            </div>

            <div class="navbar-dropdown">
                <a href="{{ route('ppf.index') }}" class="{{ request()->routeIs('ppf.*') ? 'is-active' : '' }}">Paint Protection Film</a>
                <div class="navbar-dropdown-menu">
                    <a href="{{ route('ppf.show', 'type-s') }}">Paint Protection Film Type S</a>
                    <a href="{{ route('ppf.show', 'type-t-plus') }}">Paint Protection Film Type T Plus</a>
                    <a href="{{ route('ppf.show', 'type-l') }}">Paint Protection Film Type L</a>
                    <a href="{{ route('ppf.show', 'type-l-matte') }}">Paint Protection Film Type L Matte</a>
                </div>
            </div>

            <a href="{{ route('cek-garansi') }}" class="{{ request()->routeIs('cek-garansi') ? 'is-active' : '' }}">Cek Garansi</a>
        </nav>

        <div class="navbar-cta">
            <button type="button" class="navbar-toggle" id="navbarToggle" aria-label="Buka menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>

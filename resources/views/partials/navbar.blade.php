<header class="navbar navbar-transparent" id="mainNavbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-logo" aria-label="LEXENT — beranda">
            <img src="{{ asset('images/lexent-logo.png') }}" alt="LEXENT">
        </a>

        <nav class="navbar-links" id="navbarLinks">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
            <div class="navbar-dropdown">
                <a href="{{ route('products.building') }}" class="{{ request()->routeIs('products.building') ? 'is-active' : '' }}">Kaca Film Bangunan<span class="navbar-caret" aria-hidden="true"></span></a>
                <div class="navbar-dropdown-menu">
                    <a href="{{ route('products.building') }}" class="navbar-dropdown-all">Semua Seri</a>
                    @foreach($navMenu['building'] as $item)
                        <a href="{{ route('products.building', ['series' => $item['code']]) }}">{{ $item['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="navbar-dropdown">
                <a href="{{ route('products.automotive') }}" class="{{ request()->routeIs('products.automotive') ? 'is-active' : '' }}">Kaca Film Mobil<span class="navbar-caret" aria-hidden="true"></span></a>
                <div class="navbar-dropdown-menu">
                    <a href="{{ route('products.automotive') }}" class="navbar-dropdown-all">Semua Seri</a>
                    @foreach($navMenu['automotive'] as $item)
                        <a href="{{ route('products.automotive', ['series' => $item['code']]) }}">{{ $item['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="navbar-dropdown">
                <a href="{{ route('ppf.index') }}" class="{{ request()->routeIs('ppf.*') ? 'is-active' : '' }}">PPF<span class="navbar-caret" aria-hidden="true"></span></a>
                <div class="navbar-dropdown-menu">
                    <a href="{{ route('ppf.index') }}" class="navbar-dropdown-all">Semua Tipe PPF</a>
                    @foreach($navMenu['ppf'] as $item)
                        <a href="{{ route('ppf.show', $item['slug']) }}">{{ $item['name'] }}</a>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('portfolio') }}" class="{{ request()->routeIs('portfolio') ? 'is-active' : '' }}">Portfolio</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'is-active' : '' }}">About</a>
            <a href="{{ route('articles.index') }}" class="{{ request()->routeIs('articles.*') ? 'is-active' : '' }}">Artikel</a>
            <a href="{{ route('cek-garansi') }}" class="{{ request()->routeIs('cek-garansi') ? 'is-active' : '' }}">Warranty</a>
        </nav>

        <div class="navbar-cta">
            <button type="button" class="navbar-toggle" id="navbarToggle" aria-label="Buka menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LEXENT') — Superior Windowfilm Solution</title>
    <meta name="description" content="@yield('meta_description', 'LEXENT - kaca film otomotif premium. Perlindungan panas & sinar UV hingga 99%, kejernihan tinggi, garansi resmi hingga 7 tahun.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.lightbox')

    <script>
        (function () {
            var navbar = document.getElementById('mainNavbar');
            var toggle = document.getElementById('navbarToggle');
            var links = document.getElementById('navbarLinks');

            function onScroll() {
                if (window.scrollY > 40) {
                    navbar.classList.add('is-scrolled');
                } else {
                    navbar.classList.remove('is-scrolled');
                }
            }

            window.addEventListener('scroll', onScroll);
            onScroll();

            if (toggle && links) {
                toggle.addEventListener('click', function () {
                    links.classList.toggle('is-open');
                });
            }

            // Lightbox — opened by any .cms-lightbox-trigger on the page (Artikel/Sorotan/Portofolio
            // detail views: the single-image display and every carousel slide's image are triggers,
            // regardless of which slide is currently visible, so prev/next inside the lightbox can
            // page through the full gallery).
            var lightbox = document.getElementById('cmsLightbox');
            var lightboxImage = document.getElementById('cmsLightboxImage');
            var lightboxItems = [];
            var lightboxIndex = 0;

            function openLightboxAt(index) {
                if (!lightboxItems[index]) { return; }
                lightboxIndex = index;
                lightboxImage.setAttribute('src', lightboxItems[index].getAttribute('data-full'));
                lightboxImage.setAttribute('alt', lightboxItems[index].getAttribute('data-alt') || '');
                lightbox.classList.add('is-open');
                lightbox.setAttribute('aria-hidden', 'false');
            }

            function closeLightbox() {
                lightbox.classList.remove('is-open');
                lightbox.setAttribute('aria-hidden', 'true');
            }

            if (lightbox && lightboxImage) {
                lightboxItems = Array.prototype.slice.call(document.querySelectorAll('.cms-lightbox-trigger'));

                lightboxItems.forEach(function (item, index) {
                    item.addEventListener('click', function () { openLightboxAt(index); });
                });

                var lightboxClose = document.getElementById('cmsLightboxClose');
                var lightboxBackdrop = document.getElementById('cmsLightboxBackdrop');
                var lightboxPrev = document.getElementById('cmsLightboxPrev');
                var lightboxNext = document.getElementById('cmsLightboxNext');

                if (lightboxClose) { lightboxClose.addEventListener('click', closeLightbox); }
                if (lightboxBackdrop) { lightboxBackdrop.addEventListener('click', closeLightbox); }
                if (lightboxPrev) { lightboxPrev.addEventListener('click', function () { openLightboxAt((lightboxIndex - 1 + lightboxItems.length) % lightboxItems.length); }); }
                if (lightboxNext) { lightboxNext.addEventListener('click', function () { openLightboxAt((lightboxIndex + 1) % lightboxItems.length); }); }

                document.addEventListener('keydown', function (e) {
                    if (!lightbox.classList.contains('is-open')) { return; }
                    if (e.key === 'Escape') { closeLightbox(); }
                    if (e.key === 'ArrowLeft' && lightboxPrev) { lightboxPrev.click(); }
                    if (e.key === 'ArrowRight' && lightboxNext) { lightboxNext.click(); }
                });
            }

            // CMS image carousel — used whenever an item has more than one image. No-op if none exist.
            document.querySelectorAll('.cms-carousel').forEach(function (carousel) {
                var slides = Array.prototype.slice.call(carousel.querySelectorAll('.cms-carousel-slide'));
                var dots = Array.prototype.slice.call(carousel.querySelectorAll('.cms-carousel-dot'));
                var prevBtn = carousel.querySelector('.cms-carousel-prev');
                var nextBtn = carousel.querySelector('.cms-carousel-next');
                var current = 0;

                function goTo(index) {
                    current = (index + slides.length) % slides.length;
                    slides.forEach(function (slide, i) { slide.classList.toggle('is-active', i === current); });
                    dots.forEach(function (dot, i) { dot.classList.toggle('is-active', i === current); });
                }

                if (prevBtn) { prevBtn.addEventListener('click', function () { goTo(current - 1); }); }
                if (nextBtn) { nextBtn.addEventListener('click', function () { goTo(current + 1); }); }
                dots.forEach(function (dot, i) { dot.addEventListener('click', function () { goTo(i); }); });
            });

            // CMS article body cleanup — admins often type "1. Judul Langkah" as a plain
            // paragraph instead of using the WYSIWYG's numbered-list button. Detect that
            // pattern and give it a numbered-card treatment like a real <ol>, and drop
            // empty spacer paragraphs (Quill's blank "<p><br></p>" lines) so spacing stays
            // consistent. Uses safe DOM node construction (textContent), never innerHTML
            // on admin-authored text, so escaped characters can't be re-interpreted as markup.
            document.querySelectorAll('.cms-article').forEach(function (article) {
                Array.prototype.slice.call(article.querySelectorAll('p')).forEach(function (p) {
                    var text = p.textContent.replace(/ /g, ' ').trim();

                    if (text === '') {
                        p.remove();
                        return;
                    }

                    var match = text.match(/^(\d{1,2})\.\s+(.+)$/);
                    if (match && p.children.length === 0) {
                        var numberBadge = document.createElement('span');
                        numberBadge.className = 'cms-step-number';
                        numberBadge.textContent = match[1];

                        var titleText = document.createElement('span');
                        titleText.className = 'cms-step-text';
                        titleText.textContent = match[2];

                        p.textContent = '';
                        p.appendChild(numberBadge);
                        p.appendChild(titleText);
                        p.classList.add('cms-step-title');
                    }
                });
            });
        })();
    </script>

    @yield('scripts')

</body>
</html>

# CMS Consumer Integration — compro-2 (LEXENT) Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Make `compro-2` (LEXENT) consume the same CMS built in `dashboard` (Artikel, Katalog/"Sorotan Produk", Portofolio) that `compro-1` (GlossPro) already consumes — Phase 4b of the CMS milestone, applying the exact same architecture proven in `compro-1/docs/superpowers/plans/2026-09-18-cms-consumer-integration.md`, re-themed to this site's white/light-gray + amber-gold palette instead of `compro-1`'s dark-luxury theme.

**Architecture:** Identical shape to `compro-1`'s: `App\Services\CmsClient` wraps every dashboard API call via the `Http` facade (server-side, never client-side `fetch()` — note this is a **deliberate departure** from this repo's own existing `cek-garansi` feature, which does call the dashboard via client-side `fetch()`; that pattern is fine for a public, non-authenticated warranty lookup, but the CMS API key must never reach the browser, so CMS calls go through `CmsClient` instead, not through the `cek-garansi` pattern). Try/catch → `null` on any failure so pages degrade to an empty-state instead of crashing. **No caching** (matches the corrected `compro-1` design — see its plan/spec for why the original cached design was dropped). A shared hand-rolled carousel + lightbox (vanilla JS/CSS, no new dependency) lives once in the layout, reused by all three content types' detail pages — this is new territory for `compro-2`, which currently has **zero real `<img>` photos anywhere** (every "visual" on this site today is a CSS-styled div with a code/number, not a photograph), so the CMS pages will be the first real image content on the site.

**Key difference from `compro-1`'s Phase 4a:** `compro-2` has **no existing `/portfolio` route at all** (confirmed: no portfolio method/view/route anywhere in this codebase). Per the spec, Portofolio here is a **brand-new** page (list + detail + nav link), not a rewire of anything — there is no old hardcoded data or old view to replace or reason about.

**Tech Stack:** Laravel 8.75 / PHP `^7.3|^8.0` (PHP-7.4-syntax target — see Global Constraints), `guzzlehttp/guzzle` ^7.0 (already installed, backs the `Http` facade), no new Composer packages, no new frontend dependencies (plain CSS + vanilla JS — confirmed this repo has no build step wired up despite a dormant `laravel-mix`/`resources/js` scaffold; the real site is `public/css/style.css` + inline `@section('scripts')` blocks only, same as `compro-1`).

**Consumer-side design source:** `dashboard`'s `docs/superpowers/specs/2026-09-18-cms-design.md` + `compro-1`'s already-shipped and already-verified implementation. Where this plan's code differs from `compro-1`'s, it's only CSS variable names/values and the portfolio-is-new-not-rewired distinction — the PHP logic (`CmsClient`, controllers, routes, tests) is intentionally near-identical.

**Dashboard API being consumed (already live — see `dashboard`'s Phase 1/2/3 plans):**
```
GET {base_url}/api/cms/articles?site=lexent&page=N   → {data: [{slug,title,excerpt,category,published_at,cover}], meta: {current_page,last_page,per_page,total}}
GET {base_url}/api/cms/articles/{slug}?site=lexent    → {data: {...above, body, media: [{url,thumbnail_url,width,height,alt_text}]}}
GET {base_url}/api/cms/catalog?site=lexent&page=N     → same list shape
GET {base_url}/api/cms/catalog/{slug}?site=lexent     → same detail shape + spec_highlights: [{label,value}]
GET {base_url}/api/cms/portfolio?site=lexent&page=N   → same list shape
GET {base_url}/api/cms/portfolio/{slug}?site=lexent   → same detail shape + location: string|null
```
All require header `X-API-Key: <the dashboard's CMS_API_KEY>` (same key already configured in `dashboard/.env` and `compro-1/.env` — reuse the exact same value here). `site` for this repo is **`lexent`**, not `glosspro`.

## Global Constraints

- **PHP 7.4 syntax only** — no constructor property promotion, no `match()`, no nullsafe `?->`, no native `enum`. Typed properties, arrow functions, and `??=` are fine.
- No `env()` calls outside `config/services.php` — `CMS_BASE_URL`/`CMS_API_KEY` read only via `config('services.cms.*')`, mirroring this repo's own existing `DASHBOARD_BASE_URL` → `config('services.dashboard.base_url')` precedent.
- **No caching, ever** — every `CmsClient` call hits the dashboard API directly. This was an explicit, deliberate decision on `compro-1` (removed after initially shipping with a 5-minute cache) so published/edited content appears immediately; do not reintroduce caching here without asking.
- **Never let a CMS outage break the page** — every `CmsClient` call is wrapped so a timeout/500/exception returns `null`, and every controller/view treats `null`/empty gracefully (empty-state copy, not an exception page).
- Follow existing conventions exactly: `@extends('layouts.app')`, `page-header`/`section-title`/`eyebrow`/`back-link`/`container` classes for headers (confirmed identical names and near-identical CSS to `compro-1`, just different color tokens), routes as flat `Route::get(...)->name(...)` lines at the end of `routes/web.php` (no grouping — matches the existing 8 routes), CSS added to the single `public/css/style.css` using this repo's own `:root` tokens (`--ink`/`--surface`/`--border`/`--teal`/`--radius-*`/`--shadow-*` — **not** `compro-1`'s dark-theme token names like `--text`/`--bg-alt`/`--silver`, which don't exist here), JS as inline `@section('scripts')`/layout `<script>` blocks (no `public/js/` directory — don't create one).
- Tests use the existing PHPUnit scaffold (`tests/Feature`, `tests/TestCase`) with `Http::fake()` — no real network calls in tests, no database needed for anything in this plan.
- Do not modify `seriesCatalog()`, `productLineup()`, `ppfLineup()`, `segmentHighlights()`, `matrixComparison()`, `companyAddress()`, or any of the Products/PPF/About/Dealers pages — this plan only adds new code, it doesn't touch existing pages or data.
- The Artikel/Sorotan/Portofolio detail pages get a **numbered-step auto-detection** pass from the start (not added as an afterthought like it was on `compro-1`): admins commonly type "1. Judul Langkah" as a plain WYSIWYG paragraph instead of using the editor's list button, and this repo will render the exact same dashboard-authored body HTML `compro-1` does, so the same client-side detection (safe `textContent`/DOM-node construction, never `innerHTML` on user-authored text, to avoid re-interpreting escaped content as markup) is included in Task 2 rather than bolted on later.

---

### Task 1: `CmsClient` service — config, env, HTTP calls, no caching

**Files:**
- Modify: `config/services.php`
- Modify: `.env`, `.env.example`
- Create: `app/Services/CmsClient.php`
- Test: `tests/Unit/CmsClientTest.php`

**Interfaces:**
- Produces: `CmsClient::articles(int $page = 1): ?array`, `CmsClient::article(string $slug): ?array`, `CmsClient::catalog(int $page = 1): ?array`, `CmsClient::catalogItem(string $slug): ?array`, `CmsClient::portfolio(int $page = 1): ?array`, `CmsClient::portfolioItem(string $slug): ?array`. Every method returns the CMS API's raw decoded JSON body on success, `null` on any failure.

- [ ] **Step 1: Add the `cms` config block**

Edit `config/services.php`, add after the existing `'dashboard'` block:
```php
    'dashboard' => [
        'base_url' => rtrim(env('DASHBOARD_BASE_URL', 'http://localhost:8000'), '/'),
    ],

    'cms' => [
        'base_url' => rtrim(env('CMS_BASE_URL', 'http://localhost:8000'), '/'),
        'api_key' => env('CMS_API_KEY'),
        'site' => 'lexent',
    ],
```

- [ ] **Step 2: Add the env vars**

Append to `.env` (use the **same** `CMS_API_KEY` value already configured in `dashboard/.env` and `compro-1/.env` — this is one shared secret across all three apps, not a per-site key):
```
CMS_BASE_URL=http://localhost:8000
CMS_API_KEY=<same value as dashboard/.env's CMS_API_KEY>
```

Append to `.env.example` (placeholder, no real secret):
```
CMS_BASE_URL=http://localhost:8000
CMS_API_KEY=
```

- [ ] **Step 3: Write the failing test**

```php
<?php

namespace Tests\Unit;

use App\Services\CmsClient;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CmsClientTest extends TestCase
{
    public function test_articles_returns_the_decoded_response_on_success(): void
    {
        Http::fake([
            '*/api/cms/articles*' => Http::response([
                'data' => [['slug' => 'a', 'title' => 'Judul A']],
                'meta' => ['current_page' => 1, 'last_page' => 1, 'per_page' => 9, 'total' => 1],
            ], 200),
        ]);

        $result = (new CmsClient())->articles(1);

        $this->assertSame('a', $result['data'][0]['slug']);
        $this->assertSame(1, $result['meta']['total']);
    }

    public function test_sends_the_api_key_header_and_site_parameter(): void
    {
        Http::fake(['*/api/cms/articles*' => Http::response(['data' => [], 'meta' => []], 200)]);

        (new CmsClient())->articles(1);

        Http::assertSent(function ($request) {
            return $request->hasHeader('X-API-Key', config('services.cms.api_key'))
                && strpos($request->url(), 'site=lexent') !== false;
        });
    }

    public function test_returns_null_on_a_non_success_response(): void
    {
        Http::fake(['*/api/cms/articles*' => Http::response(['message' => 'error'], 500)]);

        $result = (new CmsClient())->articles(1);

        $this->assertNull($result);
    }

    public function test_returns_null_instead_of_throwing_on_a_connection_failure(): void
    {
        Http::fake(function () {
            throw new ConnectionException('Connection timed out');
        });

        $result = (new CmsClient())->articles(1);

        $this->assertNull($result);
    }

    public function test_article_show_hits_the_detail_endpoint(): void
    {
        Http::fake(['*/api/cms/articles/kaca-film*' => Http::response(['data' => ['slug' => 'kaca-film']], 200)]);

        $result = (new CmsClient())->article('kaca-film');

        $this->assertSame('kaca-film', $result['data']['slug']);
    }

    public function test_catalog_and_portfolio_hit_their_own_endpoints(): void
    {
        Http::fake([
            '*/api/cms/catalog*' => Http::response(['data' => ['slug' => 'katalog-x']], 200),
            '*/api/cms/portfolio*' => Http::response(['data' => ['slug' => 'proyek-x']], 200),
        ]);

        $client = new CmsClient();

        $this->assertSame('katalog-x', $client->catalogItem('katalog-x')['data']['slug']);
        $this->assertSame('proyek-x', $client->portfolioItem('proyek-x')['data']['slug']);
    }

    public function test_each_call_hits_the_api_fresh_with_no_caching(): void
    {
        Http::fakeSequence()
            ->push(['data' => [['slug' => 'lama']], 'meta' => []], 200)
            ->push(['data' => [['slug' => 'baru']], 'meta' => []], 200);

        $client = new CmsClient();
        $first = $client->articles(1);
        $second = $client->articles(1);

        $this->assertSame('lama', $first['data'][0]['slug']);
        $this->assertSame('baru', $second['data'][0]['slug']);
        Http::assertSentCount(2);
    }
}
```

- [ ] **Step 4: Run the test to verify it fails**

Run: `php artisan test --filter=CmsClientTest`
Expected: FAIL — `Class "App\Services\CmsClient" not found`.

- [ ] **Step 5: Write `app/Services/CmsClient.php`**

```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CmsClient
{
    public function articles(int $page = 1): ?array
    {
        return $this->request('/api/cms/articles', ['page' => $page]);
    }

    public function article(string $slug): ?array
    {
        return $this->request('/api/cms/articles/' . $slug, []);
    }

    public function catalog(int $page = 1): ?array
    {
        return $this->request('/api/cms/catalog', ['page' => $page]);
    }

    public function catalogItem(string $slug): ?array
    {
        return $this->request('/api/cms/catalog/' . $slug, []);
    }

    public function portfolio(int $page = 1): ?array
    {
        return $this->request('/api/cms/portfolio', ['page' => $page]);
    }

    public function portfolioItem(string $slug): ?array
    {
        return $this->request('/api/cms/portfolio/' . $slug, []);
    }

    private function request(string $path, array $query): ?array
    {
        $query['site'] = config('services.cms.site');

        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.cms.api_key'),
            ])->timeout(5)->get(config('services.cms.base_url') . $path, $query);

            if (!$response->successful()) {
                return null;
            }

            return $response->json();
        } catch (\Throwable $e) {
            Log::warning('CMS API request failed: ' . $e->getMessage());

            return null;
        }
    }
}
```

- [ ] **Step 6: Run the test to verify it passes**

Run: `php artisan test --filter=CmsClientTest`
Expected: PASS (7 tests).

- [ ] **Step 7: Commit**

```bash
git add config/services.php .env.example app/Services/CmsClient.php tests/Unit/CmsClientTest.php
git commit -m "Add CmsClient service for calling the dashboard CMS API"
```
(`.env` itself is gitignored — nothing to add there.)

---

### Task 2: Artikel — `/artikel` list + `/artikel/{slug}` detail + shared carousel/lightbox

**Files:**
- Create: `app/Http/Controllers/CmsController.php`
- Modify: `routes/web.php`
- Create: `resources/views/cms/articles/index.blade.php`
- Create: `resources/views/cms/articles/show.blade.php`
- Create: `resources/views/partials/cms-media.blade.php`
- Create: `resources/views/partials/lightbox.blade.php`
- Modify: `resources/views/layouts/app.blade.php` (include lightbox partial + shared JS: lightbox, carousel, numbered-step detection)
- Modify: `resources/views/partials/navbar.blade.php`, `resources/views/partials/footer.blade.php`
- Modify: `public/css/style.css`
- Test: `tests/Feature/ArtikelPageTest.php`

**Interfaces:**
- Consumes: `CmsClient::articles()`/`::article()` (Task 1).
- Produces: routes `articles.index` (`GET /artikel`), `articles.show` (`GET /artikel/{slug}`). Everything built here (lightbox, carousel, numbered-step JS, `.cms-*` CSS, the `partials.cms-media` component) is shared verbatim by Tasks 3 and 4 — nothing further needs to change in the layout after this task.

- [ ] **Step 1: Write the failing tests**

```php
<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ArtikelPageTest extends TestCase
{
    public function test_index_renders_the_list_from_the_cms(): void
    {
        Http::fake(['*/api/cms/articles*' => Http::response([
            'data' => [['slug' => 'tips-kaca-film', 'title' => 'Tips Merawat Kaca Film', 'excerpt' => 'Ringkasan', 'category' => 'Tips', 'published_at' => '2026-09-19T00:00:00+00:00', 'cover' => null]],
            'meta' => ['current_page' => 1, 'last_page' => 1, 'per_page' => 9, 'total' => 1],
        ], 200)]);

        $response = $this->get('/artikel');

        $response->assertOk();
        $response->assertSee('Tips Merawat Kaca Film');
    }

    public function test_index_shows_an_empty_state_when_the_cms_is_unreachable(): void
    {
        Http::fake(['*/api/cms/articles*' => Http::response([], 500)]);

        $response = $this->get('/artikel');

        $response->assertOk();
        $response->assertSee('belum tersedia', false);
    }

    public function test_show_renders_the_body_and_media(): void
    {
        Http::fake(['*/api/cms/articles/tips-kaca-film*' => Http::response(['data' => [
            'slug' => 'tips-kaca-film', 'title' => 'Tips Merawat Kaca Film', 'body' => '<p>Isi lengkap artikel</p>',
            'published_at' => '2026-09-19T00:00:00+00:00', 'category' => 'Tips',
            'media' => [['url' => 'https://example.test/a.webp', 'thumbnail_url' => 'https://example.test/a-thumb.webp', 'width' => 800, 'height' => 600, 'alt_text' => null]],
        ]], 200)]);

        $response = $this->get('/artikel/tips-kaca-film');

        $response->assertOk();
        $response->assertSee('Isi lengkap artikel', false);
        $response->assertSee('cms-lightbox-trigger', false);
    }

    public function test_show_returns_404_when_the_cms_has_no_matching_article(): void
    {
        Http::fake(['*/api/cms/articles/tidak-ada*' => Http::response(['message' => 'Artikel tidak ditemukan.'], 404)]);

        $this->get('/artikel/tidak-ada')->assertStatus(404);
    }
}
```

- [ ] **Step 2: Run the tests to verify they fail**

Run: `php artisan test --filter=ArtikelPageTest`
Expected: FAIL — routes don't exist yet.

- [ ] **Step 3: Write `app/Http/Controllers/CmsController.php`**

```php
<?php

namespace App\Http\Controllers;

use App\Services\CmsClient;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    private CmsClient $cms;

    public function __construct(CmsClient $cms)
    {
        $this->cms = $cms;
    }

    public function articles(Request $request)
    {
        $page = max(1, (int) $request->query('page', 1));
        $response = $this->cms->articles($page);

        return view('cms.articles.index', [
            'items' => $response['data'] ?? [],
            'meta' => $response['meta'] ?? null,
        ]);
    }

    public function articleShow(string $slug)
    {
        $response = $this->cms->article($slug);

        abort_if(!isset($response['data']), 404);

        return view('cms.articles.show', ['item' => $response['data']]);
    }

    public function catalog(Request $request)
    {
        $page = max(1, (int) $request->query('page', 1));
        $response = $this->cms->catalog($page);

        return view('cms.catalog.index', [
            'items' => $response['data'] ?? [],
            'meta' => $response['meta'] ?? null,
        ]);
    }

    public function catalogShow(string $slug)
    {
        $response = $this->cms->catalogItem($slug);

        abort_if(!isset($response['data']), 404);

        return view('cms.catalog.show', ['item' => $response['data']]);
    }
}
```
(`catalog()`/`catalogShow()` are included now since they're trivial once `articles()`/`articleShow()` exist — Task 3 only adds their routes/views.)

- [ ] **Step 4: Add the routes**

In `routes/web.php`, add the import alongside `use App\Http\Controllers\PageController;`, and two new routes at the end of the file:
```php
use App\Http\Controllers\CmsController;
```
```php
Route::get('/artikel', [CmsController::class, 'articles'])->name('articles.index');
Route::get('/artikel/{slug}', [CmsController::class, 'articleShow'])->name('articles.show');
```

- [ ] **Step 5: Write the shared media partial `resources/views/partials/cms-media.blade.php`**

```blade
{{-- Shared by Artikel/Sorotan/Portofolio detail views. Expects $media: array of {url, alt_text}. --}}
@if(!empty($media))
    @if(count($media) === 1)
        <div class="cms-media-single">
            <img src="{{ $media[0]['url'] }}" alt="{{ $media[0]['alt_text'] ?? '' }}" class="cms-lightbox-trigger" data-full="{{ $media[0]['url'] }}" data-alt="{{ $media[0]['alt_text'] ?? '' }}" loading="lazy">
        </div>
    @else
        <div class="cms-carousel">
            <div class="cms-carousel-track">
                @foreach($media as $i => $photo)
                    <div class="cms-carousel-slide {{ $i === 0 ? 'is-active' : '' }}">
                        <img src="{{ $photo['url'] }}" alt="{{ $photo['alt_text'] ?? '' }}" class="cms-lightbox-trigger" data-full="{{ $photo['url'] }}" data-alt="{{ $photo['alt_text'] ?? '' }}" loading="lazy">
                    </div>
                @endforeach
            </div>
            <button type="button" class="cms-carousel-arrow cms-carousel-prev" aria-label="Sebelumnya">&larr;</button>
            <button type="button" class="cms-carousel-arrow cms-carousel-next" aria-label="Berikutnya">&rarr;</button>
            <div class="cms-carousel-dots">
                @foreach($media as $i => $photo)
                    <button type="button" class="cms-carousel-dot {{ $i === 0 ? 'is-active' : '' }}" aria-label="Gambar {{ $i + 1 }}"></button>
                @endforeach
            </div>
        </div>
    @endif
@endif
```

- [ ] **Step 6: Write the lightbox partial `resources/views/partials/lightbox.blade.php`**

```blade
<div class="cms-lightbox" id="cmsLightbox" aria-hidden="true">
    <div class="cms-lightbox-backdrop" id="cmsLightboxBackdrop"></div>
    <button type="button" class="cms-lightbox-close" id="cmsLightboxClose" aria-label="Tutup">&times;</button>
    <button type="button" class="cms-lightbox-nav cms-lightbox-prev" id="cmsLightboxPrev" aria-label="Sebelumnya">&larr;</button>
    <div class="cms-lightbox-frame">
        <img src="" alt="" id="cmsLightboxImage">
    </div>
    <button type="button" class="cms-lightbox-nav cms-lightbox-next" id="cmsLightboxNext" aria-label="Berikutnya">&rarr;</button>
</div>
```

- [ ] **Step 7: Include the lightbox partial and add the shared JS to the layout**

In `resources/views/layouts/app.blade.php`, add the include right after `@include('partials.footer')`:
```php
    @include('partials.footer')

    @include('partials.lightbox')
```
Then, inside the existing inline `<script>` IIFE, right after the existing nav-toggle/scroll logic and before its closing `})();`, add:
```javascript
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
```
(Verify this repo's exact IIFE closing syntax before inserting — read the file first; the snippet above assumes the same `(function () { ... })();` wrapper `compro-1` uses, which the research confirms this file also uses.)

- [ ] **Step 8: Write `resources/views/cms/articles/index.blade.php`**

```blade
@extends('layouts.app')

@section('title', 'Artikel')
@section('meta_description', 'Artikel seputar perawatan kaca film automotive dan building dari LEXENT.')

@section('content')

    <section class="page-header">
        <div class="container">
            <span class="eyebrow">Insight</span>
            <h1 class="section-title">Artikel LEXENT</h1>
        </div>
    </section>

    <section style="padding-top: 0;">
        <div class="container">
            @if(empty($items))
                <p class="section-subtitle" style="text-align: center; margin: var(--space-4) auto;">Konten belum tersedia saat ini.</p>
            @else
                <div class="cms-grid">
                    @foreach($items as $item)
                        <a href="{{ route('articles.show', $item['slug']) }}" class="cms-card">
                            <div class="cms-card-media">
                                @if(!empty($item['cover']))
                                    <img src="{{ $item['cover']['thumbnail_url'] }}" alt="{{ $item['cover']['alt_text'] ?? $item['title'] }}" loading="lazy">
                                @else
                                    <div class="cms-card-media-placeholder"></div>
                                @endif
                            </div>
                            <div class="cms-card-body">
                                @if(!empty($item['category']))
                                    <span class="cms-card-tag">{{ $item['category'] }}</span>
                                @endif
                                <h4>{{ $item['title'] }}</h4>
                                <p>{{ $item['excerpt'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($meta && $meta['last_page'] > 1)
                    <nav class="cms-pagination">
                        @for($p = 1; $p <= $meta['last_page']; $p++)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $p]) }}" class="{{ $p === $meta['current_page'] ? 'is-active' : '' }}">{{ $p }}</a>
                        @endfor
                    </nav>
                @endif
            @endif
        </div>
    </section>

@endsection
```

- [ ] **Step 9: Write `resources/views/cms/articles/show.blade.php`**

```blade
@extends('layouts.app')

@section('title', $item['title'])
@section('meta_description', $item['excerpt'] ?? $item['title'])

@section('content')

    <section class="page-header">
        <div class="container">
            <div class="cms-detail-header">
                <a href="{{ route('articles.index') }}" class="back-link">&larr; Kembali ke Artikel</a>
                @if(!empty($item['category']))
                    <span class="eyebrow">{{ $item['category'] }}</span>
                @endif
                <h1 class="section-title">{{ $item['title'] }}</h1>
            </div>
        </div>
    </section>

    <section style="padding-top: 0;">
        <div class="container cms-detail">
            @include('partials.cms-media', ['media' => $item['media'] ?? []])

            <div class="cms-article">{!! $item['body'] !!}</div>
        </div>
    </section>

@endsection
```

- [ ] **Step 10: Add the CSS — grid/cards/pagination/article typography/media/carousel/lightbox**

Append to `public/css/style.css`, using this repo's own tokens (`--ink`, `--ink-soft`, `--surface`, `--border`, `--teal`, `--teal-deep`, `--teal-ink`, `--radius-sm/md/lg/pill`, `--shadow-sm/md/lg`, `--space-*`):
```css
/* ---------- CMS Content (Artikel / Sorotan Produk / Portofolio) ---------- */
.cms-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: var(--space-3);
}

.cms-card {
    display: block;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    box-shadow: var(--shadow-sm);
    transition: border-color var(--transition-fast), transform var(--transition-fast), box-shadow var(--transition-fast);
}

.cms-card:hover {
    border-color: var(--border-strong);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.cms-card-media {
    aspect-ratio: 16 / 10;
    background: var(--surface-sunken);
    overflow: hidden;
}

.cms-card-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.cms-card-media-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--bg-soft), var(--bg-soft-deep));
}

.cms-card-body {
    padding: var(--space-2);
}

.cms-card-tag {
    display: inline-block;
    font-size: 0.75rem;
    color: var(--teal-deep);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: var(--space-1);
    font-weight: 700;
}

.cms-card-body h4 {
    margin: 0 0 var(--space-1);
    font-family: var(--font-display);
    color: var(--ink);
}

.cms-card-body p {
    color: var(--ink-soft);
    font-size: 0.9rem;
    margin: 0;
}

.cms-pagination {
    display: flex;
    justify-content: center;
    gap: var(--space-1);
    margin-top: var(--space-4);
}

.cms-pagination a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    border-radius: var(--radius-pill);
    border: 1px solid var(--border);
    color: var(--ink);
    text-decoration: none;
    font-size: 0.9rem;
}

.cms-pagination a.is-active {
    background: var(--teal);
    border-color: var(--teal);
    color: var(--teal-ink);
    font-weight: 600;
}

.cms-detail {
    max-width: 780px;
    margin: 0 auto;
}

.cms-detail-header {
    max-width: 780px;
    margin: 0 auto;
}

.cms-detail-header .section-title {
    font-size: clamp(1.75rem, 3.2vw, 2.75rem);
    line-height: 1.3;
}

.cms-article {
    color: var(--ink-soft);
    font-size: 1.05rem;
    line-height: 1.85;
}

.cms-article h1, .cms-article h2, .cms-article h3, .cms-article h4 {
    color: var(--ink);
    font-family: var(--font-display);
    line-height: 1.35;
    margin: var(--space-4) 0 var(--space-2);
}

.cms-article h1:first-child, .cms-article h2:first-child, .cms-article h3:first-child {
    margin-top: 0;
}

.cms-article p {
    margin: 0 0 var(--space-3);
}

.cms-article strong, .cms-article b {
    color: var(--ink);
    font-weight: 700;
}

.cms-article a {
    color: var(--teal-deep);
    text-decoration: underline;
    text-underline-offset: 2px;
}

.cms-article img {
    max-width: 100%;
    border-radius: var(--radius-sm);
}

/* Ordered lists get a numbered-card treatment so step-by-step content reads
   as distinct steps, not a wall of text — matches Quill's <ol> output. */
.cms-article ol {
    margin: 0 0 var(--space-3);
    padding-left: 0;
    list-style: none;
    counter-reset: cms-list;
}

.cms-article ol li {
    counter-increment: cms-list;
    position: relative;
    padding: var(--space-2) var(--space-2) var(--space-2) 56px;
    margin-bottom: 10px;
    background: var(--bg-soft);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
}

.cms-article ol li::before {
    content: counter(cms-list);
    position: absolute;
    left: var(--space-2);
    top: 50%;
    transform: translateY(-50%);
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--teal);
    color: var(--teal-ink);
    font-family: var(--font-display);
    font-weight: 700;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Same treatment, applied client-side (see layouts/app.blade.php) to plain
   paragraphs typed as "1. Judul Langkah" instead of a real <ol>. */
.cms-article p.cms-step-title {
    position: relative;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-2) var(--space-2) var(--space-2) 56px;
    margin-bottom: 10px;
    background: var(--bg-soft);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    color: var(--ink);
    font-weight: 600;
}

.cms-step-number {
    position: absolute;
    left: var(--space-2);
    top: 50%;
    transform: translateY(-50%);
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--teal);
    color: var(--teal-ink);
    font-family: var(--font-display);
    font-weight: 700;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.cms-article ul {
    margin: 0 0 var(--space-3);
    padding-left: 0;
    list-style: none;
}

.cms-article ul li {
    position: relative;
    padding-left: 22px;
    margin-bottom: 8px;
}

.cms-article ul li::before {
    content: "";
    position: absolute;
    left: 4px;
    top: 0.65em;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--teal);
}

/* ---------- CMS Media: single image / carousel ---------- */
.cms-media-single {
    max-width: 640px;
    margin: 0 auto var(--space-4);
    border-radius: var(--radius-lg);
    overflow: hidden;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-md);
}

.cms-media-single img {
    width: 100%;
    height: auto;
    display: block;
    cursor: zoom-in;
}

.cms-carousel {
    position: relative;
    max-width: 780px;
    aspect-ratio: 16 / 9;
    margin: 0 auto var(--space-4);
    border-radius: var(--radius-lg);
    overflow: hidden;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-md);
    background: var(--surface-sunken);
}

.cms-carousel-track {
    position: relative;
    width: 100%;
    height: 100%;
}

.cms-carousel-slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.5s ease;
    pointer-events: none;
}

.cms-carousel-slide.is-active {
    opacity: 1;
    z-index: 1;
    pointer-events: auto;
}

.cms-carousel-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    cursor: zoom-in;
}

.cms-carousel-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 5;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.85);
    border: 1px solid var(--border);
    color: var(--ink);
    cursor: pointer;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    box-shadow: var(--shadow-sm);
    transition: var(--transition-fast);
}

.cms-carousel-arrow:hover {
    background: var(--surface);
    border-color: var(--teal);
    color: var(--teal-deep);
}

.cms-carousel-prev { left: var(--space-2); }
.cms-carousel-next { right: var(--space-2); }

.cms-carousel-dots {
    position: absolute;
    bottom: var(--space-2);
    left: 50%;
    transform: translateX(-50%);
    z-index: 5;
    display: flex;
    gap: 8px;
}

.cms-carousel-dot {
    width: 8px;
    height: 8px;
    padding: 0;
    border-radius: var(--radius-pill);
    background: rgba(255, 255, 255, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.85);
    box-shadow: var(--shadow-sm);
    cursor: pointer;
    transition: var(--transition-fast);
}

.cms-carousel-dot:hover {
    background: #fff;
}

.cms-carousel-dot.is-active {
    width: 22px;
    background: var(--teal);
    border-color: var(--teal);
}

@media (max-width: 640px) {
    .cms-carousel {
        aspect-ratio: 4 / 3;
    }
}

/* ---------- CMS Lightbox (dark scrim regardless of site theme — a
   fullscreen image viewer conventionally darkens the page either way) ---------- */
.cms-lightbox {
    position: fixed;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 200;
}

.cms-lightbox.is-open {
    display: flex;
}

.cms-lightbox-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(15, 17, 21, 0.92);
    backdrop-filter: blur(4px);
}

.cms-lightbox-frame {
    position: relative;
    max-width: 90vw;
    max-height: 85vh;
    z-index: 1;
}

.cms-lightbox-frame img {
    max-width: 90vw;
    max-height: 85vh;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-dark);
}

.cms-lightbox-close, .cms-lightbox-nav {
    position: absolute;
    z-index: 2;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #fff;
    border-radius: var(--radius-pill);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

.cms-lightbox-close:hover, .cms-lightbox-nav:hover {
    background: rgba(255, 255, 255, 0.22);
    border-color: var(--teal-bright);
}

.cms-lightbox-close {
    top: var(--space-2);
    right: var(--space-2);
    width: 40px;
    height: 40px;
    font-size: 1.25rem;
}

.cms-lightbox-nav {
    top: 50%;
    transform: translateY(-50%);
    width: 48px;
    height: 48px;
    font-size: 1.25rem;
}

.cms-lightbox-prev { left: var(--space-2); }
.cms-lightbox-next { right: var(--space-2); }
```

- [ ] **Step 11: Add nav and footer links**

In `resources/views/partials/navbar.blade.php`, add a plain link right after the Paint Protection Film dropdown, before "Cek Garansi":
```php
<a href="{{ route('articles.index') }}" class="{{ request()->routeIs('articles.*') ? 'is-active' : '' }}">Artikel</a>
```
In `resources/views/partials/footer.blade.php`, add to the Sitemap column right after "Paint Protection Film":
```php
<a href="{{ route('articles.index') }}">Artikel</a>
```

- [ ] **Step 12: Run the tests to verify they pass**

Run: `php artisan test --filter=ArtikelPageTest`
Expected: PASS (4 tests).

- [ ] **Step 13: Commit**

```bash
git add app/Http/Controllers/CmsController.php routes/web.php resources/views/cms/articles resources/views/partials/cms-media.blade.php resources/views/partials/lightbox.blade.php resources/views/layouts/app.blade.php resources/views/partials/navbar.blade.php resources/views/partials/footer.blade.php public/css/style.css tests/Feature/ArtikelPageTest.php
git commit -m "Add Artikel pages backed by the CMS API, plus shared carousel/lightbox"
```

---

### Task 3: Katalog ("Sorotan Produk") — `/sorotan` list + `/sorotan/{slug}` detail

**Files:**
- Modify: `routes/web.php`
- Create: `resources/views/cms/catalog/index.blade.php`
- Create: `resources/views/cms/catalog/show.blade.php`
- Modify: `public/css/style.css`
- Modify: `resources/views/partials/navbar.blade.php`, `resources/views/partials/footer.blade.php`
- Test: `tests/Feature/SorotanPageTest.php`

**Interfaces:**
- Consumes: `CmsController::catalog()`/`::catalogShow()` (already written in Task 2), `CmsClient::catalog()`/`::catalogItem()` (Task 1), all shared CSS/JS from Task 2.
- Produces: routes `sorotan.index` (`GET /sorotan`), `sorotan.show` (`GET /sorotan/{slug}`). Nav label is **"Sorotan Produk"**, deliberately distinct from "Produk" (the existing hardcoded catalog) per spec.

- [ ] **Step 1: Write the failing tests**

```php
<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SorotanPageTest extends TestCase
{
    public function test_index_renders_the_list_from_the_cms(): void
    {
        Http::fake(['*/api/cms/catalog*' => Http::response([
            'data' => [['slug' => 'kaca-film-bv-05', 'title' => 'BV-05 Sorotan', 'excerpt' => 'Ringkasan', 'category' => 'Building', 'published_at' => '2026-09-19T00:00:00+00:00', 'cover' => null]],
            'meta' => ['current_page' => 1, 'last_page' => 1, 'per_page' => 9, 'total' => 1],
        ], 200)]);

        $response = $this->get('/sorotan');

        $response->assertOk();
        $response->assertSee('BV-05 Sorotan');
    }

    public function test_index_shows_an_empty_state_when_the_cms_is_unreachable(): void
    {
        Http::fake(['*/api/cms/catalog*' => Http::response([], 500)]);

        $response = $this->get('/sorotan');

        $response->assertOk();
        $response->assertSee('belum tersedia', false);
    }

    public function test_show_renders_the_body_and_spec_highlights(): void
    {
        Http::fake(['*/api/cms/catalog/kaca-film-bv-05*' => Http::response(['data' => [
            'slug' => 'kaca-film-bv-05', 'title' => 'BV-05 Sorotan', 'body' => '<p>Detail produk</p>',
            'published_at' => '2026-09-19T00:00:00+00:00', 'category' => 'Building',
            'spec_highlights' => [['label' => 'VLT', 'value' => '5%']],
            'media' => [],
        ]], 200)]);

        $response = $this->get('/sorotan/kaca-film-bv-05');

        $response->assertOk();
        $response->assertSee('Detail produk', false);
        $response->assertSee('VLT');
        $response->assertSee('5%');
    }

    public function test_show_returns_404_when_the_cms_has_no_matching_item(): void
    {
        Http::fake(['*/api/cms/catalog/tidak-ada*' => Http::response(['message' => 'Item katalog tidak ditemukan.'], 404)]);

        $this->get('/sorotan/tidak-ada')->assertStatus(404);
    }
}
```

- [ ] **Step 2: Run the tests to verify they fail**

Run: `php artisan test --filter=SorotanPageTest`
Expected: FAIL — routes don't exist yet.

- [ ] **Step 3: Add the routes**

In `routes/web.php`, right after the `/artikel/{slug}` line:
```php
Route::get('/sorotan', [CmsController::class, 'catalog'])->name('sorotan.index');
Route::get('/sorotan/{slug}', [CmsController::class, 'catalogShow'])->name('sorotan.show');
```

- [ ] **Step 4: Write `resources/views/cms/catalog/index.blade.php`**

```blade
@extends('layouts.app')

@section('title', 'Sorotan Produk')
@section('meta_description', 'Sorotan produk dan promo dari LEXENT — Automotive dan Building.')

@section('content')

    <section class="page-header">
        <div class="container">
            <span class="eyebrow">Sorotan</span>
            <h1 class="section-title">Sorotan Produk LEXENT</h1>
        </div>
    </section>

    <section style="padding-top: 0;">
        <div class="container">
            @if(empty($items))
                <p class="section-subtitle" style="text-align: center; margin: var(--space-4) auto;">Konten belum tersedia saat ini.</p>
            @else
                <div class="cms-grid">
                    @foreach($items as $item)
                        <a href="{{ route('sorotan.show', $item['slug']) }}" class="cms-card">
                            <div class="cms-card-media">
                                @if(!empty($item['cover']))
                                    <img src="{{ $item['cover']['thumbnail_url'] }}" alt="{{ $item['cover']['alt_text'] ?? $item['title'] }}" loading="lazy">
                                @else
                                    <div class="cms-card-media-placeholder"></div>
                                @endif
                            </div>
                            <div class="cms-card-body">
                                @if(!empty($item['category']))
                                    <span class="cms-card-tag">{{ $item['category'] }}</span>
                                @endif
                                <h4>{{ $item['title'] }}</h4>
                                <p>{{ $item['excerpt'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($meta && $meta['last_page'] > 1)
                    <nav class="cms-pagination">
                        @for($p = 1; $p <= $meta['last_page']; $p++)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $p]) }}" class="{{ $p === $meta['current_page'] ? 'is-active' : '' }}">{{ $p }}</a>
                        @endfor
                    </nav>
                @endif
            @endif
        </div>
    </section>

@endsection
```

- [ ] **Step 5: Write `resources/views/cms/catalog/show.blade.php`**

```blade
@extends('layouts.app')

@section('title', $item['title'])
@section('meta_description', $item['excerpt'] ?? $item['title'])

@section('content')

    <section class="page-header">
        <div class="container">
            <div class="cms-detail-header">
                <a href="{{ route('sorotan.index') }}" class="back-link">&larr; Kembali ke Sorotan Produk</a>
                @if(!empty($item['category']))
                    <span class="eyebrow">{{ $item['category'] }}</span>
                @endif
                <h1 class="section-title">{{ $item['title'] }}</h1>
            </div>
        </div>
    </section>

    <section style="padding-top: 0;">
        <div class="container cms-detail">
            @include('partials.cms-media', ['media' => $item['media'] ?? []])

            @if(!empty($item['spec_highlights']))
                <div class="cms-spec-list">
                    @foreach($item['spec_highlights'] as $spec)
                        <div class="cms-spec-row">
                            <span class="cms-spec-label">{{ $spec['label'] }}</span>
                            <span class="cms-spec-value">{{ $spec['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="cms-article">{!! $item['body'] !!}</div>
        </div>
    </section>

@endsection
```

- [ ] **Step 6: Add the spec-highlight row CSS**

Append to `public/css/style.css`:
```css
.cms-spec-list {
    display: grid;
    gap: 1px;
    background: var(--border);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    overflow: hidden;
    margin-bottom: var(--space-3);
}

.cms-spec-row {
    display: flex;
    justify-content: space-between;
    padding: var(--space-1) var(--space-2);
    background: var(--surface);
}

.cms-spec-label {
    color: var(--ink-soft);
}

.cms-spec-value {
    color: var(--ink);
    font-weight: 600;
}
```

- [ ] **Step 7: Add nav and footer links**

In `resources/views/partials/navbar.blade.php`, right after the Artikel link added in Task 2:
```php
<a href="{{ route('sorotan.index') }}" class="{{ request()->routeIs('sorotan.*') ? 'is-active' : '' }}">Sorotan Produk</a>
```
In `resources/views/partials/footer.blade.php`, right after the Artikel link added in Task 2:
```php
<a href="{{ route('sorotan.index') }}">Sorotan Produk</a>
```

- [ ] **Step 8: Run the tests to verify they pass**

Run: `php artisan test --filter=SorotanPageTest`
Expected: PASS (4 tests).

- [ ] **Step 9: Commit**

```bash
git add routes/web.php resources/views/cms/catalog public/css/style.css resources/views/partials/navbar.blade.php resources/views/partials/footer.blade.php tests/Feature/SorotanPageTest.php
git commit -m "Add Sorotan Produk pages backed by the CMS API"
```

---

### Task 4: Portofolio — brand-new `/portfolio` list + `/portfolio/{slug}` detail

**Files:**
- Create: `app/Http/Controllers/PortfolioController.php`
- Modify: `routes/web.php`
- Create: `resources/views/portfolio.blade.php`
- Create: `resources/views/portfolio-show.blade.php`
- Modify: `resources/views/partials/navbar.blade.php`, `resources/views/partials/footer.blade.php`
- Test: `tests/Feature/PortfolioPageTest.php`

**Interfaces:**
- Consumes: `CmsClient::portfolio()`/`::portfolioItem()` (Task 1), all shared CSS/JS/partials from Task 2.
- Produces: brand-new routes `portfolio` (`GET /portfolio`), `portfolio.show` (`GET /portfolio/{slug}`) — **unlike `compro-1`, there is nothing to rewire here**; this is entirely new. A **new** `PortfolioController` is used (not folded into `CmsController`) purely for naming clarity — `portfolio`/`portfolio.show` reads better as its own controller than as more methods on a generically-named `CmsController`, and this repo has no existing portfolio code for a rewire to live inside.

- [ ] **Step 1: Write the failing tests**

```php
<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PortfolioPageTest extends TestCase
{
    public function test_index_renders_the_list_from_the_cms(): void
    {
        Http::fake(['*/api/cms/portfolio*' => Http::response([
            'data' => [['slug' => 'gedung-apartemen-a', 'title' => 'Instalasi Gedung Apartemen A', 'excerpt' => 'Ringkasan', 'category' => 'Building', 'published_at' => '2026-09-19T00:00:00+00:00', 'cover' => null]],
            'meta' => ['current_page' => 1, 'last_page' => 1, 'per_page' => 9, 'total' => 1],
        ], 200)]);

        $response = $this->get('/portfolio');

        $response->assertOk();
        $response->assertSee('Instalasi Gedung Apartemen A');
    }

    public function test_index_shows_an_empty_state_when_the_cms_is_unreachable(): void
    {
        Http::fake(['*/api/cms/portfolio*' => Http::response([], 500)]);

        $response = $this->get('/portfolio');

        $response->assertOk();
        $response->assertSee('belum tersedia', false);
    }

    public function test_show_renders_the_body_and_location(): void
    {
        Http::fake(['*/api/cms/portfolio/gedung-apartemen-a*' => Http::response(['data' => [
            'slug' => 'gedung-apartemen-a', 'title' => 'Instalasi Gedung Apartemen A', 'body' => '<p>Detail proyek</p>',
            'published_at' => '2026-09-19T00:00:00+00:00', 'category' => 'Building', 'location' => 'Surabaya',
            'media' => [],
        ]], 200)]);

        $response = $this->get('/portfolio/gedung-apartemen-a');

        $response->assertOk();
        $response->assertSee('Detail proyek', false);
        $response->assertSee('Surabaya');
    }

    public function test_show_returns_404_when_the_cms_has_no_matching_item(): void
    {
        Http::fake(['*/api/cms/portfolio/tidak-ada*' => Http::response(['message' => 'Item portofolio tidak ditemukan.'], 404)]);

        $this->get('/portfolio/tidak-ada')->assertStatus(404);
    }
}
```

- [ ] **Step 2: Run the tests to verify they fail**

Run: `php artisan test --filter=PortfolioPageTest`
Expected: FAIL — routes don't exist yet.

- [ ] **Step 3: Write `app/Http/Controllers/PortfolioController.php`**

```php
<?php

namespace App\Http\Controllers;

use App\Services\CmsClient;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    private CmsClient $cms;

    public function __construct(CmsClient $cms)
    {
        $this->cms = $cms;
    }

    public function index(Request $request)
    {
        $page = max(1, (int) $request->query('page', 1));
        $response = $this->cms->portfolio($page);

        return view('portfolio', [
            'items' => $response['data'] ?? [],
            'meta' => $response['meta'] ?? null,
        ]);
    }

    public function show(string $slug)
    {
        $response = $this->cms->portfolioItem($slug);

        abort_if(!isset($response['data']), 404);

        return view('portfolio-show', ['item' => $response['data']]);
    }
}
```

- [ ] **Step 4: Add the routes**

In `routes/web.php`, add the import alongside `use App\Http\Controllers\CmsController;`, and two new routes at the end of the file:
```php
use App\Http\Controllers\PortfolioController;
```
```php
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolio.show');
```

- [ ] **Step 5: Write `resources/views/portfolio.blade.php`**

```blade
@extends('layouts.app')

@section('title', 'Portfolio')
@section('meta_description', 'Portfolio proyek LEXENT — instalasi kaca film Automotive dan Building.')

@section('content')

    <section class="page-header">
        <div class="container">
            <span class="eyebrow">Our Work</span>
            <h1 class="section-title">Portfolio Proyek LEXENT</h1>
        </div>
    </section>

    <section style="padding-top: 0;">
        <div class="container">
            @if(empty($items))
                <p class="section-subtitle" style="text-align: center; margin: var(--space-4) auto;">Konten belum tersedia saat ini.</p>
            @else
                <div class="cms-grid">
                    @foreach($items as $item)
                        <a href="{{ route('portfolio.show', $item['slug']) }}" class="cms-card">
                            <div class="cms-card-media">
                                @if(!empty($item['cover']))
                                    <img src="{{ $item['cover']['thumbnail_url'] }}" alt="{{ $item['cover']['alt_text'] ?? $item['title'] }}" loading="lazy">
                                @else
                                    <div class="cms-card-media-placeholder"></div>
                                @endif
                            </div>
                            <div class="cms-card-body">
                                @if(!empty($item['category']))
                                    <span class="cms-card-tag">{{ $item['category'] }}</span>
                                @endif
                                <h4>{{ $item['title'] }}</h4>
                                <p>{{ $item['excerpt'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($meta && $meta['last_page'] > 1)
                    <nav class="cms-pagination">
                        @for($p = 1; $p <= $meta['last_page']; $p++)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $p]) }}" class="{{ $p === $meta['current_page'] ? 'is-active' : '' }}">{{ $p }}</a>
                        @endfor
                    </nav>
                @endif
            @endif
        </div>
    </section>

@endsection
```

- [ ] **Step 6: Write `resources/views/portfolio-show.blade.php`**

```blade
@extends('layouts.app')

@section('title', $item['title'])
@section('meta_description', $item['excerpt'] ?? $item['title'])

@section('content')

    <section class="page-header">
        <div class="container">
            <div class="cms-detail-header">
                <a href="{{ route('portfolio') }}" class="back-link">&larr; Kembali ke Portfolio</a>
                @if(!empty($item['category']))
                    <span class="eyebrow">{{ $item['category'] }}</span>
                @endif
                <h1 class="section-title">{{ $item['title'] }}</h1>
                @if(!empty($item['location']))
                    <p class="section-subtitle">{{ $item['location'] }}</p>
                @endif
            </div>
        </div>
    </section>

    <section style="padding-top: 0;">
        <div class="container cms-detail">
            @include('partials.cms-media', ['media' => $item['media'] ?? []])

            <div class="cms-article">{!! $item['body'] !!}</div>
        </div>
    </section>

@endsection
```

- [ ] **Step 7: Add nav and footer links**

In `resources/views/partials/navbar.blade.php`, right after the Sorotan Produk link added in Task 3:
```php
<a href="{{ route('portfolio') }}" class="{{ request()->routeIs('portfolio') ? 'is-active' : '' }}">Portfolio</a>
```
In `resources/views/partials/footer.blade.php`, right after the Sorotan Produk link added in Task 3:
```php
<a href="{{ route('portfolio') }}">Portfolio</a>
```

- [ ] **Step 8: Run the tests to verify they pass**

Run: `php artisan test --filter=PortfolioPageTest`
Expected: PASS (4 tests).

- [ ] **Step 9: Run the full test suite**

Run: `php artisan test`
Expected: all tests pass, including `CmsClientTest`, `ArtikelPageTest`, `SorotanPageTest`, `PortfolioPageTest`, and the pre-existing scaffold tests.

- [ ] **Step 10: Manual smoke test — do this whole flow by hand in a browser**

Prerequisite: the `dashboard` app must be running with at least one **published** Artikel, Katalog item, and Portofolio item that all have `show_on_lexent` checked (reuse or create via the dashboard's CMS admin UI).

1. `php artisan serve` (or the project's configured dev-server workflow) in `compro-2`, visit `/`.
2. Confirm the navbar now shows Paint Protection Film → Artikel → Sorotan Produk → Portfolio → Cek Garansi, in that order, and the footer Sitemap column matches.
3. Visit `/artikel` — confirm the published article appears as a card; click into it, confirm the body renders with the amber-gold accent styling (not dark theme colors), and if it has images, confirm the carousel or single-image display appears large (not tiny thumbnails) and clicking opens the lightbox with prev/next and Escape-to-close working.
4. Confirm any "N. Judul Langkah"-style plain-paragraph steps in the body render as numbered cards, same as verified on `compro-1`.
5. Repeat step 3 for `/sorotan` — additionally confirm `spec_highlights` rows render under the gallery.
6. Visit `/portfolio` — confirm it's a working brand-new page (not present before this plan), shows real CMS items, and click into one to confirm the detail page including `location` if set.
7. Stop the `dashboard` server, then reload `/artikel`, `/sorotan`, and `/portfolio` — confirm each shows "Konten belum tersedia saat ini." instead of an error page. Restart `dashboard` afterward.
8. Confirm every other existing page (`/`, `/about`, `/products`, `/paint-protection-film`, `/dealers`, `/cek-garansi`) still renders with no visual regression.

- [ ] **Step 11: Commit**

```bash
git add app/Http/Controllers/PortfolioController.php routes/web.php resources/views/portfolio.blade.php resources/views/portfolio-show.blade.php resources/views/partials/navbar.blade.php resources/views/partials/footer.blade.php tests/Feature/PortfolioPageTest.php
git commit -m "Add brand-new Portfolio pages backed by the CMS API"
```

---

## Self-Review Notes

- **Spec coverage:** `Http` facade server-side calls only (never client-side `fetch()`, explicitly distinguished from this repo's own `cek-garansi` pattern) ✅ (Task 1); config-only `env()` access ✅ (Task 1); no caching ✅ (Task 1, matches the corrected `compro-1` design); resilience (try/catch, empty-state, no crash) ✅ (Task 1 unit tests + every page test's "CMS unreachable" case); `/artikel`, `/artikel/{slug}` ✅ (Task 2); `/sorotan`, `/sorotan/{slug}` with the distinct "Sorotan Produk" label ✅ (Task 3); hand-rolled carousel + lightbox, no new JS dependency, numbered-step detection included from the start ✅ (Task 2, reused by 3 and 4); brand-new `/portfolio`, `/portfolio/{slug}` (correctly *not* treated as a rewire, since nothing existed to rewire) ✅ (Task 4).
- **Placeholder scan:** no TBD/TODO; every step has real, complete code.
- **Type consistency:** `CmsClient` method names/return shapes are identical to `compro-1`'s (intentional — same dashboard API); the `CmsController`/`PortfolioController` view-data keys (`items`, `meta`, `item`) and Blade field accesses (`$item['slug']`, `$item['cover']['thumbnail_url']`, `$item['media']`, `$item['spec_highlights']`, `$item['location']`) match the exact API response shapes documented at the top of this plan and match `dashboard`'s actual `Api\{Article,Catalog,Portfolio}Controller` output.
- **Theme correctness double-checked:** every new CSS rule in this plan uses `compro-2`'s own token names (`--ink`, `--ink-soft`, `--surface`, `--surface-sunken`, `--border`, `--border-strong`, `--teal`, `--teal-deep`, `--teal-ink`, `--teal-bright`, `--bg-soft`, `--bg-soft-deep`, `--radius-*`, `--shadow-*`) verified against the actual `:root` block in `compro-2/public/css/style.css` — none of `compro-1`'s dark-theme token names (`--text`, `--bg-alt`, `--silver`, etc.) were carried over.

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

    public function test_index_shows_filter_buttons_and_marks_the_active_category(): void
    {
        Http::fake([
            '*/api/cms/portfolio-categories*' => Http::response(['data' => ['Kaca Film Bangunan', 'Kaca Film Mobil', 'PPF']], 200),
            '*/api/cms/portfolio*' => Http::response([
                'data' => [['slug' => 'ppf-1', 'title' => 'PPF Porsche', 'excerpt' => 'x', 'category' => 'PPF', 'cover' => null]],
                'meta' => ['current_page' => 1, 'last_page' => 1, 'per_page' => 9, 'total' => 1],
            ], 200),
        ]);

        $response = $this->get('/portfolio?category=PPF');

        $response->assertOk();
        $response->assertSee('class="cms-filter"', false);
        $response->assertSeeInOrder(['Semua', 'Kaca Film Bangunan', 'Kaca Film Mobil', 'PPF']);
        $response->assertSee('category=Kaca%20Film%20Mobil', false);
        preg_match('/<nav class="cms-filter".*?<\/nav>/s', $response->getContent(), $filter);
        $this->assertSame(1, substr_count($filter[0], 'is-active'));
        $this->assertMatchesRegularExpression('/is-active">PPF</', $filter[0]);
        $response->assertSee('PPF Porsche');

        Http::assertSent(function ($request) {
            return strpos($request->url(), '/api/cms/portfolio?') !== false
                && strpos($request->url(), 'category=PPF') !== false;
        });
    }

    public function test_index_without_a_category_marks_semua_active_and_sends_no_filter(): void
    {
        Http::fake([
            '*/api/cms/portfolio-categories*' => Http::response(['data' => ['PPF']], 200),
            '*/api/cms/portfolio*' => Http::response(['data' => [['slug' => 's', 'title' => 'Item S', 'excerpt' => 'x', 'category' => 'PPF', 'cover' => null]], 'meta' => ['current_page' => 1, 'last_page' => 1, 'per_page' => 9, 'total' => 1]], 200),
        ]);

        $response = $this->get('/portfolio');

        $response->assertOk()->assertSee('is-active">Semua', false);
        Http::assertSent(fn ($request) => strpos($request->url(), '/api/cms/portfolio?') !== false && strpos($request->url(), 'category=') === false);
    }

    public function test_index_shows_a_category_specific_empty_state(): void
    {
        Http::fake([
            '*/api/cms/portfolio-categories*' => Http::response(['data' => ['PPF']], 200),
            '*/api/cms/portfolio*' => Http::response(['data' => [], 'meta' => ['current_page' => 1, 'last_page' => 1, 'per_page' => 9, 'total' => 0]], 200),
        ]);

        $this->get('/portfolio?category=Tidak+Ada')->assertOk()->assertSee('Belum ada portfolio untuk kategori ini.');
    }

    public function test_index_has_no_filter_bar_when_there_are_no_categories(): void
    {
        Http::fake([
            '*/api/cms/portfolio-categories*' => Http::response(['data' => []], 200),
            '*/api/cms/portfolio*' => Http::response(['data' => [], 'meta' => null], 200),
        ]);

        $this->get('/portfolio')->assertOk()->assertDontSee('class="cms-filter"', false);
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

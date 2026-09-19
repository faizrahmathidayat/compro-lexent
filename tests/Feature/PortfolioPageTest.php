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

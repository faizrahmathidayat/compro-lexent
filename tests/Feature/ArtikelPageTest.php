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

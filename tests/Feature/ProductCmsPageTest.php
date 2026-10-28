<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProductCmsPageTest extends TestCase
{
    private function menu(array $data)
    {
        return Http::response(['data' => $data], 200);
    }

    private function item(string $slug, string $title, string $category, array $specs = []): array
    {
        return ['slug' => $slug, 'title' => $title, 'excerpt' => 'Ringkasan ' . $title, 'category' => $category, 'spec_highlights' => $specs, 'cover' => null];
    }

    public function test_building_page_shows_the_cms_items_and_category_filter(): void
    {
        Http::fake([
            '*/api/cms/catalog-menu*' => $this->menu(['Kaca Film Bangunan' => ['Black Vision', 'Frosted']]),
            '*/api/cms/catalog*' => Http::response(['data' => [
                $this->item('bv-05', 'Black Vision 05', 'Black Vision', [['label' => 'VLT', 'value' => '5%'], ['label' => 'TSER', 'value' => '62%']]),
            ], 'meta' => ['current_page' => 1, 'last_page' => 1, 'per_page' => 9, 'total' => 1]], 200),
        ]);

        $response = $this->get('/kaca-film-bangunan');

        $response->assertOk()
            ->assertSee('Black Vision 05')->assertSee('Ringkasan Black Vision 05')
            ->assertSeeInOrder(['VLT', '5%', 'TSER', '62%'])
            ->assertSee('href="' . url('/sorotan/bv-05') . '"', false)
            ->assertSee('class="series-filter"', false)
            ->assertSeeInOrder(['Semua Seri', 'Black Vision', 'Frosted'])
            ->assertDontSee('Reflective Series');
        Http::assertSent(fn ($r) => str_contains($r->url(), '/api/cms/catalog?') && str_contains($r->url(), 'product=Kaca%20Film%20Bangunan') && !str_contains($r->url(), 'category='));
    }

    public function test_category_query_is_sent_to_the_cms_and_marked_active(): void
    {
        Http::fake([
            '*/api/cms/catalog-menu*' => $this->menu(['Kaca Film Mobil' => ['HT Series', 'MK Series']]),
            '*/api/cms/catalog*' => Http::response(['data' => [$this->item('ht-1', 'HT 1', 'HT Series')], 'meta' => null], 200),
        ]);

        $html = $this->get('/kaca-film-mobil?category=HT+Series')->assertOk()->assertSee('HT 1')->getContent();

        $this->assertMatchesRegularExpression('/is-active">HT Series</', $html);
        Http::assertSent(fn ($r) => str_contains($r->url(), '/api/cms/catalog?') && str_contains($r->url(), 'category=HT%20Series'));
    }

    public function test_ppf_page_also_comes_from_the_cms(): void
    {
        Http::fake([
            '*/api/cms/catalog-menu*' => $this->menu(['PPF' => ['Type S']]),
            '*/api/cms/catalog*' => Http::response(['data' => [$this->item('ppf-s', 'PPF Type S Baru', 'Type S')], 'meta' => null], 200),
        ]);

        $this->get('/paint-protection-film')->assertOk()->assertSee('PPF Type S Baru')->assertDontSee('Type T Plus');
    }

    public function test_unknown_category_shows_an_empty_state_but_keeps_the_filter(): void
    {
        Http::fake([
            '*/api/cms/catalog-menu*' => $this->menu(['Kaca Film Bangunan' => ['Black Vision']]),
            '*/api/cms/catalog*' => Http::response(['data' => [], 'meta' => null], 200),
        ]);

        $this->get('/kaca-film-bangunan?category=Nope')->assertOk()->assertSee('Tidak ada produk untuk kategori ini.')->assertSee('Black Vision');
    }

    public function test_pages_keep_their_static_catalog_while_the_cms_has_nothing_for_the_product(): void
    {
        Http::fake(['*/api/cms/catalog*' => Http::response([], 500)]);

        $this->get('/kaca-film-bangunan')->assertOk()->assertSee('LEXENT Black Vision 05');
        $this->get('/kaca-film-mobil')->assertOk()->assertSee('LEXENT HT');
        $this->get('/paint-protection-film')->assertOk()->assertSee('Type T Plus');
    }
}

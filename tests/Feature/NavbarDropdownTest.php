<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NavbarDropdownTest extends TestCase
{
    public function test_building_dropdown_lists_the_building_series_with_series_links(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();
        $menu = $this->dropdownAfter($html, 'Kaca Film Bangunan');

        $this->assertSame(
            ['Black Vision', 'Reflective Series', 'High Performance', 'Ultra Protect'],
            $this->labels($menu)
        );
        $this->assertStringContainsString('href="' . url('/kaca-film-bangunan?series=BV') . '"', $menu);
        $this->assertStringNotContainsString('BP Series', $menu);
    }

    public function test_automotive_dropdown_lists_the_automotive_series_with_series_links(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();
        $menu = $this->dropdownAfter($html, 'Kaca Film Mobil');

        $this->assertSame(['BP Series', 'HT Series', 'MK Series', 'IR99 Series'], $this->labels($menu));
        $this->assertStringContainsString('href="' . url('/kaca-film-mobil?series=HT') . '"', $menu);
    }

    public function test_ppf_dropdown_lists_the_four_types_linking_to_their_detail_pages(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();
        $menu = $this->dropdownAfter($html, 'PPF');

        $this->assertSame(
            ['LEXENT PPF Type S', 'LEXENT PPF Type T Plus', 'LEXENT PPF Type L', 'LEXENT PPF Type L Matte'],
            $this->labels($menu)
        );
        $this->assertStringContainsString('href="' . url('/paint-protection-film/type-s') . '"', $menu);
    }

    public function test_each_dropdown_starts_with_a_see_all_link_to_its_parent_page_for_mobile(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();

        preg_match_all('/<a href="([^"]+)" class="navbar-dropdown-all">(.*?)<\/a>/s', $html, $all);

        $this->assertSame(
            [url('/kaca-film-bangunan'), url('/kaca-film-mobil'), url('/paint-protection-film')],
            $all[1]
        );
        $this->assertSame(['Semua Seri', 'Semua Seri', 'Semua Tipe PPF'], $all[2]);
    }

    public function test_every_dropdown_link_resolves(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();

        preg_match_all('/<div class="navbar-dropdown-menu">(.*?)<\/div>/s', $html, $menus);
        preg_match_all('/href="([^"]+)"/', implode('', $menus[1]), $links);

        $this->assertCount(15, $links[1]);
        foreach ($links[1] as $link) {
            $this->get($link)->assertOk();
        }
    }

    public function test_the_same_dropdowns_render_on_cms_driven_pages(): void
    {
        Http::fake(['*' => Http::response(['data' => [], 'meta' => null], 200)]);

        $this->get('/portfolio')->assertOk()
            ->assertSee('class="navbar-dropdown-menu"', false)
            ->assertSee('IR99 Series')
            ->assertSee('LEXENT PPF Type L Matte');
    }

    public function test_top_level_menu_order_and_links_are_unchanged(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();
        preg_match('/<nav class="navbar-links".*?<\/nav>/s', $html, $nav);
        $topLevel = preg_replace('/<div class="navbar-dropdown-menu">.*?<\/div>/s', '', $nav[0]);
        preg_match_all('/<a [^>]*>(.*?)(?:<span[^>]*><\/span>)?<\/a>/s', $topLevel, $labels);

        $this->assertSame(
            ['Home', 'Kaca Film Bangunan', 'Kaca Film Mobil', 'PPF', 'Portfolio', 'About', 'Artikel', 'Warranty'],
            array_map('trim', $labels[1])
        );
    }

    /** The dropdown panel that follows the top-level link with the given label. */
    private function dropdownAfter(string $html, string $label): string
    {
        $pattern = '/' . preg_quote($label, '/') . '<span class="navbar-caret"[^>]*><\/span><\/a>\s*<div class="navbar-dropdown-menu">(.*?)<\/div>/s';
        $this->assertSame(1, preg_match($pattern, $html, $m), "No dropdown found for {$label}");

        return $m[1];
    }

    /** Item labels, ignoring the mobile-only "Semua ..." link at the top of each panel. */
    private function labels(string $menu): array
    {
        $menu = preg_replace('/<a [^>]*class="navbar-dropdown-all"[^>]*>.*?<\/a>/s', '', $menu);
        preg_match_all('/<a [^>]*>(.*?)<\/a>/s', $menu, $m);

        return array_map('trim', $m[1]);
    }
}

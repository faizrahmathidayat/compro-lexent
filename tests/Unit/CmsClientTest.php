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

    public function test_portfolio_sends_the_category_only_when_given(): void
    {
        Http::fake(['*/api/cms/portfolio*' => Http::response(['data' => [], 'meta' => []], 200)]);

        (new CmsClient())->portfolio(2, 'PPF');
        (new CmsClient())->portfolio(1);

        $urls = Http::recorded()->map(fn ($pair) => $pair[0]->url())->values()->all();
        $this->assertStringContainsString('category=PPF', $urls[0]);
        $this->assertStringContainsString('page=2', $urls[0]);
        $this->assertStringNotContainsString('category=', $urls[1]);
    }

    public function test_portfolio_categories_returns_the_list(): void
    {
        Http::fake(['*/api/cms/portfolio-categories*' => Http::response(['data' => ['PPF', 'Kaca Film Mobil']], 200)]);

        $this->assertSame(['PPF', 'Kaca Film Mobil'], (new CmsClient())->portfolioCategories());
    }

    public function test_portfolio_categories_is_an_empty_array_on_failure(): void
    {
        Http::fake(['*/api/cms/portfolio-categories*' => Http::response([], 500)]);

        $this->assertSame([], (new CmsClient())->portfolioCategories());
    }

    public function test_portfolio_categories_ignores_entries_that_are_not_plain_strings(): void
    {
        Http::fake(['*/api/cms/portfolio-categories*' => Http::response(['data' => ['PPF', ['slug' => 'x'], '', null, 'Kaca Film Mobil']], 200)]);

        $this->assertSame(['PPF', 'Kaca Film Mobil'], (new CmsClient())->portfolioCategories());
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

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

    public function portfolio(int $page = 1, ?string $category = null): ?array
    {
        $query = ['page' => $page];
        if ($category !== null && $category !== '') {
            $query['category'] = $category;
        }

        return $this->request('/api/cms/portfolio', $query);
    }

    /**
     * Categories that currently have published portfolio items for this site;
     * an empty list when the CMS is unreachable.
     */
    public function portfolioCategories(): array
    {
        $response = $this->request('/api/cms/portfolio-categories', []);

        $categories = is_array($response['data'] ?? null) ? $response['data'] : [];

        return array_values(array_filter($categories, function ($category) {
            return is_string($category) && trim($category) !== '';
        }));
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

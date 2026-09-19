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

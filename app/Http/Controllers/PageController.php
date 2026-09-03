<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * The four LEXENT automotive window-film series, straight from the printed
     * catalog. Copy, attributes and the technology story per series are the
     * catalog's own wording.
     */
    private function seriesCatalog(): array
    {
        return [
            'BP' => [
                'code' => 'BP',
                'name' => 'LEXENT BP',
                'label' => 'BP Series',
                'accent' => 'accent-bp',
                'tagline' => 'Privasi Tinggi, Low Haze',
                'description' => 'LEXENT BP hadir dengan teknologi kaca film yang dirancang untuk memberikan perlindungan optimal dari panas & sinar UV, sekaligus menghadirkan privasi tinggi dan kenyamanan berkendara setiap saat.',
                'attributes' => ['High Privacy', 'Low Haze', 'UV Protection'],
                'metrics' => [
                    ['value' => '99%', 'label' => 'UV Rejection'],
                    ['value' => '62%', 'label' => 'Heat Rejection'],
                    ['value' => '7 Th', 'label' => 'Garansi'],
                ],
            ],
            'HT' => [
                'code' => 'HT',
                'name' => 'LEXENT HT',
                'label' => 'HT Series',
                'accent' => 'accent-ht',
                'tagline' => 'Nano Ceramic HD, Heat Insulation',
                'description' => 'LEXENT HT hadir dengan teknologi nano ceramic terkini yang dirancang untuk memberikan perlindungan maksimal dari panas & sinar UV, tanpa mengurangi kejernihan pandangan.',
                'attributes' => ['Ultra High Definition', 'Ultra Low Haze', 'High Level Heat Insulation', 'UV Protection'],
                'metrics' => [
                    ['value' => '99%', 'label' => 'UV Rejection'],
                    ['value' => '93%', 'label' => 'Infrared Rejection'],
                    ['value' => '70%', 'label' => 'Heat Rejection'],
                ],
            ],
            'MK' => [
                'code' => 'MK',
                'name' => 'LEXENT MK',
                'label' => 'MK Series',
                'accent' => 'accent-mk',
                'tagline' => 'Magnetron Sputter, Non-Metal',
                'description' => 'LEXENT MK hadir dengan teknologi Magnetron Sputter yang menggunakan material berkualitas tinggi untuk memberikan perlindungan optimal dari panas & sinar UV, dengan tetap menjaga kejernihan pandangan serta tidak mengganggu sinyal HP, GPS, maupun perangkat elektronik di dalam kendaraan.',
                'attributes' => ['Extraordinary Clarity', 'Extraordinary Heat Insulation', 'Ultra-Low Haze', 'No Signal Interference'],
                'metrics' => [
                    ['value' => '99%', 'label' => 'UV Rejection'],
                    ['value' => '99%', 'label' => 'Infrared Rejection'],
                    ['value' => '76%', 'label' => 'Heat Rejection'],
                ],
            ],
            'IR99' => [
                'code' => 'IR99',
                'name' => 'LEXENT IR99',
                'label' => 'IR99 Series',
                'accent' => 'accent-ir',
                'tagline' => 'UV400 Nano Ceramic HD',
                'description' => 'LEXENT IR99 mengusung teknologi UV400 Nano Ceramic HD yang memberikan perlindungan maksimal terhadap sinar UV dan panas, dengan kejernihan visual tinggi untuk pengalaman berkendara yang lebih nyaman dan terlindungi.',
                'attributes' => ['Clear & High Transparency', 'Cooler & More Comfortable'],
                'metrics' => [
                    ['value' => '99%', 'label' => 'UV Rejection'],
                    ['value' => '99%', 'label' => 'Infrared Rejection'],
                    ['value' => '81%', 'label' => 'Heat Rejection'],
                ],
            ],
        ];
    }

    /**
     * Flat list of every VLT variant across all four series, with the exact
     * specification figures from the catalog (VLT / VLR / TSER / UV / IRR /
     * thickness).
     */
    private function productLineup(): array
    {
        $series = $this->seriesCatalog();

        // [ series, number, vlt, vlr, tser, uv, irr, thickness ]
        $rows = [
            ['BP', '05', '5%', '8%', '62%', '99%', '75%', '1,8 mil'],
            ['BP', '18', '5%', '8%', '58%', '99%', '65%', '1,8 mil'],
            ['BP', '35', '5%', '8%', '53%', '99%', '63%', '1,8 mil'],

            ['HT', '08', '8%', '5%', '70%', '99%', '93%', '2 mil'],
            ['HT', '15', '15%', '5%', '68%', '99%', '90%', '2 mil'],
            ['HT', '35', '34%', '6%', '67%', '99%', '91%', '2 mil'],
            ['HT', '70', '70%', '8%', '63%', '99%', '91%', '2 mil'],

            ['MK', '08', '8%', '6%', '76%', '99%', '99%', '2 mil'],
            ['MK', '20', '20%', '6%', '74%', '99%', '99%', '2 mil'],
            ['MK', '30', '28%', '6%', '73%', '99%', '99%', '2 mil'],
            ['MK', '50', '47%', '6%', '71%', '99%', '99%', '2 mil'],
            ['MK', '65', '57%', '6%', '71%', '99%', '99%', '2 mil'],
            ['MK', '75', '68%', '6%', '71%', '99%', '99%', '2 mil'],

            ['IR99', '08', '8%', '5%', '81%', '99%', '99%', '2,2 mil'],
            ['IR99', '18', '20%', '5%', '78%', '99%', '99%', '2,2 mil'],
            ['IR99', '35', '36%', '5%', '77%', '99%', '99%', '2,2 mil'],
            ['IR99', '50', '51%', '6%', '73%', '99%', '99%', '2,2 mil'],
            ['IR99', '70', '72%', '6%', '72%', '99%', '99%', '2,2 mil'],
        ];

        $lineup = [];

        foreach ($rows as [$code, $number, $vlt, $vlr, $tser, $uv, $irr, $thickness]) {
            $meta = $series[$code];
            $vltNumber = (int) $vlt;

            if ($vltNumber <= 15) {
                $darkness = 'Sangat gelap — privasi maksimal';
            } elseif ($vltNumber <= 40) {
                $darkness = 'Gelap sedang — seimbang';
            } else {
                $darkness = 'Terang — visibilitas tinggi';
            }

            $lineup[] = [
                'slug' => strtolower($code) . '-' . $number,
                'name' => $meta['name'] . ' ' . $number,
                'series' => $code,
                'series_label' => $meta['label'],
                'series_code_display' => $code . ' ' . $number,
                'number' => $number,
                'accent' => $meta['accent'],
                'badge' => $meta['attributes'][0],
                'tagline' => $meta['tagline'],
                'series_description' => $meta['description'],
                'short_description' => $meta['tagline'] . '. ' . $darkness . '.',
                'attributes' => $meta['attributes'],
                'darkness' => $darkness,
                'vlt' => $vlt,
                'vlr' => $vlr,
                'tser' => $tser,
                'uv' => $uv,
                'irr' => $irr,
                'thickness' => $thickness,
            ];
        }

        return $lineup;
    }

    /**
     * Hero slider: one slide per series, wording drawn from the catalog.
     */
    private function heroSlides(): array
    {
        $slides = [];

        foreach ($this->seriesCatalog() as $meta) {
            $slides[] = [
                'code' => $meta['code'],
                'tag' => $meta['label'],
                'headline' => $meta['tagline'],
                'subtext' => $meta['description'],
                'metrics' => $meta['metrics'],
            ];
        }

        return $slides;
    }

    /**
     * "Why LEXENT" — conventional film vs LEXENT, using the catalog's own claims.
     */
    private function matrixComparison(): array
    {
        return [
            [
                'label' => 'Penolakan Sinar UV',
                'conventional' => ['text' => 'Sekitar 50%, memudar seiring waktu', 'status' => 'cross'],
                'lexent' => ['text' => '99% ditolak di seluruh seri', 'status' => 'check'],
            ],
            [
                'label' => 'Penolakan Panas (TSER)',
                'conventional' => ['text' => 'Rendah, kabin cepat panas', 'status' => 'cross'],
                'lexent' => ['text' => 'Hingga 81% (IR99 08)', 'status' => 'check'],
            ],
            [
                'label' => 'Infrared Rejection',
                'conventional' => ['text' => 'Minim, terasa menyengat', 'status' => 'cross'],
                'lexent' => ['text' => 'Hingga 99% (MK & IR99)', 'status' => 'check'],
            ],
            [
                'label' => 'Gangguan Sinyal HP / GPS',
                'conventional' => ['text' => 'Sering terganggu pada film metal', 'status' => 'cross'],
                'lexent' => ['text' => 'Non-metal & bebas gangguan (MK)', 'status' => 'check'],
            ],
            [
                'label' => 'Kejernihan Pandangan',
                'conventional' => ['text' => 'Berkabut, haze meningkat', 'status' => 'cross'],
                'lexent' => ['text' => 'Ultra-low haze, HD clarity', 'status' => 'check'],
            ],
            [
                'label' => 'Garansi Resmi',
                'conventional' => ['text' => '1–2 tahun', 'status' => 'cross'],
                'lexent' => ['text' => 'Hingga 7 tahun', 'status' => 'check'],
            ],
        ];
    }

    /**
     * Static official authorized dealer / workshop listing.
     */
    private function dealerList(): array
    {
        return [
            [
                'name' => 'Lexent Gallery Sudirman',
                'city' => 'Jakarta',
                'address' => 'Jl. Jenderal Sudirman Kav. 52, Jakarta Selatan',
                'phone' => '(021) 555-0177',
                'maps_url' => 'https://maps.google.com/?q=Jl.+Jenderal+Sudirman+Kav.+52+Jakarta+Selatan',
            ],
            [
                'name' => 'Lexent Gallery Kelapa Gading',
                'city' => 'Jakarta',
                'address' => 'Jl. Boulevard Raya Blok QJ No. 9, Jakarta Utara',
                'phone' => '(021) 555-0234',
                'maps_url' => 'https://maps.google.com/?q=Jl.+Boulevard+Raya+Blok+QJ+No.+9+Jakarta+Utara',
            ],
            [
                'name' => 'Lexent Gallery Bandung',
                'city' => 'Bandung',
                'address' => 'Jl. Ir. H. Djuanda No. 102, Bandung',
                'phone' => '(022) 555-0198',
                'maps_url' => 'https://maps.google.com/?q=Jl.+Ir.+H.+Djuanda+No.+102+Bandung',
            ],
            [
                'name' => 'Lexent Gallery Surabaya',
                'city' => 'Surabaya',
                'address' => 'Jl. HR. Muhammad No. 45, Surabaya',
                'phone' => '(031) 555-0176',
                'maps_url' => 'https://maps.google.com/?q=Jl.+HR.+Muhammad+No.+45+Surabaya',
            ],
            [
                'name' => 'Lexent Gallery Medan',
                'city' => 'Medan',
                'address' => 'Jl. Gatot Subroto No. 23, Medan',
                'phone' => '(061) 555-0142',
                'maps_url' => 'https://maps.google.com/?q=Jl.+Gatot+Subroto+No.+23+Medan',
            ],
            [
                'name' => 'Lexent Gallery Semarang',
                'city' => 'Semarang',
                'address' => 'Jl. Pandanaran No. 67, Semarang',
                'phone' => '(024) 555-0189',
                'maps_url' => 'https://maps.google.com/?q=Jl.+Pandanaran+No.+67+Semarang',
            ],
        ];
    }

    public function home()
    {
        return view('home', [
            'series' => array_values($this->seriesCatalog()),
            'products' => $this->productLineup(),
            'dealers' => $this->dealerList(),
            'slides' => $this->heroSlides(),
            'matrix' => $this->matrixComparison(),
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function products()
    {
        return view('products.index', [
            'series' => array_values($this->seriesCatalog()),
            'products' => $this->productLineup(),
        ]);
    }

    public function productDetail(string $slug)
    {
        $product = collect($this->productLineup())->firstWhere('slug', $slug);

        abort_if(!$product, 404);

        $related = collect($this->productLineup())
            ->where('series', $product['series'])
            ->where('slug', '!=', $product['slug'])
            ->values()
            ->all();

        return view('products.show', [
            'product' => $product,
            'related' => $related,
        ]);
    }

    public function dealers()
    {
        $dealers = $this->dealerList();

        $cities = collect($dealers)->pluck('city')->unique()->values()->all();

        return view('dealers', [
            'dealers' => $dealers,
            'cities' => $cities,
        ]);
    }

    public function cekGaransi()
    {
        return view('cek-garansi');
    }
}

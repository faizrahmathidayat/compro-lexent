<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * All eight LEXENT window-film series across both divisions, straight from
     * the printed catalogs. Copy, attributes and per-series technology are the
     * catalogs' own wording. `segment` drives every automotive/building split
     * in the views (nav, homepage showcase, product filter, matrix).
     */
    private function seriesCatalog(): array
    {
        return [
            // ---------------------------------------------------------- Automotive
            'BP' => [
                'code' => 'BP',
                'name' => 'LEXENT BP',
                'label' => 'BP Series',
                'segment' => 'automotive',
                'accent' => 'accent-bp',
                'warranty_years' => 7,
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
                'segment' => 'automotive',
                'accent' => 'accent-ht',
                'warranty_years' => 7,
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
                'segment' => 'automotive',
                'accent' => 'accent-mk',
                'warranty_years' => 7,
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
                'segment' => 'automotive',
                'accent' => 'accent-ir',
                'warranty_years' => 7,
                'tagline' => 'UV400 Nano Ceramic HD',
                'description' => 'LEXENT IR99 mengusung teknologi UV400 Nano Ceramic HD yang memberikan perlindungan maksimal terhadap sinar UV dan panas, dengan kejernihan visual tinggi untuk pengalaman berkendara yang lebih nyaman dan terlindungi.',
                'attributes' => ['Clear & High Transparency', 'Cooler & More Comfortable'],
                'metrics' => [
                    ['value' => '99%', 'label' => 'UV Rejection'],
                    ['value' => '99%', 'label' => 'Infrared Rejection'],
                    ['value' => '81%', 'label' => 'Heat Rejection'],
                ],
            ],

            // ------------------------------------------------------------ Building
            'BV' => [
                'code' => 'BV',
                'name' => 'LEXENT Black Vision',
                'label' => 'Black Vision',
                'segment' => 'building',
                'accent' => 'accent-bv',
                'warranty_years' => 8,
                'tagline' => 'Privasi Tinggi & Kontrol Panas',
                'description' => 'LEXENT Black Series hadir dengan teknologi kaca film yang dirancang untuk memberikan perlindungan optimal dari panas & sinar UV, sekaligus menghadirkan privasi tinggi dan kenyamanan pada bangunan Anda.',
                'attributes' => ['High Privacy', 'Low Haze', 'UV Protection'],
                'metrics' => [
                    ['value' => '99%', 'label' => 'UV Rejection'],
                    ['value' => '62%', 'label' => 'Heat Rejection'],
                    ['value' => '75%', 'label' => 'Infrared Rejection'],
                ],
            ],
            'RF' => [
                'code' => 'RF',
                'name' => 'LEXENT Reflective',
                'label' => 'Reflective Series',
                'segment' => 'building',
                'accent' => 'accent-rf',
                'warranty_years' => 8,
                'tagline' => 'Reflektif, Modern & Elegan',
                'description' => 'LEXENT Reflective Series menghadirkan solusi kaca film dengan karakter reflektif yang dirancang untuk meningkatkan perlindungan dari panas matahari, memberikan privasi yang lebih baik, serta menciptakan tampilan modern dan elegan pada bangunan Anda.',
                'attributes' => ['Karakter Reflektif', 'Privasi Lebih Baik', 'Tampilan Modern'],
                'metrics' => [
                    ['value' => '92%', 'label' => 'Infrared Rejection'],
                    ['value' => '55%', 'label' => 'Heat Rejection'],
                    ['value' => '90%', 'label' => 'UV Rejection'],
                ],
            ],
            'HP' => [
                'code' => 'HP',
                'name' => 'LEXENT High Performance',
                'label' => 'High Performance',
                'segment' => 'building',
                'accent' => 'accent-hp',
                'warranty_years' => 8,
                'tagline' => 'Ultra HD Nano Ceramic',
                'description' => 'LEXENT High Performance hadir dengan teknologi Ultra HD Nano Ceramic terbaru yang dirancang untuk memberikan perlindungan optimal dari panas & sinar UV, dengan kejernihan tinggi untuk menghadirkan kenyamanan dan visibilitas yang lebih baik.',
                'attributes' => ['Ultra HD Clarity', 'High Visibility', 'UV Protection'],
                'metrics' => [
                    ['value' => '99%', 'label' => 'UV Rejection'],
                    ['value' => '72%', 'label' => 'Heat Rejection'],
                    ['value' => '90%', 'label' => 'Infrared Rejection'],
                ],
            ],
            'UP' => [
                'code' => 'UP',
                'name' => 'LEXENT Ultra Protect',
                'label' => 'Ultra Protect',
                'segment' => 'building',
                'accent' => 'accent-up',
                'warranty_years' => 8,
                'tagline' => 'Sputter Magnetron',
                'description' => 'LEXENT Ultra Protect hadir dengan teknologi Sputter Magnetron yang dirancang untuk memberikan perlindungan optimal dari panas dan sinar UV, sekaligus membantu mengurangi paparan sinar matahari dan meningkatkan kenyamanan serta privasi pada bangunan Anda.',
                'attributes' => ['Maximum Heat Protection', 'IR 99% Protection', 'Enhanced Privacy', 'High Visibility Clarity'],
                'metrics' => [
                    ['value' => '99%', 'label' => 'UV Rejection'],
                    ['value' => '99%', 'label' => 'Infrared Rejection'],
                    ['value' => '76%', 'label' => 'Heat Rejection'],
                ],
            ],
        ];
    }

    /**
     * Flat list of every VLT variant across all eight series (both divisions),
     * with the exact specification figures from the two printed catalogs
     * (VLT / VLR / TSER / UV / IRR / thickness).
     */
    private function productLineup(): array
    {
        $series = $this->seriesCatalog();

        // [ series, number, vlt, vlr, tser, uv, irr, thickness ]
        $rows = [
            // Automotive
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

            // Building
            ['BV', '05', '5%', '8%', '62%', '99%', '75%', '1,8 mil'],
            ['BV', '18', '5%', '8%', '58%', '99%', '65%', '1,8 mil'],
            ['BV', '35', '5%', '8%', '53%', '99%', '63%', '1,8 mil'],

            ['RF', '05', '5%', '8%', '55%', '90%', '92%', '2 mil'],

            ['HP', '08', '8%', '5%', '72%', '99%', '90%', '2 mil'],
            ['HP', '15', '15%', '5%', '70%', '99%', '90%', '2 mil'],
            ['HP', '35', '35%', '5%', '71%', '99%', '90%', '2 mil'],
            ['HP', '70', '70%', '5%', '71%', '99%', '90%', '2 mil'],

            ['UP', '08', '8%', '6%', '76%', '99%', '99%', '2 mil'],
            ['UP', '20', '20%', '6%', '74%', '99%', '99%', '2 mil'],
            ['UP', '30', '28%', '6%', '73%', '99%', '99%', '2 mil'],
            ['UP', '50', '47%', '6%', '73%', '99%', '99%', '2 mil'],
            ['UP', '65', '58%', '6%', '72%', '99%', '99%', '2 mil'],
            ['UP', '75', '69%', '6%', '72%', '99%', '99%', '2 mil'],
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
                'segment' => $meta['segment'],
                'number' => $number,
                'accent' => $meta['accent'],
                'badge' => $meta['attributes'][0],
                'tagline' => $meta['tagline'],
                'series_description' => $meta['description'],
                'short_description' => $meta['tagline'] . '. ' . $darkness . '.',
                'attributes' => $meta['attributes'],
                'darkness' => $darkness,
                'warranty_years' => $meta['warranty_years'],
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
     * LEXENT Paint Protection Film — an automotive-only accessory line, sold
     * alongside the window-film series rather than as a window-film variant.
     * Each type is a standalone product (no VLT sub-variants), so it carries
     * its own thickness/warranty/finish spec sheet instead of VLT/TSER/UV.
     */
    private function ppfLineup(): array
    {
        return [
            [
                'slug' => 'type-s',
                'code' => 'S',
                'name' => 'LEXENT PPF Type S',
                'label' => 'Type S',
                'accent' => 'accent-ppf-s',
                'tagline' => 'Perlindungan Solid, Perawatan Mudah',
                'description' => 'LEXENT PPF Type S melapisi cat mobil dari goresan halus, kerikil, dan noda harian, menjaga tampilan tetap solid dan mengkilap dengan perawatan yang mudah.',
                'features' => ['Exclusive Top Coat Technology', 'Excellent Impact Resistance', 'Excellent Stain Resistance and Easy Maintenance'],
                'thickness' => '8 Mil',
                'warranty_years' => 10,
                'finish' => 'Glossy',
                'attributes' => [
                    ['label' => 'TPU', 'rating' => 'Top Grade'],
                    ['label' => 'Glossy', 'rating' => 'Excellent'],
                    ['label' => 'Self-Healing', 'rating' => 'Excellent'],
                    ['label' => 'Hydrophobic', 'rating' => 'Excellent'],
                ],
            ],
            [
                'slug' => 'type-t-plus',
                'code' => 'T+',
                'name' => 'LEXENT PPF Type T Plus',
                'label' => 'Type T Plus',
                'accent' => 'accent-ppf-tp',
                'tagline' => 'Self-Healing Coating, Proteksi Ekstra',
                'description' => 'LEXENT PPF Type T Plus menghadirkan lapisan top coat self-healing yang menyamarkan baret halus secara otomatis, memberi proteksi ekstra untuk cat mobil kesayangan Anda.',
                'features' => ['Excellent Top Coat Layer', 'High Protection', 'Self-Healing Coating'],
                'thickness' => '8,5 Mil',
                'warranty_years' => 10,
                'finish' => 'Glossy',
                'attributes' => [
                    ['label' => 'TPU', 'rating' => 'High Grade'],
                    ['label' => 'Glossy', 'rating' => 'Excellent'],
                    ['label' => 'Self-Healing', 'rating' => 'Excellent'],
                    ['label' => 'Hydrophobic', 'rating' => 'Excellent'],
                ],
            ],
            [
                'slug' => 'type-l',
                'code' => 'L',
                'name' => 'LEXENT PPF Type L',
                'label' => 'Type L',
                'accent' => 'accent-ppf-l',
                'tagline' => 'Super Gloss Look, Kilau Maksimal',
                'description' => 'LEXENT PPF Type L berbasis TPU kelas atas dengan hasil akhir super glossy, memberi tampilan cat mobil yang lebih hidup sekaligus perlindungan self-healing dari goresan ringan.',
                'features' => ['High Grade TPU Based', 'Self-Healing', 'Super Gloss Look'],
                'thickness' => '8 Mil',
                'warranty_years' => 7,
                'finish' => 'Glossy',
                'attributes' => [
                    ['label' => 'TPU', 'rating' => 'High Grade'],
                    ['label' => 'Glossy', 'rating' => 'Excellent'],
                    ['label' => 'Self-Healing', 'rating' => 'Excellent'],
                    ['label' => 'Hydrophobic', 'rating' => 'Excellent'],
                ],
            ],
            [
                'slug' => 'type-l-matte',
                'code' => 'L Matte',
                'name' => 'LEXENT PPF Type L Matte',
                'label' => 'Type L Matte',
                'accent' => 'accent-ppf-lm',
                'tagline' => 'Excellent Matte Look, Tampilan Doff Premium',
                'description' => 'LEXENT PPF Type L Matte menghadirkan tampilan doff premium dengan proteksi self-healing yang sama tangguhnya, untuk pemilik mobil yang menginginkan gaya matte tanpa mengorbankan perlindungan cat.',
                'features' => ['High Grade TPU Based', 'Self-Healing', 'Excellent Matte Look'],
                'thickness' => '8 Mil',
                'warranty_years' => 7,
                'finish' => 'Matte',
                'attributes' => [
                    ['label' => 'TPU', 'rating' => 'High Grade'],
                    ['label' => 'Matte', 'rating' => 'Excellent'],
                    ['label' => 'Self-Healing', 'rating' => 'Excellent'],
                    ['label' => 'Hydrophobic', 'rating' => 'Excellent'],
                ],
            ],
        ];
    }

    /**
     * Hero: one highlight slide per division (automotive / building), each
     * drawn from that division's own catalog cover language.
     */
    private function segmentHighlights(): array
    {
        return [
            [
                'segment' => 'automotive',
                'code' => 'AUTO',
                'image' => 'images/hero/hero-01-automotive.jpg',
                'alt' => 'Teknisi memasang paint protection film pada bodi mobil',
                'tag' => 'Automotive Windowfilm',
                'headline' => 'Clarity Inside,<br><span class="highlight">Protection Outside</span>',
                'subtext' => 'Empat seri film kaca otomotif — privasi tinggi, insulasi panas, kejernihan HD, hingga bebas gangguan sinyal. UV rejection 99% di seluruh seri, garansi resmi hingga 7 tahun.',
                'cta_label' => 'Lihat Katalog Automotive',
                'metrics' => [
                    ['value' => '99%', 'label' => 'UV Rejection'],
                    ['value' => '81%', 'label' => 'Heat Rejection'],
                    ['value' => '7 Th', 'label' => 'Garansi'],
                ],
            ],
            [
                'segment' => 'building',
                'code' => 'BLD',
                'image' => 'images/hero/hero-02-building.jpg',
                'alt' => 'Fasad gedung kaca modern dilihat dari bawah',
                'tag' => 'Building Windowfilm',
                'headline' => 'Smart Film.<br><span class="highlight">Better Buildings.</span>',
                'subtext' => 'Empat seri film kaca gedung — kontrol panas, privasi, efisiensi energi, dan tampilan modern nan elegan. UV rejection hingga 99%, garansi resmi hingga 8 tahun.',
                'cta_label' => 'Lihat Katalog Building',
                'metrics' => [
                    ['value' => '99%', 'label' => 'UV Rejection'],
                    ['value' => '76%', 'label' => 'Heat Rejection'],
                    ['value' => '8 Th', 'label' => 'Garansi'],
                ],
            ],
        ];
    }

    /**
     * "Why LEXENT" — conventional film vs LEXENT, one comparison set per
     * division since the claims that matter differ (car electronics signal
     * interference vs. building energy efficiency).
     */
    private function matrixComparison(): array
    {
        return [
            'automotive' => [
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
            ],
            'building' => [
                [
                    'label' => 'Penolakan Sinar UV',
                    'conventional' => ['text' => 'Sekitar 50%, memudar seiring waktu', 'status' => 'cross'],
                    'lexent' => ['text' => 'Hingga 99% ditolak di seluruh seri', 'status' => 'check'],
                ],
                [
                    'label' => 'Penolakan Panas (TSER)',
                    'conventional' => ['text' => 'Rendah, ruangan cepat panas', 'status' => 'cross'],
                    'lexent' => ['text' => 'Hingga 76% (Ultra Protect)', 'status' => 'check'],
                ],
                [
                    'label' => 'Efisiensi Energi',
                    'conventional' => ['text' => 'Beban AC gedung tinggi', 'status' => 'cross'],
                    'lexent' => ['text' => 'Beban pendinginan berkurang signifikan', 'status' => 'check'],
                ],
                [
                    'label' => 'Privasi & Tampilan',
                    'conventional' => ['text' => 'Kaca polos, kurang privat', 'status' => 'cross'],
                    'lexent' => ['text' => 'Black Vision & Reflective — privat, modern, elegan', 'status' => 'check'],
                ],
                [
                    'label' => 'Kejernihan Pandangan',
                    'conventional' => ['text' => 'Berkabut, haze meningkat', 'status' => 'cross'],
                    'lexent' => ['text' => 'Ultra-low haze, HD clarity', 'status' => 'check'],
                ],
                [
                    'label' => 'Garansi Resmi',
                    'conventional' => ['text' => '1–2 tahun', 'status' => 'cross'],
                    'lexent' => ['text' => 'Hingga 8 tahun', 'status' => 'check'],
                ],
            ],
        ];
    }

    /**
     * LEXENT's single office address, shared by the homepage and the
     * address/location page.
     */
    private function companyAddress(): array
    {
        return [
            'name' => 'LEXENT Head Office',
            'address' => 'Ruko La Valle, Citra Garden Serpong No.66 Blk B17, Cisauk, Kec. Cisauk, Kota Tangerang Selatan, Banten 15341, Indonesia',
            'phone' => '0858-8889-9558',
            'email' => 'hello@lexent.id',
            'maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.4753655034965!2d106.63194417430039!3d-6.332406361958469!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fb4567030f6b%3A0x77e8113c85538a54!2sGLOSSPRO.ID!5e0!3m2!1sid!2sid!4v1789568261883!5m2!1sid!2sid',
            'maps_url' => 'https://maps.app.goo.gl/yvcZmGWbMYfv8YU96',
        ];
    }

    public function home()
    {
        return view('home', [
            'products' => $this->productLineup(),
            'address' => $this->companyAddress(),
            'highlights' => $this->segmentHighlights(),
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

    public function ppfIndex()
    {
        return view('ppf.index', [
            'products' => $this->ppfLineup(),
        ]);
    }

    public function ppfDetail(string $slug)
    {
        $product = collect($this->ppfLineup())->firstWhere('slug', $slug);

        abort_if(!$product, 404);

        $related = collect($this->ppfLineup())
            ->where('slug', '!=', $product['slug'])
            ->values()
            ->all();

        return view('ppf.show', [
            'product' => $product,
            'related' => $related,
        ]);
    }

    public function dealers()
    {
        return view('dealers', [
            'address' => $this->companyAddress(),
        ]);
    }

    public function cekGaransi()
    {
        return view('cek-garansi', [
            'dashboardBaseUrl' => config('services.dashboard.base_url'),
        ]);
    }
}

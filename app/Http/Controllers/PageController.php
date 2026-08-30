<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Static product lineup shared across the home, products, and detail pages.
     * Split into two segments: automotive and architectural/commercial window film.
     */
    private function productLineup(): array
    {
        return [
            [
                'slug' => 'black-phantom',
                'name' => 'Lexent Black Phantom',
                'category' => 'automotive',
                'category_label' => 'Automotive Series',
                'tagline' => 'Privasi Absolut, Karakter Tegas',
                'short_description' => 'Kaca film otomotif paling gelap di lini Lexent, dirancang untuk kendaraan eksekutif yang menuntut privasi penuh.',
                'description' => 'Lexent Black Phantom dibangun dengan Sputtering Technology multi-layer yang memantulkan radiasi inframerah sebelum menembus kabin. Hasilnya, kabin tetap sejuk sekaligus tampil dengan karakter obsidian yang tegas dan eksklusif — pilihan utama bagi kendaraan premium dan eksekutif.',
                'vlt' => '5%',
                'heat_rejection' => '97%',
                'irr' => '98%',
                'uv' => '99%',
                'badge' => 'Signature Dark',
                'accent' => 'from-obsidian',
                'features' => [
                    'Privasi kabin absolut untuk kendaraan eksekutif',
                    'Sputtering Technology multi-layer non-metal',
                    'Menahan hingga 98% radiasi infrared (IRR)',
                    'Garansi resmi Lexent hingga 10 tahun',
                ],
            ],
            [
                'slug' => 'lx-series',
                'name' => 'Lexent LX Series',
                'category' => 'automotive',
                'category_label' => 'Automotive Series',
                'tagline' => 'Keseimbangan Elegan untuk Setiap Perjalanan',
                'short_description' => 'Varian paling dicari — memadukan kejernihan visual dengan penolakan panas kelas atas.',
                'description' => 'Lexent LX Series dirancang untuk pengendara yang menginginkan tampilan premium tanpa tingkat kegelapan berlebihan. Lapisan ceramic non-metal menjaga visibilitas malam hari tetap optimal, sementara Superior Heat Rejection Layer terus bekerja menahan panas matahari sepanjang hari.',
                'vlt' => '20%',
                'heat_rejection' => '89%',
                'irr' => '94%',
                'uv' => '99%',
                'badge' => 'Best Seller',
                'accent' => 'from-gold',
                'features' => [
                    'Visibilitas malam hari tetap optimal',
                    'Penolakan panas hingga 89%',
                    'Tampilan platinum satin yang elegan',
                    'Garansi resmi Lexent hingga 8 tahun',
                ],
            ],
            [
                'slug' => 'crystal-clear',
                'name' => 'Lexent Crystal Clear',
                'category' => 'automotive',
                'category_label' => 'Automotive Series',
                'tagline' => 'Terang, Aman, Tetap Terlindungi',
                'short_description' => 'Tingkat kegelapan paling rendah, ideal untuk kendaraan keluarga dan armada niaga yang mengutamakan visibilitas.',
                'description' => 'Lexent Crystal Clear memberikan perlindungan panas dan UV maksimal tanpa mengurangi visibilitas berkendara. Dirancang khusus untuk kendaraan keluarga, armada niaga, dan kendaraan operasional yang membutuhkan pandangan jernih di segala kondisi cahaya.',
                'vlt' => '45%',
                'heat_rejection' => '82%',
                'irr' => '88%',
                'uv' => '99%',
                'badge' => 'High Visibility',
                'accent' => 'from-metallic',
                'features' => [
                    'Visibilitas terbaik siang maupun malam hari',
                    'Tetap menahan 82% panas matahari',
                    'Ideal untuk kendaraan keluarga & armada niaga',
                    'Garansi resmi Lexent hingga 5 tahun',
                ],
            ],
            [
                'slug' => 'archishield-pro',
                'name' => 'Lexent ArchiShield Pro',
                'category' => 'architectural',
                'category_label' => 'Architectural Series',
                'tagline' => 'Efisiensi Energi untuk Gedung Modern',
                'short_description' => 'Kaca film arsitektural untuk gedung perkantoran dan komersial, menekan silau dan beban pendingin ruangan.',
                'description' => 'Lexent ArchiShield Pro diformulasikan khusus untuk kaca gedung berskala besar. Lapisan reflektifnya menekan silau matahari dan panas radiasi secara signifikan, membantu efisiensi konsumsi energi AC tanpa mengorbankan pencahayaan alami ruangan.',
                'vlt' => '30%',
                'heat_rejection' => '85%',
                'irr' => '92%',
                'uv' => '99%',
                'badge' => 'Energy Efficient',
                'accent' => 'from-gold',
                'features' => [
                    'Menekan silau matahari pada kaca gedung tinggi',
                    'Membantu efisiensi konsumsi energi AC',
                    'Menahan hingga 92% radiasi infrared (IRR)',
                    'Garansi resmi Lexent hingga 12 tahun',
                ],
            ],
            [
                'slug' => 'safetyguard',
                'name' => 'Lexent SafetyGuard',
                'category' => 'architectural',
                'category_label' => 'Architectural Series',
                'tagline' => 'Lapisan Keamanan Anti-Shatter',
                'short_description' => 'Kaca film keamanan untuk gedung dan hunian, menahan pecahan kaca akibat benturan atau bencana.',
                'description' => 'Lexent SafetyGuard menggunakan lapisan polyester berkekuatan tinggi yang mengikat pecahan kaca saat terjadi benturan, gempa, atau upaya pembobolan. Solusi ideal untuk gedung komersial, fasilitas publik, dan hunian yang mengutamakan keamanan struktural.',
                'vlt' => '60%',
                'heat_rejection' => '70%',
                'irr' => '80%',
                'uv' => '99%',
                'badge' => 'Anti-Shatter',
                'accent' => 'from-metallic',
                'features' => [
                    'Menahan pecahan kaca akibat benturan/gempa',
                    'Lapisan polyester keamanan berkekuatan tinggi',
                    'Cocok untuk gedung komersial & fasilitas publik',
                    'Garansi resmi Lexent hingga 10 tahun',
                ],
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
            'products' => $this->productLineup(),
            'dealers' => $this->dealerList(),
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function products()
    {
        return view('products.index', [
            'products' => $this->productLineup(),
        ]);
    }

    public function productDetail(string $slug)
    {
        $product = collect($this->productLineup())->firstWhere('slug', $slug);

        abort_if(!$product, 404);

        return view('products.show', [
            'product' => $product,
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

{{-- Promo band + benefits row under the catalog grids. Expects $kind: building | automotive | ppf | all --}}
@php
    $extras = [
        'building' => [
            'promo' => [
                'title' => 'Solusi Perlindungan untuk Bangunan Anda',
                'text' => 'Tingkatkan kenyamanan dan efisiensi energi dengan kaca film berkualitas premium dari LEXENT.',
                'image' => 'images/hero/building-glass.jpg',
                'points' => [
                    ['sun', 'Tahan Panas Maksimal'],
                    ['shield', 'Proteksi UV Tinggi'],
                    ['eye-off', 'Privasi Lebih Baik'],
                    ['bolt', 'Hemat Energi'],
                ],
            ],
            'benefits_title' => 'Keunggulan Kaca Film Bangunan LEXENT',
            'benefits' => [
                ['thermometer', 'Menolak Panas dengan Optimal'],
                ['diamond', 'Kejernihan Pandang Maksimal'],
                ['shield-check', 'Melindungi Interior dari UV'],
                ['leaf', 'Mendukung Efisiensi Energi'],
            ],
        ],
        'automotive' => [
            'promo' => [
                'title' => 'Solusi Kaca Film Mobil untuk Performa Terbaik',
                'text' => 'Nikmati pengalaman berkendara yang lebih nyaman dan aman dengan LEXENT.',
                'image' => 'images/hero/car-porsche.jpg',
                'points' => [
                    ['thermometer', 'Reduksi Panas Maksimal'],
                    ['sun', 'Kurangi Silau'],
                    ['eye-off', 'Privasi Lebih Baik'],
                    ['sparkles', 'Tampilan Lebih Elegan'],
                ],
            ],
            'benefits_title' => 'Keunggulan Kaca Film Mobil LEXENT',
            'benefits' => [
                ['thermometer', 'Kabin Lebih Sejuk'],
                ['shield-check', 'Proteksi UV hingga 99%'],
                ['eye', 'Visibilitas Jernih'],
                ['diamond', 'Garansi Resmi'],
            ],
        ],
        'ppf' => [
            'promo' => [
                'title' => 'Perlindungan Maksimal untuk Nilai Kendaraan Anda',
                'text' => 'Investasikan perlindungan terbaik untuk kendaraan kesayangan Anda bersama LEXENT.',
                'image' => 'images/hero/ppf-peel.jpg',
                'points' => [],
            ],
            'benefits_title' => 'Keunggulan Paint Protection Film LEXENT',
            'benefits' => [
                ['refresh', 'Self-Healing Technology'],
                ['sun', 'Anti Yellowing'],
                ['sparkles', 'Gloss Retention'],
                ['droplet', 'Stain Resistance'],
                ['edit', 'Scratch Protection'],
            ],
        ],
    ];
    $extra = $extras[$kind] ?? null;
    $vltTiles = [70 => 0.12, 50 => 0.34, 35 => 0.55, 20 => 0.76];
@endphp

@if($extra)
    @if($kind === 'automotive')
        <div class="vlt-compare">
            <h3>Perbandingan Kegelapan Kaca Film</h3>
            <div class="vlt-grid">
                @foreach($vltTiles as $vlt => $shade)
                    <div class="vlt-tile">
                        <img src="{{ asset('images/hero/car-porsche.jpg') }}" alt="" loading="lazy">
                        <div class="vlt-shade" style="opacity: {{ $shade }};"></div>
                        <span>VLT {{ $vlt }}%</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="promo-band">
        <div class="promo-band-media" aria-hidden="true">
            <img src="{{ asset($extra['promo']['image']) }}" alt="" loading="lazy">
        </div>
        <div class="promo-band-copy">
            <span class="promo-kicker">LEXENT</span>
            <h3>{{ $extra['promo']['title'] }}</h3>
            <p>{{ $extra['promo']['text'] }}</p>
            <a href="https://wa.me/6285888899558" target="_blank" rel="noopener" class="btn btn-gold btn-sm btn-arrow">Konsultasi Sekarang</a>
        </div>
        @if(!empty($extra['promo']['points']))
            <div class="promo-points">
                @foreach($extra['promo']['points'] as [$icon, $label])
                    <div class="promo-point">@include('partials.icon', ['name' => $icon]) <span>{{ $label }}</span></div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="benefits">
        <h3>{{ $extra['benefits_title'] }}</h3>
        <div class="benefits-grid">
            @foreach($extra['benefits'] as [$icon, $label])
                <div class="benefit">@include('partials.icon', ['name' => $icon]) <span>{{ $label }}</span></div>
            @endforeach
        </div>
    </div>
@endif

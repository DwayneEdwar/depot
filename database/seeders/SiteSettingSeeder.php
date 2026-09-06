<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Depot Air Minum'],
            ['key' => 'default_pricing_package', 'value' => 'standard'],
            ['key' => 'water_price_per_gallon', 'value' => '15000'],
            ['key' => 'water_price_standard', 'value' => '15000'],
            ['key' => 'water_price_subscription', 'value' => '13500'],
            ['key' => 'water_price_promo', 'value' => '12000'],
            ['key' => 'pricing_presets', 'value' => json_encode([
                ['slug' => 'standard', 'label' => 'Standar', 'price' => 15000],
                ['slug' => 'subscription', 'label' => 'Langganan', 'price' => 13500],
                ['slug' => 'promo', 'label' => 'Promo', 'price' => 12000],
            ])],
            ['key' => 'meta_description', 'value' => 'Depot Air Minum - pesan galon air isi ulang cepat dan terpercaya'],
            ['key' => 'header_cta_primary', 'value' => 'Pesan Sekarang'],
            ['key' => 'header_cta_secondary', 'value' => 'Info & Promo'],
            ['key' => 'hero_badge', 'value' => 'LAYANAN RUMAH & USAHA'],
            ['key' => 'hero_title', 'value' => 'Air minum isi ulang yang cepat, bersih, dan terpercaya.'],
            ['key' => 'hero_description', 'value' => 'Dapatkan galon air berkualitas untuk keperluan rumah, kantor, toko, dan usaha dengan proses pengiriman yang cepat dan aman.'],
            ['key' => 'hero_primary_button', 'value' => 'Pesan galon'],
            ['key' => 'hero_secondary_button', 'value' => 'Lihat pengumuman'],
            ['key' => 'stat_label_1', 'value' => 'PENGIRIMAN'],
            ['key' => 'stat_value_1', 'value' => '1–2 jam'],
            ['key' => 'stat_label_2', 'value' => 'GALON'],
            ['key' => 'stat_value_2', 'value' => '15.000'],
            ['key' => 'stat_label_3', 'value' => 'KUALITAS'],
            ['key' => 'stat_value_3', 'value' => '100%'],
            ['key' => 'hero_card_label', 'value' => 'KENYAMANAN HARIAN'],
            ['key' => 'hero_card_value', 'value' => '2.400+'],
            ['key' => 'hero_card_description', 'value' => 'Pelanggan yang sudah menikmati layanan kami.'],
            ['key' => 'feature_1_title', 'value' => 'Pengiriman cepat'],
            ['key' => 'feature_1_text', 'value' => 'Tim kami siap mengantarkan pesanan dengan jadwal yang cepat dan konsisten.'],
            ['key' => 'feature_2_title', 'value' => 'Air jernih & aman'],
            ['key' => 'feature_2_text', 'value' => 'Setiap galon diproses dengan standar kebersihan dan kualitas yang terjaga.'],
            ['key' => 'feature_3_title', 'value' => 'Langganan praktis'],
            ['key' => 'feature_3_text', 'value' => 'Nikmati pengalaman berlangganan yang lebih mudah untuk kebutuhan harian Anda.'],
            ['key' => 'footer_text', 'value' => '© 2026 Semua hak dilindungi.'],
            ['key' => 'footer_contact', 'value' => 'Hubungi kami untuk layanan terbaik'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::query()->firstOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']],
            );
        }
    }
}

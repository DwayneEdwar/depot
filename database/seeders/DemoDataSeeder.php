<?php

namespace Database\Seeders;

use App\Models\InfoPost;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        InfoPost::query()->delete();
        Order::query()->delete();

        InfoPost::factory()->create([
            'title' => 'Promo bulan ini: layanan isi ulang hemat',
            'slug' => 'promo-bulan-ini-layanan-isi-ulang-hemat',
            'content' => '<p>Diskon khusus untuk pelanggan langganan yang melakukan pesanan 3 galon atau lebih pada minggu ini.</p><ul><li>Gratis pengiriman untuk area tertentu</li><li>Prioritas jadwal hari Senin-Kamis</li></ul>',
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);

        InfoPost::factory()->create([
            'title' => 'Jam operasional baru untuk layanan antar',
            'slug' => 'jam-operasional-baru-untuk-layanan-antar',
            'content' => '<p>Mulai hari ini, layanan antar tersedia dari pukul 07.00 hingga 21.00 setiap hari.</p><p>Silakan hubungi WhatsApp kami untuk jadwal yang paling cepat.</p>',
            'is_published' => true,
            'published_at' => now()->subHours(8),
        ]);

        Order::factory()->create([
            'customer_name' => 'Rina Fitriani',
            'whatsapp_number' => '081234567890',
            'address' => 'Jl. Merdeka No. 12, Bandung',
            'gallon_quantity' => 3,
            'status' => Order::STATUS_PENDING,
            'delivery_date' => now()->addDay()->toDateString(),
            'total_price' => 45000,
        ]);

        Order::factory()->create([
            'customer_name' => 'Budi Santoso',
            'whatsapp_number' => '082345678901',
            'address' => 'Jl. Cikutra No. 5, Bandung',
            'gallon_quantity' => 5,
            'status' => Order::STATUS_DELIVERING,
            'delivery_date' => now()->addDays(2)->toDateString(),
            'total_price' => 75000,
        ]);

        Order::factory()->create([
            'customer_name' => 'Sari Dewi',
            'whatsapp_number' => '083456789012',
            'address' => 'Jl. Pasteur No. 88, Bandung',
            'gallon_quantity' => 2,
            'status' => Order::STATUS_COMPLETED,
            'delivery_date' => now()->subDay()->toDateString(),
            'total_price' => 30000,
        ]);
    }
}

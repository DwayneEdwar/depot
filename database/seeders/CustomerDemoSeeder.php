<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Seeder;

class CustomerDemoSeeder extends Seeder
{
    public function run(): void
    {
        Customer::query()->delete();
        Order::query()->delete();

        $names = [
            'Rina Fitriani', 'Budi Santoso', 'Sari Dewi', 'Andi Pratama', 'Dewi Lestari',
            'Hendra Wijaya', 'Maya Sari', 'Arif Rahman', 'Nina Kusuma', 'Yusuf Hidayat',
            'Teguh Ramadhan', 'Eka Susanti', 'Wahyu Prasetyo', 'Dina Ayu', 'Rizki Maulana',
            'Sri Wulandari', 'Agus Setiawan', 'Lina Marlina', 'Fajar Nugroho', 'Putri Handayani',
            'Bayu Saputra', 'Nanda Permata', 'M. Faisal', 'Citra Ningrum', 'Joko Widodo',
            'Sinta Kartika', 'Iqbal Ramadhan', 'Diana Putri', 'Asep Kurnia', 'Rani Indah',
            'Rahmat Hidayat', 'Ayu Lestari', 'Gilang Pratama', 'Nurul Aisyah', 'Farhan Maulana',
            'Mira Anggraini', 'Dedy Kurniawan', 'Rizka Amelia', 'Bagas Prakoso', 'Intan Permatasari',
            'Kiki Amalia', 'Ilham Santoso', 'Novi Wati', 'Hafiz Ardiansyah', 'Aldo Firmansyah',
            'Suci Ramadani', 'Syahrul Anwar', 'Candra Wijaya', 'Gita Puspita', 'Lukman Hakim', 'Rika Maharani',
        ];

        $statuses = [
            Order::STATUS_PENDING,
            Order::STATUS_DELIVERING,
            Order::STATUS_COMPLETED,
            Order::STATUS_CANCELLED,
        ];

        foreach ($names as $index => $name) {
            $customer = Customer::factory()->create([
                'name' => $name,
                'whatsapp_number' => '08'.str_pad((string) (1000000000 + $index), 11, '0', STR_PAD_LEFT),
                'address' => 'Jl. '.($index + 1).' No. '.($index + 10).', Bandung',
                'is_active' => true,
            ]);

            $orderCount = rand(1, 6);
            $totalGallon = 0;
            $totalPurchase = 0;

            for ($i = 0; $i < $orderCount; $i++) {
                $quantity = rand(1, 8);
                $status = $i === 0 ? Order::STATUS_COMPLETED : $statuses[array_rand($statuses)];

                $order = Order::factory()->create([
                    'customer_id' => $customer->id,
                    'customer_name' => $customer->name,
                    'whatsapp_number' => $customer->whatsapp_number,
                    'address' => $customer->address,
                    'gallon_quantity' => $quantity,
                    'status' => $status,
                    'delivery_date' => now()->subDays(rand(1, 30))->toDateString(),
                    'total_price' => $quantity * 15000,
                ]);

                if ($order->status === Order::STATUS_COMPLETED) {
                    $totalGallon += $order->gallon_quantity;
                    $totalPurchase += $order->total_price;
                }
            }

            $customer->order_count = $customer->orders()->where('status', Order::STATUS_COMPLETED)->count();
            $customer->total_gallon = (int) $customer->orders()->where('status', Order::STATUS_COMPLETED)->sum('gallon_quantity');
            $customer->total_purchase = (float) $customer->orders()->where('status', Order::STATUS_COMPLETED)->sum('total_price');
            $customer->points = max(0, (int) floor($customer->total_purchase / 10000) + (int) floor($customer->total_gallon / 2));
            $customer->save();
        }
    }
}

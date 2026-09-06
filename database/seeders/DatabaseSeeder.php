<?php

namespace Database\Seeders;

use App\Models\InfoPost;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Depot',
            'email' => 'admin@example.com',
        ]);

        $this->call(SiteSettingSeeder::class);

        InfoPost::factory()->count(4)->create();

        Order::factory()->count(8)->create();

        $this->call(CustomerDemoSeeder::class);
        $this->call(DemoDataSeeder::class);
    }
}

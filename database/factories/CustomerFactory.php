<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        $isActive = $this->faker->boolean(85);

        return [
            'name' => $this->faker->name(),
            'whatsapp_number' => $this->faker->numerify('08##########'),
            'address' => $this->faker->address(),
            'notes' => $this->faker->randomElement([
                'Pelanggan rutin',
                'Order mingguan',
                'Pelanggan baru',
                'Sudah langganan',
                'Order berdasarkan kebutuhan',
            ]),
            'is_active' => $isActive,
            'order_count' => 0,
            'points' => 0,
            'total_gallon' => 0,
            'total_purchase' => 0,
        ];
    }
}

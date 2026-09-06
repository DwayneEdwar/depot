<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 8);
        $unitPrice = 15000;

        return [
            'customer_name' => $this->faker->name(),
            'whatsapp_number' => $this->faker->numerify('08##########'),
            'address' => $this->faker->address(),
            'gallon_quantity' => $quantity,
            'status' => $this->faker->randomElement([
                Order::STATUS_PENDING,
                Order::STATUS_DELIVERING,
                Order::STATUS_COMPLETED,
                Order::STATUS_CANCELLED,
            ]),
            'delivery_date' => $this->faker->dateTimeBetween('now', '+7 days')->format('Y-m-d'),
            'total_price' => $quantity * $unitPrice,
        ];
    }
}

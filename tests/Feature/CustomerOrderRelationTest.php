<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerOrderRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_order_can_be_linked_to_a_customer(): void
    {
        $customer = Customer::create([
            'name' => 'Budi',
            'whatsapp_number' => '081234567890',
            'address' => 'Jl. Merdeka No. 1',
            'notes' => 'Pelanggan tetap',
            'is_active' => true,
        ]);

        $order = Order::create([
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'whatsapp_number' => $customer->whatsapp_number,
            'address' => $customer->address,
            'gallon_quantity' => 2,
            'delivery_date' => now()->addDay()->toDateString(),
            'status' => Order::STATUS_PENDING,
            'total_price' => 30000,
        ]);

        $this->assertEquals($customer->id, $order->customer_id);
        $this->assertTrue($order->customer()->exists());
        $this->assertEquals($customer->name, $order->customer->name);
        $this->assertTrue($customer->orders()->whereKey($order->id)->exists());
    }

    public function test_completed_orders_auto_update_customer_stats(): void
    {
        $order = Order::create([
            'customer_name' => 'Sari',
            'whatsapp_number' => '081111111111',
            'address' => 'Jl. Mawar No. 7',
            'gallon_quantity' => 3,
            'delivery_date' => now()->addDay()->toDateString(),
            'status' => Order::STATUS_PENDING,
            'total_price' => 45000,
        ]);

        $order->update([
            'status' => Order::STATUS_COMPLETED,
        ]);

        $customer = Customer::query()->where('whatsapp_number', '081111111111')->firstOrFail();

        $this->assertEquals(1, $customer->order_count);
        $this->assertEquals(5, $customer->points);
        $this->assertEquals($customer->id, $order->fresh()->customer_id);
    }
}

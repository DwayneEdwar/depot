<?php

namespace Tests\Feature;

use App\Models\FinancialRecord;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderCompletionCreatesFinancialRecordTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_an_income_record_when_an_order_is_marked_completed(): void
    {
        $order = Order::create([
            'customer_name' => 'Budi',
            'whatsapp_number' => '081234567890',
            'address' => 'Jl. Mawar No. 10',
            'gallon_quantity' => 2,
            'status' => Order::STATUS_PENDING,
            'delivery_date' => now()->addDay()->toDateString(),
            'total_price' => 30000,
        ]);

        $order->update([
            'status' => Order::STATUS_COMPLETED,
        ]);

        $this->assertDatabaseHas('financial_records', [
            'type' => FinancialRecord::TYPE_INCOME,
            'category' => 'Water Sale',
            'amount' => 30000,
            'description' => 'Penerimaan order #'.$order->id,
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public const STATUS_PENDING = 'pending';
    public const STATUS_DELIVERING = 'delivering';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'customer_id',
        'customer_name',
        'whatsapp_number',
        'address',
        'gallon_quantity',
        'status',
        'delivery_date',
        'total_price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'gallon_quantity' => 'integer',
        'delivery_date' => 'date',
        'total_price' => 'decimal:2',
        'status' => 'string',
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => self::STATUS_PENDING,
        'total_price' => 0,
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected static function booted(): void
    {
        static::updated(function (self $order): void {
            if ($order->status !== self::STATUS_COMPLETED) {
                return;
            }

            $customer = self::resolveCustomer($order);
            $order->customer_id = $customer->id;
            $order->customer_name = $customer->name;
            $order->whatsapp_number = $customer->whatsapp_number;
            $order->address = $customer->address;
            $order->saveQuietly();

            $customer->refreshStats();

            $existingRecord = FinancialRecord::query()
                ->where('category', 'Water Sale')
                ->where('description', 'Penerimaan order #'.$order->getKey())
                ->where('type', FinancialRecord::TYPE_INCOME)
                ->exists();

            if ($existingRecord) {
                return;
            }

            FinancialRecord::create([
                'type' => FinancialRecord::TYPE_INCOME,
                'category' => 'Water Sale',
                'amount' => $order->total_price,
                'description' => 'Penerimaan order #'.$order->getKey(),
                'transaction_date' => now()->toDateString(),
            ]);
        });
    }

    protected static function resolveCustomer(self $order): Customer
    {
        $phoneNumber = preg_replace('/\D+/', '', (string) ($order->whatsapp_number ?? ''));

        $customer = Customer::query()
            ->when(filled($phoneNumber), function ($query) use ($phoneNumber) {
                $query->where('whatsapp_number', $phoneNumber)
                    ->orWhere('whatsapp_number', '0'.$phoneNumber);
            })
            ->when(blank($phoneNumber), function ($query) use ($order) {
                $query->where('name', $order->customer_name ?? '');
            })
            ->first();

        if ($customer) {
            $customer->name = $order->customer_name ?: $customer->name;
            $customer->whatsapp_number = filled($phoneNumber) ? $phoneNumber : ($customer->whatsapp_number ?? '');
            $customer->address = $order->address ?: $customer->address;
            $customer->is_active = true;
            $customer->save();

            return $customer;
        }

        return Customer::create([
            'name' => $order->customer_name ?? 'Pelanggan Baru',
            'whatsapp_number' => $phoneNumber ?: null,
            'address' => $order->address ?? null,
            'notes' => 'Terbuat otomatis dari pesanan selesai',
            'is_active' => true,
            'order_count' => 0,
            'points' => 0,
            'total_gallon' => 0,
            'total_purchase' => 0,
        ]);
    }
}

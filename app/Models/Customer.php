<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'whatsapp_number',
        'address',
        'notes',
        'is_active',
        'order_count',
        'points',
        'total_gallon',
        'total_purchase',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_count' => 'integer',
        'points' => 'integer',
        'total_gallon' => 'integer',
        'total_purchase' => 'decimal:2',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function refreshStats(): void
    {
        $completedOrders = $this->orders()
            ->where('status', Order::STATUS_COMPLETED)
            ->get();

        $this->order_count = $completedOrders->count();
        $this->total_gallon = (int) $completedOrders->sum('gallon_quantity');
        $this->total_purchase = (float) $completedOrders->sum('total_price');
        $this->points = max(0, (int) floor($this->total_purchase / 10000) + (int) floor($this->total_gallon / 2));

        $this->saveQuietly();
    }

    public function getLoyalStatusAttribute(): string
    {
        return $this->points >= 5 ? 'Loyal' : 'Baru';
    }
}

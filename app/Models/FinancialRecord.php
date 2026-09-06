<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialRecord extends Model
{
    public const TYPE_INCOME = 'income';
    public const TYPE_EXPENSE = 'expense';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'category',
        'amount',
        'description',
        'transaction_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => 'string',
        'category' => 'string',
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'type' => self::TYPE_INCOME,
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    protected static function settingsTableExists(): bool
    {
        return Schema::hasTable((new static)->getTable());
    }

    public static function value(string $key, mixed $default = null): mixed
    {
        if (! static::settingsTableExists()) {
            return $default;
        }

        return static::query()->where('key', $key)->value('value') ?? $default;
    }

    public static function pricingPresets(): array
    {
        $raw = static::value('pricing_presets', null);

        if (blank($raw)) {
            $standard = (int) static::value('water_price_standard', static::value('water_price_per_gallon', 15000));
            $subscription = (int) static::value('water_price_subscription', $standard);
            $promo = (int) static::value('water_price_promo', $standard);

            return [
                ['slug' => 'standard', 'label' => 'Standar', 'price' => $standard],
                ['slug' => 'subscription', 'label' => 'Langganan', 'price' => $subscription],
                ['slug' => 'promo', 'label' => 'Promo', 'price' => $promo],
            ];
        }

        $decoded = json_decode((string) $raw, true);

        if (! is_array($decoded) || empty($decoded)) {
            $standard = (int) static::value('water_price_standard', static::value('water_price_per_gallon', 15000));
            $subscription = (int) static::value('water_price_subscription', $standard);
            $promo = (int) static::value('water_price_promo', $standard);

            return [
                ['slug' => 'standard', 'label' => 'Standar', 'price' => $standard],
                ['slug' => 'subscription', 'label' => 'Langganan', 'price' => $subscription],
                ['slug' => 'promo', 'label' => 'Promo', 'price' => $promo],
            ];
        }

        return array_values($decoded);
    }
}

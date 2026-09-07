<?php

namespace Tests\Feature;

use App\Livewire\PublicOrderForm;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SiteSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_frontend_reads_custom_site_settings(): void
    {
        SiteSetting::create([
            'key' => 'site_name',
            'value' => 'Depot Air Minum Premium',
        ]);

        SiteSetting::create([
            'key' => 'hero_title',
            'value' => 'Air minum premium untuk rumah dan usaha',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('Depot Air Minum Premium')
            ->assertSee('Air minum premium untuk rumah dan usaha');
    }

    public function test_public_order_form_uses_manual_numeric_input_for_gallon_quantity(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('inputmode="numeric"', false)
            ->assertSee('pattern="[0-9]*"', false);
    }

    public function test_zero_gallon_quantity_is_clamped_to_one(): void
    {
        Livewire::test(PublicOrderForm::class)
            ->set('gallonQuantity', 0)
            ->assertSet('gallonQuantity', 1)
            ->assertSet('totalPrice', 15000);
    }

    public function test_blank_gallon_quantity_does_not_crash_and_stays_blank(): void
    {
        Livewire::test(PublicOrderForm::class)
            ->set('gallonQuantity', '')
            ->assertSet('gallonQuantity', null)
            ->assertSet('totalPrice', 15000);
    }

    public function test_order_price_uses_admin_configured_per_gallon_price(): void
    {
        SiteSetting::create([
            'key' => 'water_price_per_gallon',
            'value' => '18000',
        ]);

        Livewire::test(PublicOrderForm::class)
            ->assertSet('unitPrice', 18000)
            ->assertSet('totalPrice', 18000)
            ->set('gallonQuantity', 3)
            ->assertSet('totalPrice', 54000);
    }

    public function test_order_price_can_switch_by_package(): void
    {
        SiteSetting::create([
            'key' => 'water_price_standard',
            'value' => '15000',
        ]);
        SiteSetting::create([
            'key' => 'water_price_subscription',
            'value' => '13000',
        ]);
        SiteSetting::create([
            'key' => 'water_price_promo',
            'value' => '12000',
        ]);

        Livewire::test(PublicOrderForm::class)
            ->set('selectedPackage', 'subscription')
            ->assertSet('unitPrice', 13000)
            ->set('gallonQuantity', 2)
            ->assertSet('totalPrice', 26000)
            ->set('selectedPackage', 'promo')
            ->assertSet('unitPrice', 12000)
            ->assertSet('totalPrice', 24000);
    }

    public function test_order_price_uses_preset_json_from_admin(): void
    {
        SiteSetting::create([
            'key' => 'default_pricing_package',
            'value' => 'promo',
        ]);

        SiteSetting::create([
            'key' => 'pricing_presets',
            'value' => json_encode([
                ['slug' => 'standard', 'label' => 'Standar', 'price' => 15000],
                ['slug' => 'subscription', 'label' => 'Langganan', 'price' => 13000],
                ['slug' => 'promo', 'label' => 'Promo', 'price' => 12000],
            ], JSON_THROW_ON_ERROR),
        ]);

        Livewire::test(PublicOrderForm::class)
            ->assertSet('selectedPackage', 'promo')
            ->assertSet('unitPrice', 12000)
            ->set('gallonQuantity', 2)
            ->assertSet('totalPrice', 24000);
    }
}

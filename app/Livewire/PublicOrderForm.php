<?php

namespace App\Livewire;

use App\Models\InfoPost;
use App\Models\Order;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.app')]
class PublicOrderForm extends Component
{
    #[Rule('required|string|min:3|max:255')]
    public string $customerName = '';

    #[Rule('required|string|min:10|max:20')]
    public string $whatsappNumber = '';

    #[Rule('required|string|min:10')]
    public string $address = '';

    #[Rule('required|integer|min:1|max:100')]
    public int $gallonQuantity = 1;

    #[Rule('required|date')]
    public string $deliveryDate = '';

    public string $selectedPackage = 'standard';

    public int $unitPrice = 15000;

    public int $totalPrice = 15000;

    public array $pricingPresets = [];

    public function mount(): void
    {
        $this->pricingPresets = \App\Models\SiteSetting::pricingPresets();
        $this->selectedPackage = (string) \App\Models\SiteSetting::value('default_pricing_package', $this->pricingPresets[0]['slug'] ?? 'standard');

        $this->deliveryDate = now()->addDay()->toDateString();
        $this->recalculatePrice();
    }

    public bool $isSubmitted = false;

    public function updatedGallonQuantity(): void
    {
        $this->recalculatePrice();
    }

    public function updatedSelectedPackage(): void
    {
        $this->recalculatePrice();
    }

    public function recalculatePrice(): void
    {
        $preset = collect(\App\Models\SiteSetting::pricingPresets())
            ->firstWhere('slug', $this->selectedPackage);

        $legacyPrice = (int) \App\Models\SiteSetting::value('water_price_' . $this->selectedPackage, (int) \App\Models\SiteSetting::value('water_price_per_gallon', 15000));
        $this->unitPrice = (int) ($preset['price'] ?? $legacyPrice);

        if (blank($preset) && \App\Models\SiteSetting::value('water_price_per_gallon', null) !== null && ! \App\Models\SiteSetting::value('pricing_presets', null)) {
            $this->unitPrice = (int) \App\Models\SiteSetting::value('water_price_per_gallon', 15000);
        }

        $this->totalPrice = $this->gallonQuantity * $this->unitPrice;
    }

    public function submit(): void
    {
        $validated = $this->validate();

        Order::create([
            'customer_name' => $validated['customerName'],
            'whatsapp_number' => $validated['whatsappNumber'],
            'address' => $validated['address'],
            'gallon_quantity' => $validated['gallonQuantity'],
            'delivery_date' => $validated['deliveryDate'],
            'status' => Order::STATUS_PENDING,
            'total_price' => $this->gallonQuantity * $this->unitPrice,
        ]);

        $this->reset(['customerName', 'whatsappNumber', 'address', 'gallonQuantity', 'deliveryDate']);
        $this->gallonQuantity = 1;
        $this->deliveryDate = now()->addDay()->toDateString();
        $this->recalculatePrice();
        $this->isSubmitted = true;
    }

    public function render()
    {
        $posts = [];

        if (Schema::hasTable('info_posts')) {
            $posts = InfoPost::query()
                ->where('is_published', true)
                ->where(function ($query) {
                    $query->whereNull('published_at')
                        ->orWhere('published_at', '<=', now());
                })
                ->orderByDesc('published_at')
                ->latest()
                ->get();
        }

        return view('livewire.public-order-form', [
            'posts' => $posts,
        ]);
    }
}

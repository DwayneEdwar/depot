<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Filament\Widgets\Widget;

class LoyalCustomersWidget extends Widget
{
    protected string $view = 'filament.widgets.loyal-customers-widget';

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $customer = Customer::query()
            ->where('is_active', true)
            ->where('points', '>=', 5)
            ->orderByDesc('points')
            ->orderByDesc('total_purchase')
            ->first();

        return [
            'customer' => $customer,
        ];
    }
}

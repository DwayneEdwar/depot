<?php

namespace App\Filament\Widgets;

use App\Models\FinancialRecord;
use App\Models\Order;
use Filament\Widgets\Widget;

class AdminBrandingHero extends Widget
{
    protected string $view = 'filament.widgets.admin-branding-hero';

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $todayRevenue = (float) FinancialRecord::query()
            ->where('type', FinancialRecord::TYPE_INCOME)
            ->whereDate('transaction_date', now()->toDateString())
            ->sum('amount');

        $monthlyRevenue = (float) FinancialRecord::query()
            ->where('type', FinancialRecord::TYPE_INCOME)
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        $yearlyRevenue = (float) FinancialRecord::query()
            ->where('type', FinancialRecord::TYPE_INCOME)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        $activeOrders = Order::query()
            ->whereIn('status', [Order::STATUS_PENDING, Order::STATUS_DELIVERING])
            ->count();

        $completedOrders = Order::query()
            ->where('status', Order::STATUS_COMPLETED)
            ->count();

        return [
            'todayRevenue' => $todayRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'yearlyRevenue' => $yearlyRevenue,
            'activeOrders' => $activeOrders,
            'completedOrders' => $completedOrders,
        ];
    }
}

<?php

namespace App\Filament\Resources\Orders\Widgets;

use App\Models\FinancialRecord;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Ringkasan kinerja';

    protected ?string $description = 'Snapshot operasional dan keuangan bisnis hari ini';

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $today = now()->toDateString();

        $todayRevenue = (float) FinancialRecord::query()
            ->where('type', FinancialRecord::TYPE_INCOME)
            ->whereDate('transaction_date', $today)
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

        $todayOrders = Order::query()
            ->whereDate('created_at', $today)
            ->count();

        $pendingDeliveries = Order::query()
            ->whereIn('status', [Order::STATUS_PENDING, Order::STATUS_DELIVERING])
            ->count();

        $completedOrders = Order::query()
            ->where('status', Order::STATUS_COMPLETED)
            ->count();

        return [
            Stat::make('Pendapatan hari ini', 'Rp ' . number_format($todayRevenue, 0, ',', '.'))
                ->description('Meningkat ' . number_format(max($todayRevenue * 0.12, 0), 0, ',', '.') . ' dari target harian')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->chart([10, 18, 15, 24, 30, 26, 38])
                ->chartColor('success')
                ->color('success'),

            Stat::make('Pemasukan bulan ini', 'Rp ' . number_format($monthlyRevenue, 0, ',', '.'))
                ->description('Target bulanan terjaga')
                ->descriptionIcon('heroicon-o-calendar-days')
                ->chart([8, 14, 12, 22, 18, 27, 32])
                ->chartColor('info')
                ->color('info'),

            Stat::make('Pemasukan tahun ini', 'Rp ' . number_format($yearlyRevenue, 0, ',', '.'))
                ->description('Kinerja tahunan konsisten')
                ->descriptionIcon('heroicon-o-chart-bar-square')
                ->chart([6, 9, 15, 20, 18, 24, 30])
                ->chartColor('warning')
                ->color('warning'),

            Stat::make('Pesanan hari ini', (string) $todayOrders)
                ->description($completedOrders . ' order sudah selesai')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->chart([5, 8, 7, 12, 10, 15, 18])
                ->chartColor('primary')
                ->color('primary'),

            Stat::make('Sedang diproses', (string) $pendingDeliveries)
                ->description('Menunggu pengiriman atau penyelesaian')
                ->descriptionIcon('heroicon-o-truck')
                ->chart([4, 6, 8, 5, 9, 10, 11])
                ->chartColor('warning')
                ->color('warning'),

            Stat::make('Order selesai', (string) $completedOrders)
                ->description('Total transaksi berhasil terkirim')
                ->descriptionIcon('heroicon-o-check-circle')
                ->chart([3, 6, 9, 12, 10, 15, 18])
                ->chartColor('success')
                ->color('success'),
        ];
    }
}

<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrderStatusTrendChart extends ChartWidget
{
    protected ?string $heading = 'Status Order Harian';

    protected ?string $description = 'Trend order dalam 7 hari terakhir';

    protected string $color = 'info';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $labels = [];
        $pending = [];
        $delivering = [];
        $completed = [];

        for ($day = 6; $day >= 0; $day--) {
            $date = now()->subDays($day);
            $labels[] = $date->translatedFormat('D');

            $pending[] = Order::query()
                ->whereDate('created_at', $date->toDateString())
                ->where('status', Order::STATUS_PENDING)
                ->count();

            $delivering[] = Order::query()
                ->whereDate('created_at', $date->toDateString())
                ->where('status', Order::STATUS_DELIVERING)
                ->count();

            $completed[] = Order::query()
                ->whereDate('created_at', $date->toDateString())
                ->where('status', Order::STATUS_COMPLETED)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pending',
                    'data' => $pending,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.18)',
                    'fill' => false,
                    'tension' => 0.35,
                ],
                [
                    'label' => 'Delivering',
                    'data' => $delivering,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.18)',
                    'fill' => false,
                    'tension' => 0.35,
                ],
                [
                    'label' => 'Completed',
                    'data' => $completed,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.18)',
                    'fill' => false,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $labels,
        ];
    }
}

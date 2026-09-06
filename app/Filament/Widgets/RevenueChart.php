<?php

namespace App\Filament\Widgets;

use App\Models\FinancialRecord;
use Carbon\CarbonInterface;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected ?string $heading = 'Revenue Trend';

    protected ?string $description = 'Pemasukan 7 hari terakhir';

    protected string $color = 'success';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $labels = [];
        $values = [];

        for ($day = 6; $day >= 0; $day--) {
            $date = now()->subDays($day);
            $labels[] = $date->translatedFormat('D');

            $values[] = (float) FinancialRecord::query()
                ->where('type', FinancialRecord::TYPE_INCOME)
                ->whereDate('transaction_date', $date->toDateString())
                ->sum('amount');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $values,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.12)',
                    'fill' => true,
                    'tension' => 0.35,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }
}

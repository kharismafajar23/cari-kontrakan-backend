<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Contracts\Support\Htmlable;

class MonthlyTransactionChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Transaksi Bulan ini';

    protected function getData(): array
    {

        $data = Trend::model(Transaction::class)
            ->between(start: now()->startOfMonth(), end: now()->endOfMonth())->perDay()->count();

        return [
            'datasets' => [
                [
                    'label' => 'Transaksi per hari',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getDescription(): string
    {
        return 'Jumlah transaksi per bulan';
    }
}

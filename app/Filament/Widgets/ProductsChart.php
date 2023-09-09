<?php

namespace App\Filament\Widgets;

use App\Models\{
    Product,
};
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

// pa make:filament-widget ProductsChart --chart

class ProductsChart extends ChartWidget {

    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 3;

    protected function getData(): array {

        $data = $this->getProductsPerMonth();

        return [
            'datasets' => [
                [
                    'label' => 'Products created',
                    'data' => $data['productsPerMonth'],
                ],
            ],
            'labels' => $data['months'],
        ];
    }

    protected function getType(): string {
        return 'line'; // aqui se puede cambiar el tipo de chart
    }

    private function getProductsPerMonth(): array {
        $now = Carbon::now();

        $productsPerMonth = [];
        $months = Collect(range(start: 1, end: 12))->map(function ($month) use ($now, $productsPerMonth) {
                    $count = Product::whereMonth('created_at', Carbon::parse($now->month($month)->format('Y-m')))->count();
                    $productsPerMonth[] = $count;

                    return $now->month($month)->format(format: 'M');
                })->toArray();

        return [
            'productsPerMonth' => $productsPerMonth,
            'months' => $months,
        ];
    }
}

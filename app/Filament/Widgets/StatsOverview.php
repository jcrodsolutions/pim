<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatusEnum;
use App\Models\{
    Customer,
    Order,
    Product,
};
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

// pa make:filament-widget StatsOverview --stats-overview

class StatsOverview extends BaseWidget {

    protected static ?string $pollingInterval = '15s'; // null to disable
    protected static bool $isLazy = true; //false to disable
    protected static ?int $sort =2;

    protected function getStats(): array {
        return [
                    Stat::make(label: 'Total Customers', value: Customer::count())
                    ->description(description: 'Increase in customers')
                    ->descriptionIcon(icon: 'heroicon-m-arrow-trending-up')
                    ->color(color: 'success')
                    ->chart([7, 3, 4, 5, 6, 3, 5, 3]) // random numbers as example
            ,
                    Stat::make(label: 'Total Products', value: Product::count())
                    ->description(description: 'Total Products in app')
                    ->descriptionIcon(icon: 'heroicon-m-arrow-trending-down')
                    ->color(color: 'danger')
                    ->chart([7, 3, 4, 5, 6, 3, 5, 3]) // random numbers as example
            ,
                    Stat::make(label: 'Pending Orders', value: Order::where('status', OrderStatusEnum::PENDING->value)->count())
                    ->description(description: 'Orders not yet processed')
                    ->descriptionIcon(icon: 'heroicon-m-arrow-trending-down')
                    ->color(color: 'danger')
                    ->chart([7, 3, 4, 5, 6, 3, 5, 3]) // random numbers as example
                ,
        ];
    }
}

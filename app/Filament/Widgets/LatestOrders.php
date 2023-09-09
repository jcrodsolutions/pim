<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Columns\{
    TextColumn,
};
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\Resources\OrderResource;

// pa make:filament-widget LatestOrders --table

class LatestOrders extends BaseWidget {

    protected static ?int $sort = 4;

    public function table(Table $table): Table {
        return $table
                        ->query(
                                OrderResource::getEloquentQuery()
                        )->defaultPaginationPageOption(option: 5)
                        ->defaultSort(column: 'created_at', direction: 'desc')
                        ->columns([
                            TextColumn::make('numer')
                            ->searchable()
                            ->sortable()
                            ,
                            TextColumn::make('customer.name')
                            ->searchable()
                            ->sortable()
                            ->toggleable()
                            ,
                            TextColumn::make('status')
                            ->searchable()
                            ->sortable()
                            ,
                            TextColumn::make('total_price')
                            ->searchable()
                            ->sortable()
                            ->summarize([
                                Tables\Columns\Summarizers\Sum::make()
                                ->money()
                            ])
                            ,
                            TextColumn::make('created_at')
                            ->label('Order Date')
                            ->date()
                            ->searchable()
                            ->sortable()
                                ,
        ]);
    }
}

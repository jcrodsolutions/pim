<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatusEnum;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\{
    Order,
    Product,
};
use Filament\Forms;
use Filament\Forms\Components\{
    MarkdownEditor,
    Placeholder,
    Repeater,
    Select,
    TextInput,
    Wizard,
    Wizard\Step,
};
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\{
    TextColumn,
};
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource {

    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Shop';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string {
        return static::getModel()::where('status', 'processing')->count();
    }

    public static function getNavigationBadgeColor(): ?string {
        return static::getModel()::where('status', 'processing')->count() > 10 ? 'warning' : 'primary'
        ;
    }

    public static function form(Form $form): Form {
        return $form
                        ->schema([
                            Wizard::make([
                                Step::make(label: 'Order Details')->schema([
                                    TextInput::make('order')
                                    ->default(state: 'OR-' . random_int(100000, 999999))
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ,
                                    Select::make(name: 'customer_id')
                                    ->relationship(name: 'customer', titleAttribute: 'name')
                                    ->searchable()
                                    ->required()
                                    ,
                                    TextInput::make(name: 'shipping_price')
                                    ->label(label: 'Shipping Costs')
                                    ->dehydrated()
                                    ->numeric()
                                    ->required()
                                    ,
                                    Select::make(name: 'status')
                                    ->options([
                                        'pending' => OrderStatusEnum::PENDING->value,
                                        'processing' => OrderStatusEnum::PROCESSING->value,
                                        'completed' => OrderStatusEnum::COMPLETED->value,
                                        'declined' => OrderStatusEnum::DECLINED->value,
                                    ])
                                    ->required()
                                    ,
                                    MarkdownEditor::make(name: 'notes')
                                    ->columnSpanFull()
                                        ,
                                ])->columns(columns: 2),
                                Step::make(label: 'Order Items')->schema([
                                    Repeater::make('items')
                                    ->relationship()
                                    ->schema([
                                        Select::make('product_id')
                                        ->label('Product')
                                        ->options(Product::query()->pluck('name', 'id'))
                                        ->required()
                                        ->reactive()
                                        ->afterStateUpdated(fn($state, Set $set) =>
                                                $set('unit_price', Product::find($state)->price ?? 0))
                                        ,
                                        TextInput::make('quantity')
                                        ->numeric()
                                        ->default(1)
                                        ->live()
                                        ->dehydrated()
                                        ->required()
                                        ,
                                        TextInput::make('unit_price')
                                        ->label('Unit Price')
                                        ->numeric()
                                        ->step(0.01)
                                        ->disabled()
                                        ->dehydrated()
                                        ->required()
                                        ,
                                        Placeholder::make(name: 'total_price')
                                        ->label('Total Price')
                                        ->content(function ($get) {
                                            return $get('quantity') * $get('unit_price');
                                        })
                                    ])->columns(4),
                                ]),
                            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table {
        return $table
                        ->columns([
                            TextColumn::make('order')
                            ->label('Order Number')
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
                        ])
                        ->filters([
                                //
                        ])
                        ->actions([
                            Tables\Actions\ActionGroup::make([
                                Tables\Actions\ViewAction::make(),
                                Tables\Actions\EditAction::make(),
                                Tables\Actions\DeleteAction::make(),
                            ]),
                        ])
                        ->bulkActions([
                            Tables\Actions\BulkActionGroup::make([
                                \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make(), // composer require pxlrbt/filament-excel
                                Tables\Actions\DeleteBulkAction::make(),
                            ]),
                        ])
                        ->emptyStateActions([
                            Tables\Actions\CreateAction::make(),
        ]);
    }

    public static function getRelations(): array {
        return [
                //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}

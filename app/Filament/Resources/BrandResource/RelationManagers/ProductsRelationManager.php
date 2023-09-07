<?php

namespace App\Filament\Resources\BrandResource\RelationManagers;

use App\Enums\ProductTypeEnum;
use Filament\Forms;
use Filament\Forms\Components\{
    DatePicker,
    FileUpload,
    MarkdownEditor,
    Select,
    Tabs,
    Tabs\Tab,
    TextInput,
    Toggle,
};
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\{
    ImageColumn,
    TextColumn,
    ToggleColumn,
};
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Str;

class ProductsRelationManager extends RelationManager {

    protected static string $relationship = 'products';

    public function form(Form $form): Form {
        return $form
                        ->schema([
                            Tabs::make(label: 'Products')->tabs([
                                Tab::make(label: 'Information')->schema([
                                    TextInput::make('slug')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(ignoreRecord: true)
                                    ,
                                    TextInput::make('name')
                                    ->maxLength(60)
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                        if ($operation != 'create') {
                                            return;
                                        }
                                        $set('slug', Str::slug($state));
                                    })
                                    ,
                                    MarkdownEditor::make('description')
                                    ->columnSpan('full')
                                        ,
                                ])->columns(2),
                                Tab::make(label: 'Pricing & Inventory')->schema([
                                    TextInput::make('sku')
                                    ->maxLength(20)
                                    ->label('SKU (Stock Keeping Unit)')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ,
                                    TextInput::make('price')
                                    ->numeric()
                                    ->step(0.01)
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required()
                                    ,
                                    TextInput::make('quantity')
                                    ->numeric()
                                    ->step(0.01)
//                                    ->rules(['integer', 'min:0'])
                                    ->minValue(0)
//                                    ->maxValue(10000)
                                    ,
                                    Select::make('type')
                                    ->options([
                                        'downloadable' => ProductTypeEnum::DOWNLOADABLE->value,
                                        'deliverable' => ProductTypeEnum::DELIVERABLE->value,
                                    ]),
                                ])->columns(2),
                                Tab::make(label: 'Additional Information')->schema([
                                    Toggle::make('is_visible')
                                    ->label('Visibility')
                                    ->helperText('Enable/Disable Product Visibility')
                                    ->default(true)
                                    ,
                                    Toggle::make('is_featured')
                                    ->label('Featured')
                                    ->helperText('Enable/Disable Featured Status for the product')
                                    ,
                                    DatePicker::make('published_at')
                                    ->label('Available from')
                                    ->default(now())
                                    ->columnSpan('full')
                                    ,
                                    // brand_id no es necesario porque ya estoy en el brand asi que asume el valor
                                    Select::make(name: 'categories')
                                    ->relationship(name: 'categories', titleAttribute: 'name')
                                    ->multiple()
                                    ->required()
                                    ,
                                    FileUpload::make('image')
                                    ->directory(directory: 'form-attachments')
                                    ->preserveFilenames()
                                    ->image()
                                    ->imageEditor()
                                    ->columnSpanFull()
                                        ,
                                ])->columns(2),
                            ])->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table {
        return $table
                        ->recordTitleAttribute('name')
                        ->columns([
                            ImageColumn::make('image'),
                            TextColumn::make('name')
                            ->searchable()
                            ->sortable()
                            ,
                            TextColumn::make('brand.name')
                            ->sortable()
                            ->toggleable()
                            ,
                            TextColumn::make('quantity'),
                            TextColumn::make('price')
                            ->sortable()
                            ->toggleable()
                            ,
                            ToggleColumn::make('is_visible'),
//                IconColumn::make('is_visible')->boolean(),
                            TextColumn::make('published_at')
                            ->date('Y-m-d')
                            ->sortable()
                            ,
                            TextColumn::make('type')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                        'downloadable' => 'success',
                                        'deliverable' => 'info'
                                    })
                                ,
                        ])
                        ->filters([
                                //
                        ])
                        ->headerActions([
                            Tables\Actions\CreateAction::make(),
                        ])
                        ->actions([
                            Tables\Actions\ActionGroup::make([
                                Tables\Actions\DeleteAction::make(),
                                Tables\Actions\EditAction::make(),
                                Tables\Actions\ViewAction::make(),
                            ]),
                        ])
                        ->bulkActions([
                            Tables\Actions\BulkActionGroup::make([
                                Tables\Actions\DeleteBulkAction::make(),
                            ]),
                        ])
                        ->emptyStateActions([
                            Tables\Actions\CreateAction::make(),
        ]);
    }
}

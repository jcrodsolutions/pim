<?php

namespace App\Filament\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductTypeEnum;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\{
    DatePicker,
    FileUpload,
    Group,
    MarkdownEditor,
    Section,
    Select,
    TextInput,
    Toggle,
};
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\{
    IconColumn,
    ImageColumn,
    TextColumn,
    ToggleColumn,
};
use Filament\Tables\Filters\{
    TernaryFilter,
    SelectFilter,
};
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Str;

class ProductResource extends Resource {

    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Shop';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'name'; // this should be an actual column name that exists in the model

    public static function getGloballySearchableAttributes(): array {
        return ['name', 'slug', 'description']; //relationships can be used with dot(.) notation but its use is not recommended
    }

    public static function getGlobalSearchResultDetails(Model $record): array {
        return [
            'Brand' => $record->brand->name,
//            'Description' => $record->description,
        ];
        
        // voy por 07:09 de  https://www.youtube.com/watch?v=rOeV7PhLJxs
    }

    public static function form(Form $form): Form {
        return $form
                        ->schema([
                            Group::make()->schema([
                                Section::make()->schema([
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
                                ])
                                ->columns(2)
                                ,
                                Section::make(heading: 'Pricing & Inventory')->schema([
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
                                ])
                                ->columns(2)
                                    ,
                            ]),
                            Group::make()->schema([
                                Section::make(heading: 'Status')->schema([
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
                                ])
                                ->columns(2)
                                ,
                                Section::make(heading: 'Image')->schema([
                                    FileUpload::make('image')
                                    ->directory(directory: 'form-attachments')
                                    ->preserveFilenames()
                                    ->image()
                                    ->imageEditor()
                                        ,
                                ])
                                ->collapsible()
                                ,
                                Section::make(heading: 'Associations')->schema([
                                    Select::make('brand_id')
                                    ->relationship(name: 'brand', titleAttribute: 'name')
                                        ,
                                ]),
                            ]),
        ]);
    }

    public static function table(Table $table): Table {
        return $table
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
                            TernaryFilter::make('is_visible')
                            ->label('Visibility')
                            ->boolean()
                            ->trueLabel('Only Visible Products')
                            ->falseLabel('Only Hidden Products')
                            ->native(condition: false)
                            ,
                            SelectFilter::make('brand_id')
                            ->relationship(name: 'brand', titleAttribute: 'name')
                                ,
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

    public static function getRelations(): array {
        return [
                //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

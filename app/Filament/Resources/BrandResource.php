<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Filament\Resources\BrandResource\RelationManagers;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Components\{
    ColorPicker,
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
    ColorColumn,
    IconColumn,
    TextColumn,
    ToggleColumn,
};
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Str;

class BrandResource extends Resource {

    protected static ?string $model = Brand::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Shop';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form {
        return $form
                        ->schema([
                            Group::make()->schema([
                                Section::make()
                                ->schema([
                                    TextInput::make('name')
                                    ->maxLength(50)
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
                                    TextInput::make('slug')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(ignoreRecord: true)
                                    ,
                                    TextInput::make('url')
                                    ->rules(['url'])
                                    ->columnSpan('full')
                                    ,
                                    ColorPicker::make('primary_hex')
                                    ->columnSpan('full')
                                    ->label('Primary color')
                                        ,
                                ])
                                ->columns(2)
                                    ,
                            ]),
                            Group::make()->schema([
                                Section::make()
                                ->schema([
                                    Toggle::make('is_visible')
                                    ->label('Visibility')
                                    ->helperText('Enable or disable brand visibility')
                                    ,
                                    MarkdownEditor::make('description')
                                    ->columnSpan('full')
                                        ,
                                ])
                                ->columns(2)
                                    ,
                            ]),
        ]);
    }

    public static function table(Table $table): Table {
        return $table
                        ->columns([
                            TextColumn::make('name')
                            ->searchable()
                            ->sortable()
                            ,
                            TextColumn::make('slug'),
                            TextColumn::make('url')
                            ->label('Website URL')
                            ->searchable()
                            ->sortable()
                            ,
                            ColorColumn::make('primary_hex')
                            ->label('Primary color')
                            ,
                            IconColumn::make('is_visible')
                            ->sortable()
                            ->boolean()
                                ,
                        ])
                        ->filters([
                                //
                        ])
                        ->actions([
                            Tables\Actions\ActionGroup::make([
                                Tables\Actions\DeleteAction::make(),
                                Tables\Actions\EditAction::make(),
                                Tables\Actions\ViewAction::make(),
                            ]),
                                ]
//                                , position: Tables\Enums\ActionsPosition::BeforeColumns,
                        )
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
            RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}

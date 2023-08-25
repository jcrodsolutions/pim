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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\{
    IconColumn,
    TextColumn,
    ToggleColumn,
};
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BrandResource extends Resource {

    protected static ?string $model = Brand::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form {
        return $form
                        ->schema([
                            Group::make()->schema([
                                Section::make()
                                ->schema([
                                    TextInput::make('name')
                                    ->maxLength(50)
                                    ->required()
                                    ,
                                    TextInput::make('slug')
                                    ->required()
                                    ,
                                    TextInput::make('url')
                                    ->columnSpan('full')
                                        ,
                                    ColorPicker::make('primary_hex')
                                    ->columnSpan('full')
                                        ,
                                ])
                                ->columns(2)
                                    ,
                            ]),
                            Group::make()->schema([
                                Section::make()
                                ->schema([
                                    Toggle::make('is_visible'),
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
                            TextColumn::make('name'),
                            TextColumn::make('slug'),
                            TextColumn::make('url'),
                            TextColumn::make('primary_hex'),
                            IconColumn::make('is_visible')->boolean(),
                        ])
                        ->filters([
                                //
                        ])
                        ->actions([
                            Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{
    TextInput,
};
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{
    TextColumn,
};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SkusRelationManager extends RelationManager {

    protected static string $relationship = 'skus';

    public function form(Form $form): Form {
        return $form
                        ->schema([
                            TextInput::make('material')
                            ->disabled()
                            ->columnspan(2)
                            ,
                            TextInput::make('sku')
                            ->maxlength(13)
                            ->required()
                                ,
        ]);
    }

    public function table(Table $table): Table {
        return $table
                        ->recordTitleAttribute('material')
                        ->columns([
                            TextColumn::make('material'),
                            TextColumn::make('sku'),
                            TextColumn::make('um'),
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
        ]);
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\{
//    DatePicker,
//    FileUpload,
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
//    IconColumn,
//    ImageColumn,
    TextColumn,
    ToggleColumn,
};
//use Filament\Tables\Filters\{
//    TernaryFilter,
//    SelectFilter,
//};
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Str;

class CategoryResource extends Resource {

    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form {
        return $form
                        ->schema([
                            Group::make()->schema([
                                Section::make(heading: 'Main')->schema([
                                    TextInput::make('name')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->maxlength(50)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                        $set('slug', Str::slug($state));
                                    })
                                    ,
                                    TextInput::make('slug')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(ignoreRecord: true)
                                    ,
                                    MarkdownEditor::make('description')
                                    ->columnSpan('full')
                                        ,
                                ])->columns(2),
                            ])
                            ,
                            Group::make()->schema([
                                Section::make(heading: 'Features')->schema([
                                    Toggle::make('is_visible')
                                    ->label('Visibility')
                                    ->default(true)
                                        ,
                                ]),
                                Section::make(heading: 'Associations')->schema([
                                    Select::make('parent_id')
                                    ->relationship(name: 'parent', titleAttribute: 'name')
                                        ,
                                ]),
                            ]),
        ]);
    }

    public static function table(Table $table): Table {
        return $table
                        ->columns([
                            TextColumn::make('name')->searchable(),
                            TextColumn::make('slug'),
                            TextColumn::make('parent.name'),
                            ToggleColumn::make('is_visible')
                            ->label('Visibility')
                                ,
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

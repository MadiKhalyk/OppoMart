<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource

{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $pluralLabel = 'Товары';

    protected static ?string $label = 'Товар';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Продукт')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->label('Название'),
                        Forms\Components\TextInput::make('price')
                            ->label('Цена')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('old_price')
                            ->label('Старая цена')
                            ->numeric(),
                        Forms\Components\FileUpload::make('poster')
                            ->label('Фото')
                            ->image()
                            ->disk('public')
                            ->directory(now()->format('Y/m/d')),
                        Forms\Components\Select::make('category_id')
                            ->label('Категория')
                            ->relationship('category', 'title')
                            ->preload()
                            ->required(),
                        Forms\Components\Toggle::make('active')
                            ->label('Показать')
                            ->default(true)
                        ,
                    ])->columns()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->label('Название'),
                TextColumn::make('price')
                    ->label('Цена'),
                TextColumn::make('old_price')
                    ->label('Старая цена'),
                TextColumn::make('category.title')
                    ->label('Категория')
                    ->sortable(),
                ImageColumn::make('poster')
                    ->label('Фото')
                    ->getStateUsing(function ($record) {
                        return url('storage/' . $record->poster);
                    }),
                TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

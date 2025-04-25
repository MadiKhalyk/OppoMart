<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComboDiscountResource\Pages;
use App\Models\ComboDiscount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ComboDiscountResource extends Resource
{
    protected static ?string $model = ComboDiscount::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $pluralLabel = 'Комбо-скидки';

    protected static ?string $label = 'Комбо-скидка';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('Название'),
                RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->label('Цена')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('old_price')
                    ->label('Старая цена')
                    ->numeric(),
                Forms\Components\FileUpload::make('images')
                    ->label('Фото')
                    ->multiple() // Разрешаем загружать несколько фото
                    ->image()
                    ->disk('public')
                    ->directory('discounts/' . now()->format('Y/m/d'))
                    ->visibility('public')
                    ->afterStateHydrated(function ($record, $set) {
                        if ($record) {
                            $set('images', $record->images->pluck('poster')->toArray());
                        }
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->label('Название'),
                TextColumn::make('description')
                    ->label('Текст'),
                TextColumn::make('price')
                    ->label('Цена'),
                TextColumn::make('old_price')
                    ->label('Старая цена'),
                ImageColumn::make('images.poster')
                    ->label('Фото')
                    ->disk('public')
                    ->getStateUsing(fn($record) => $record->images->first()?->poster ? asset('storage/' . $record->images->first()->poster) : null)
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
            'index' => Pages\ListComboDiscounts::route('/'),
            'create' => Pages\CreateComboDiscount::route('/create'),
            'edit' => Pages\EditComboDiscount::route('/{record}/edit'),
        ];
    }
}

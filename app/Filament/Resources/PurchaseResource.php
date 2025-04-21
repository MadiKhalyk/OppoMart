<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Filament\Resources\PurchaseResource\RelationManagers;
use App\Models\Purchase;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Carbon;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $pluralLabel = 'Покупки';

    protected static ?string $label = 'Покупки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('status', 'desc')
            ->columns([
                TextColumn::make('user.phone')
                    ->label('Телефон'),
                TextColumn::make('products')
                    ->label('Продукты')
                    ->formatStateUsing(function ($state) {
                        return $state->map(function ($item) {
                            $product = $item->product;
                            $price = $item->price;
                            $quantity = $item->quantity;
                            $totalPrice = $price * $quantity;
                            $priceFormat = number_format($item->price, 0, '.', ' ');
                            $quantityFormat = number_format($quantity, 0, '.', ' ');
                            $unit = $product?->unit?->name ?? '';
                            return "{$product->title}: {$priceFormat} x {$quantityFormat} {$unit} = {$totalPrice}";
                        })
                        ->implode(", ");
                    })
                    ->wrap(),
                TextColumn::make('total_price')
                    ->label('Итого'),
                TextColumn::make('address')
                    ->label('Адрес'),
                IconColumn::make('status')
                    ->label('Статус')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Дата заказа')
                    ->formatStateUsing(fn ($state): string => Carbon::parse($state)->format('d.m.Y H:i')),
            ])
            ->filters([
                //
            ])
            ->actions([
//                EditAction::make(),
            ])
            ->bulkActions([
//                DeleteBulkAction::make(),
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
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Enum\PurchaseStatus;
use App\Filament\Resources\PurchaseResource\Pages;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables;
use App\Filament\Resources\PurchaseResource\RelationManagers;
use App\Models\Purchase;

use Filament\Resources\Resource;

use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $pluralLabel = 'Покупки';

    protected static ?string $label = 'Покупки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status')
                    ->label('Статус')
                    ->options([
                        PurchaseStatus::NEW->value => 'Новые заказы',
                        PurchaseStatus::SHIPPED->value => 'Отправленные',
                        PurchaseStatus::DELIVERED->value => 'Доставленные',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                    ->label('Адрес')
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label('Дата заказа')
                    ->formatStateUsing(fn ($state): string => Carbon::parse($state)->format('d.m.Y H:i')),
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
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Enum\PurchaseStatus;
use App\Filament\Resources\PurchaseResource;
use Filament\Resources\Components\Tab;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchases extends ListRecords
{
    protected static string $resource = PurchaseResource::class;

    protected function getActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            Tab::make('Новые заказы')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', PurchaseStatus::CONFIRMED->value);
                }),
            Tab::make('Отправленные')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', PurchaseStatus::SHIPPED->value);
                }),
            Tab::make('Доставленные')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', PurchaseStatus::DELIVERED->value);
                }),
        ];
    }
}

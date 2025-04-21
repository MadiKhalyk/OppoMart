<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use Filament\Forms\Components\Tabs\Tab;
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
            Tab::make('Активные')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', true);
                }),
            Tab::make('Неактивные')
                ->icon('heroicon-o-trash')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', false);
                }),
        ];
    }
}

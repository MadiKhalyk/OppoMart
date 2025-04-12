<?php

namespace App\Filament\Resources\ComboDiscountResource\Pages;

use App\Filament\Resources\ComboDiscountResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComboDiscounts extends ListRecords
{
    protected static string $resource = ComboDiscountResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\ComboDiscountResource\Pages;

use App\Filament\Resources\ComboDiscountResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComboDiscount extends EditRecord
{
    protected static string $resource = ComboDiscountResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\ComboDiscountResource\Pages;

use App\Filament\Resources\ComboDiscountResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateComboDiscount extends CreateRecord
{
    protected static string $resource = ComboDiscountResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $images = $data['images'] ?? [];
        unset($data['images']);

        $object = parent::handleRecordCreation($data);
        $object->images()->createMany(
            array_map(fn($name) => ['poster' => $name], $images)
        );

        return $object;
    }
}

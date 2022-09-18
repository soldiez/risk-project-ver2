<?php

namespace App\Filament\Resources\Risk\HazardCategoryResource\Pages;

use App\Filament\Resources\Risk\HazardCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageHazardCategories extends ManageRecords
{
    protected static string $resource = HazardCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

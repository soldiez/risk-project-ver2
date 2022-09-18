<?php

namespace App\Filament\Resources\Risk\InjuredBodyPartResource\Pages;

use App\Filament\Resources\Risk\InjuredBodyPartResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageInjuredBodyParts extends ManageRecords
{
    protected static string $resource = InjuredBodyPartResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

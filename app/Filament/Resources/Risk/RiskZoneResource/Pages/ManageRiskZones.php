<?php

namespace App\Filament\Resources\Risk\RiskZoneResource\Pages;

use App\Filament\Resources\Risk\RiskZoneResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRiskZones extends ManageRecords
{
    protected static string $resource = RiskZoneResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


}

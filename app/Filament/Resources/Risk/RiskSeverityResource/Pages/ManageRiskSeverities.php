<?php

namespace App\Filament\Resources\Risk\RiskSeverityResource\Pages;

use App\Filament\Resources\Risk\RiskSeverityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRiskSeverities extends ManageRecords
{
    protected static string $resource = RiskSeverityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

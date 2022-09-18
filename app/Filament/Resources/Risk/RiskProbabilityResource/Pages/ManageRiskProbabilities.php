<?php

namespace App\Filament\Resources\Risk\RiskProbabilityResource\Pages;

use App\Filament\Resources\Risk\RiskProbabilityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRiskProbabilities extends ManageRecords
{
    protected static string $resource = RiskProbabilityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

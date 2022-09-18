<?php

namespace App\Filament\Resources\Risk\RiskFrequencyResource\Pages;

use App\Filament\Resources\Risk\RiskFrequencyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRiskFrequencies extends ManageRecords
{
    protected static string $resource = RiskFrequencyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\Risk\RiskMethodResource\Pages;

use App\Filament\Resources\Risk\RiskMethodResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiskMethods extends ListRecords
{
    protected static string $resource = RiskMethodResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\Risk\RiskMethodResource\Pages;

use App\Filament\Resources\Risk\RiskMethodResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiskMethod extends EditRecord
{
    protected static string $resource = RiskMethodResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

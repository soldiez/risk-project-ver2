<?php

namespace App\Filament\Resources\TerritoryResource\Pages;

use App\Filament\Resources\TerritoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTerritory extends CreateRecord
{
    protected static string $resource = TerritoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}



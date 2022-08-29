<?php

namespace App\Filament\Resources\TerritoryResource\Pages;

use App\Filament\Resources\TerritoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTerritory extends EditRecord
{
    protected static string $resource = TerritoryResource::class;


    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

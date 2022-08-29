<?php

namespace App\Filament\Resources\TerritoryResource\Pages;

use App\Filament\Resources\TerritoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListTerritories extends ListRecords
{
    protected static string $resource = TerritoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('id', '!=', 1);
    }
}

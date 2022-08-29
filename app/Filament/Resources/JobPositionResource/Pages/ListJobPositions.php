<?php

namespace App\Filament\Resources\JobPositionResource\Pages;

use App\Filament\Resources\JobPositionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListJobPositions extends ListRecords
{
    protected static string $resource = JobPositionResource::class;

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

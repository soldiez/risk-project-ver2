<?php

namespace App\Filament\Resources\Risk\RiskResource\Pages;

use App\Filament\Resources\Risk\RiskResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\Layout;

class ListRisks extends ListRecords
{
    protected static string $resource = RiskResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
//    protected function getTableFiltersLayout(): ?string
//    {
//        return Layout::Popover;
//    }

    protected function getTableFiltersFormColumns(): int
    {
        return 2;
    }
}

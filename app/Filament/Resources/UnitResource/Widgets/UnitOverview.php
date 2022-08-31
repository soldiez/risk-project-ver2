<?php

namespace App\Filament\Resources\UnitResource\Widgets;

use App\Models\Unit\Territory;
use App\Models\Unit\Unit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;


class UnitOverview extends BaseWidget
{
    public ?Model $record = null;

    protected function getCards(): array
    {
//        dd($this);
        return [
            Card::make('Territories', $this->record->territories->count()),
            Card::make('Departments', $this->record->departments->count()),
            Card::make('Job Positions', $this->record->Positions->count()),
            Card::make('Workers', $this->record->workers->count()),
        ];
    }
}

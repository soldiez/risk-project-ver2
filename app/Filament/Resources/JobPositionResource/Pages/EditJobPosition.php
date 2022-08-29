<?php

namespace App\Filament\Resources\JobPositionResource\Pages;

use App\Filament\Resources\JobPositionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobPosition extends EditRecord
{
    protected static string $resource = JobPositionResource::class;

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

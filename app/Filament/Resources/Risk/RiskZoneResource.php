<?php

namespace App\Filament\Resources\Risk;

use App\Filament\Resources\Risk\RiskZoneResource\Pages;
use App\Filament\Resources\Risk\RiskZoneResource\RelationManagers;
use App\Models\Risk\RiskZone;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RiskZoneResource extends Resource
{
    protected static ?string $model = RiskZone::class;
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Select::make('riskMethod.name'),
                TextInput::make('name')
                ->required(),
                TextInput::make('value'),
                Forms\Components\ColorPicker::make('color'),
                TextInput::make('info')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRiskZones::route('/'),
        ];
    }
}

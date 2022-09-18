<?php

namespace App\Filament\Resources\Risk;

use App\Filament\Resources\Risk\RiskProbabilityResource\Pages;
use App\Filament\Resources\Risk\RiskProbabilityResource\RelationManagers;
use App\Models\Risk\RiskProbability;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RiskProbabilityResource extends Resource
{
    protected static ?string $model = RiskProbability::class;
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('riskMethod')
                    ->relationship('riskMethod', 'name')
                    ->label(__('Risk Method')),
                Forms\Components\TextInput::make('name')
                    ->label(__('Name')),
                Forms\Components\TextInput::make('value')
                    ->label(__('Value')),
                Forms\Components\Textarea::make('info')
                    ->label(__('Information')),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('riskMethod.name')
                    ->label(__('Risk method'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label(__('Value'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('info')
                    ->label(__('Information')),
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
            'index' => Pages\ManageRiskProbabilities::route('/'),
        ];
    }
}

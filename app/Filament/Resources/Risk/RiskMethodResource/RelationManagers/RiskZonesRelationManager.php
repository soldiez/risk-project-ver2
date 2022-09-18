<?php

namespace App\Filament\Resources\Risk\RiskMethodResource\RelationManagers;

use App\Models\Risk\RiskMethod;
use App\Models\Risk\RiskZone;
use Filament\Forms;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Contracts\HasRelationshipTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RiskZonesRelationManager extends RelationManager
{
    protected static string $relationship = 'riskZones';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->helperText(__('Name of Risk'))
                    ->required()
                ->columnSpan(2),
                TextInput::make('value')
                    ->label(__('Value'))
                    ->helperText(__('Integer'))
                    ->numeric()
                    ->visible(fn ($livewire) => $livewire->ownerRecord->is_risk_calculated)
                    ->columnSpan(1),
                Forms\Components\ColorPicker::make('colour')
                    ->label(__('Color'))
                    ->helperText(__('Color of risk'))
                    ->columnSpan(1),//TODO validations
                TextInput::make('info')
                    ->label(__('Description'))
                    ->helperText(__('Description of risk'))
                    ->columnSpan(8),
                Forms\Components\Repeater::make('zones')
                    ->label(__('Zones on matrix'))

                    ->visible(fn ($livewire) => !$livewire->ownerRecord->is_risk_calculated)
                    ->schema([
                        Select::make('risk_severity_id')
                            ->label(__('Severity'))
                            ->options(function ($livewire) {
                                if ($livewire !== null) { return RiskMethod::find($livewire->ownerRecord->id)->riskSeverities->pluck('name', 'id');}
                            })
                            ->required()
                        ,
                        MultiSelect::make('risk_probability_id')
                            ->label(__('Probability'))
                            ->options(function ($livewire) {
                                if ($livewire !== null) { return RiskMethod::find($livewire->ownerRecord->id)->riskProbabilities->pluck('name', 'id');}
                            })
                            ->required()
                        ,
                    ])->columns(2)
                    ->columnSpan(12)
                    ->cloneable()
                    ->orderable()
                    ->hiddenOn('edit'),
                Forms\Components\Fieldset::make('zone')
                    ->label(__('Zone on matrix'))
                    ->schema([
                        Select::make('risk_severity_id')
                            ->label(__('Severity'))
                            ->options(function ($livewire) {
                                if ($livewire !== null) { return RiskMethod::find($livewire->ownerRecord->id)->riskSeverities->pluck('name', 'id');}
                            })
                            ->required()
                        ,
                        Select::make('risk_probability_id')
                            ->label(__('Probability'))
                            ->options(function ($livewire) {
                                if ($livewire !== null) { return RiskMethod::find($livewire->ownerRecord->id)->riskProbabilities->pluck('name', 'id');}
                            })
                            ->required()
                    ])
                    ->visibleOn('edit')
                    ->hidden(fn ($livewire) => $livewire->ownerRecord->is_risk_calculated)
            ])
            ->columns(12);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label(__('Name'))
                ->sortable()
                ->searchable()
                ,
                Tables\Columns\TextColumn::make('value')
                    ->label(__('Value'))
                    ->sortable()
                    ->visible(fn ($livewire) => $livewire->ownerRecord->is_risk_calculated)
                ,
                Tables\Columns\TextColumn::make('colour')
                    ->label(__('Color'))
                    ->extraAttributes(function ($record) {
//                        dd('bg-['. $record->colour . ']');
                       return  ['class' => 'bg-['. $record->colour . ']']; //TODO Vite do not work - do not update colour in background - do not wor npm run dev?

                    }),
                Tables\Columns\TextColumn::make('info')
                    ->label(__('Description')),
                Tables\Columns\TextColumn::make('riskSeverity.name')
                    ->label(__('Severity'))
                    ->sortable()
                    ->hidden(fn ($livewire) => $livewire->ownerRecord->is_risk_calculated),
                Tables\Columns\TextColumn::make('riskProbability.name')
                    ->label(__('Probability'))
                    ->sortable()
                    ->hidden(fn ($livewire) => $livewire->ownerRecord->is_risk_calculated),
                Tables\Columns\TextColumn::make('riskFrequency.name')
                    ->label(__('Frequency'))
                    ->sortable()
                    ->visible(fn ($livewire) => $livewire->ownerRecord->is_risk_calculated & $livewire->ownerRecord->is_risk_frequency)
            ])
            ->filters([

                Tables\Filters\SelectFilter::make('riskSeverity')
                    ->relationship('riskSeverity', 'name',
                        fn (Builder $query, $livewire) => $query->where('risk_method_id', $livewire->ownerRecord->id))
                    ->hidden(fn ($livewire) => $livewire->ownerRecord->is_risk_calculated)
                    ->label(__('Severity')),
                Tables\Filters\SelectFilter::make('riskProbability')
                    ->relationship('riskProbability', 'name',
                        fn (Builder $query, $livewire) => $query->where('risk_method_id', $livewire->ownerRecord->id))
                    ->hidden(fn ($livewire) => $livewire->ownerRecord->is_risk_calculated)
                    ->label(__('Probability')),
                Tables\Filters\SelectFilter::make('riskFrequency')
                    ->relationship('riskFrequency', 'name',
                        fn (Builder $query, $livewire) => $query->where('risk_method_id', $livewire->ownerRecord->id))
                    ->label(__('Frequency'))
                    ->visible(fn ($livewire) => $livewire->ownerRecord->is_risk_calculated & $livewire->ownerRecord->is_risk_frequency),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->using(function (HasRelationshipTable $livewire, array $data): Model {
                        foreach ($data['zones'] as $zone) {
                            foreach ($zone['risk_probability_id'] as $value)
                            RiskZone::create( [
                              'risk_method_id' => $livewire->ownerRecord->id,
                              'name' => $data['name'],
                              'value' => $data['value'],
                                'colour' => $data['colour'],
                                'info'=> $data['info'],
                                'risk_severity_id' => $zone['risk_severity_id'],
                                'risk_probability_id' => $value
                          ]);
                        };
                        return $livewire->getRelationship()->create($data);
                    })
                    ->after(function () {
                        // Runs after the form fields are saved to the database.
                        RiskZone::all()->last()->delete();
                    }),
//                Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
//                Tables\Actions\DissociateAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\DissociateBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}

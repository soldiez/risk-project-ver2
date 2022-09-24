<?php

namespace App\Filament\Resources\Risk;

use App\Filament\Resources\Risk\RiskMethodResource\Pages;
use App\Filament\Resources\Risk\RiskMethodResource\RelationManagers;
use App\Models\Risk\RiskMethod;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class RiskMethodResource extends Resource
{
    protected static ?string $model = RiskMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Risks management';
    protected static ?string $navigationLabel = 'Risk methods';
    protected static ?string $pluralLabel = 'Risk methods';
    protected static ?string $label = 'Risk methods';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('name')
                    ->label(__('Name'))
                    ->required(),
                Forms\Components\MultiSelect::make('units')
                    ->relationship('units', 'name')
                    ->label(__('Using in units'))
                    ->helperText(__('Unit where this Risk Method is default choice'))
                    ,
                Forms\Components\Toggle::make('is_risk_calculated')
                    ->label(__('Risk is calculating by formula - multiple elements '))
                    ->helperText(__('In this case all parameters will be multiply. In other case it will be on crossroads of parameters'))
                    ->reactive(),
                Forms\Components\Toggle::make('is_risk_frequency')
                    ->label(__('Risk Method has Risk Frequency parameters'))
                    ->helperText(__('Base parameters of risk are Probability and Severity'))
                    ->visible(fn($livewire) => $livewire->data['is_risk_calculated'])
                    ->reactive(),
                Textarea::make('info')
                    ->label(__('Description'))
                    ->rows(3),
                Forms\Components\Select::make('status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                    ])
                    ->default('Active')
                    ->label(__('Status'))
                    ->disablePlaceholderSelection(),
//                                //TODO [action, dates and others] parameters for different risks?,


                Tabs::make(__('Lists'))
                    ->tabs([
                        Tabs\Tab::make('Risk Severities')
                            ->label(__('Risk Severities'))
                            ->schema([
                                Repeater::make('riskSeverities')
                                    ->relationship()
                                    ->orderable()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label(__('Name'))
                                            ->helperText(__('Name of Risk Severity'))
                                            ->required()
                                            ->columns(2)
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('value')
                                            ->label(__('Value'))
                                            ->helperText(__('Integer'))
                                            ->numeric()
                                            ->default(1) //TODO validation messages everywhere
                                            ->visible(fn ($livewire) => $livewire->data['is_risk_calculated'])
                                            ->columns(1),
                                        Forms\Components\Textarea::make('info')
                                            ->label(__('Description'))
                                            ->helperText(__('Description of Risk Severity'))
                                            ->rows(1)
                                            ->columnSpan(9),
                                    ])
                                ->columns(12)
                                ->minItems(2)
                            ]),
                        Tabs\Tab::make(__('Risk Probabilities'))
                            ->label(__('Risk Probabilities'))
                            ->schema([
                                Repeater::make('riskProbabilities')
                                    ->relationship()
                                    ->orderable()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label(__('Name'))
                                            ->helperText(__('Name of Risk Probability'))
                                            ->required()
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('value')
                                            ->label(__('Value'))
                                            ->helperText(__('Integer'))
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1)
                                            ->visible(fn ($livewire) => $livewire->data['is_risk_calculated'])
                                            ->columns(1),
                                        Forms\Components\Textarea::make('info')
                                            ->label(__('Description'))
                                            ->helperText(__('Description of Risk Probability'))
                                            ->rows(1)
                                            ->columnSpan(9),
                                    ])
                                    ->columns(12)
                                    ->minItems(2),
                            ]),
                        Tabs\Tab::make('Risk Frequencies')
                            ->label(__('Risk Frequencies'))
                            ->schema([
                                // ...
                                Repeater::make('riskFrequencies')
                                    ->relationship()
                                    ->orderable()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label(__('Name'))
                                            ->helperText(__('Name of Risk Frequency'))
                                            ->required()
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('value')
                                            ->label(__('Value'))
                                            ->helperText(__('Integer'))
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1)
                                            ->visible(fn ($livewire) => $livewire->data['is_risk_calculated'])
                                            ->columns(1),
                                        Forms\Components\Textarea::make('info')
                                            ->label(__('Description'))
                                            ->helperText(__('Description of Risk Probability'))
                                            ->rows(1)
                                            ->columnSpan(9),
                                    ])
                                    ->columns(12)
                                    ->minItems(2),
                            ])
                            ->visible(fn ($livewire) => $livewire->data['is_risk_frequency'] & $livewire->data['is_risk_calculated']),
                        Tabs\Tab::make('Parameters')
                            ->label(__('Parameters'))
                            ->schema([
                                //TODO [action, dates and others] parameters for different risks
                            ]),
                        Tabs\Tab::make('Risk Matrix')
                            ->label(__('Risk Matrix'))
                            ->schema([
                                //TODO Risk Matrix modul for checking
                            ])
                    ])->columnSpan(2)

                ]);

//TODO action parameters for different risks,


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name')),
                Tables\Columns\TextColumn::make('info')
                    ->label(__('Description'))
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('units.name')
                    ->label('Units'),
                Tables\Columns\BooleanColumn::make('is_risk_frequency')
                    ->label(__('Has Freq.'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BooleanColumn::make('is_risk_calculated')
                    ->label(__('Calcul.'))
                    ->toggleable(),
//                Tables\Columns\TextColumn::make('parameters')
//                    ->label(__('Parameters'))
//                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->date('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated'))
                    ->date('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getRelations(): array
    {
        return [
//            RelationManagers\RiskSeveritiesRelationManager::class,
//            RelationManagers\RiskProbabilitiesRelationManager::class,
//            RelationManagers\RiskFrequenciesRelationManager::class,
            RelationManagers\RiskZonesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiskMethods::route('/'),
            'create' => Pages\CreateRiskMethod::route('/create'),
            'edit' => Pages\EditRiskMethod::route('/{record}/edit'),
        ];
    }

}

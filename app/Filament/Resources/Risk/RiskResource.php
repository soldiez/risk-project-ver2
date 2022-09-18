<?php

namespace App\Filament\Resources\Risk;

use App\Filament\Resources\Risk\RiskResource\Pages;
use App\Filament\Resources\Risk\RiskResource\RelationManagers;
use App\Models\Risk\Risk;
use App\Models\Risk\RiskFrequency;
use App\Models\Risk\RiskMethod;
use App\Models\Risk\RiskProbability;
use App\Models\Risk\RiskSeverity;
use App\Models\Risk\RiskZone;
use App\Models\Unit\Unit;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use mysql_xdevapi\Schema;

class RiskResource extends Resource
{
    protected static ?string $model = Risk::class;
    protected static ?string $navigationGroup = 'Risks management';
    protected static ?string $navigationLabel = 'Risks';
    protected static ?string $pluralLabel = 'Risks';
    protected static ?string $label = 'Risk';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-hand';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //TODO form

                Forms\Components\Fieldset::make('mainData')
                    ->label(__('Main data'))
                    ->schema([
                        Forms\Components\DateTimePicker::make('create_date_time')
                            ->label(__('Date of risk creation'))
//                            ->withoutSeconds()
                            ->maxDate(now())
                            ->default(now())
                            ->withoutTime()
                            ->columns(1),
                        Forms\Components\Select::make('unit_id')
                        ->relationship('unit', 'name')
                            ->label(__('Unit'))
                        ->columnSpan(2)
                        ->default(fn()=>auth()->user()->unit->id),
                        Forms\Components\MultiSelect::make('authors')
                            ->label(__('Authors'))
                            ->relationship('authors', 'last_name')
                        ->columnSpan(3),
                        Forms\Components\MultiSelect::make('territories')
                            ->relationship('territories', 'name')
                            ->label(__('Territories')),
                        Forms\Components\MultiSelect::make('departments')
                            ->relationship('departments', 'name')
                            ->label(__('Departments')),
                        Forms\Components\MultiSelect::make('positions')
                            ->relationship('positions', 'name')
                            ->label(__('Positions')),
                        Forms\Components\MultiSelect::make('processes')
                            ->label(__('Process'))
                            ->relationship('processes', 'name'),
                        Forms\Components\MultiSelect::make('products')
                            ->label(__('Product'))
                            ->relationship('products', 'name'),
                        Forms\Components\MultiSelect::make('services')
                            ->label(__('Service'))
                            ->relationship('services', 'name'),
                        Forms\Components\Select::make('risk_method_id')
                            ->label(__('Risk method'))
                            ->relationship('riskMethod', 'name')
                            ->reactive()
                            ->default(fn($get) => Unit::find($get('unit_id'))->defaultRiskMethod->id),
                        Forms\Components\Placeholder::make('creator_id')
                            ->label(__('Record creator'))
                            ->content(function ($set) {
                                $set('creator_id', auth()->user()->id);
                                return auth()->user()->name;})
                    ])->columns(6),


                Forms\Components\Repeater::make('risks')
                    ->label(__('Risks'))
                    ->schema([
                        Forms\Components\TextInput::make('hazard_info')
                            ->label(__('Hazard information'))
                            ->columnSpan(3),
                        Forms\Components\TextInput::make('base_risk_info')
                            ->label(__('Base Risk Information'))
                        ->columnSpan(3),

                        Forms\Components\Select::make('hazard_category_id')
                            ->label(__('Hazard category'))
                            ->relationship('hazardCategory', 'name'),

                        Forms\Components\Select::make('injured_body_part_id')
                            ->label(__('Injured body part'))
                            ->relationship('injuredBodyPart', 'name'),

                        Forms\Components\DatePicker::make('review_date')
                            ->label(__('Review date'))
                            ->withoutSeconds()
                            ->minDate(now()), //TODO Date from settings

                        Forms\Components\Select::make('auditor_id')
                            ->label(__('Controller'))
                            ->relationship('auditor', 'name'), //TODO user from group auditors

Forms\Components\Fieldset::make('Base risk')
            ->label(__('Base risk'))
            ->schema([
                Forms\Components\TextInput::make('base_preventive_action')
                    ->label(__('Base preventive action'))
                    ->columnSpan(4),

                Forms\Components\Select::make('base_severity_id')
                    ->label(__('Severity'))
                    ->relationship('baseSeverity', 'name',
                        function (Builder $query, $get) {
//                        return $query->where('risk_method_id', $livewire->data['risk_method_id']);})
                    return $query->where('risk_method_id', $get('../../risk_method_id'));})
                    ->reactive(),
                Forms\Components\Select::make('base_probability_id')
                    ->label(__('Probability'))
                    ->relationship('baseProbability', 'name',
                        fn (Builder $query, $get) => $query->where('risk_method_id', $get('../../risk_method_id')))
                    ->reactive(),
                Forms\Components\Select::make('base_frequency_id')
                    ->label(__('Frequency'))
                    ->relationship('baseFrequency', 'name',
                        fn (Builder $query, $get) => $query->where('risk_method_id', $get('../../risk_method_id')))
                    ->reactive()
                    ->visible(fn($get) => RiskMethod::find($get('../../risk_method_id'))->is_risk_frequency)
                ,
                Forms\Components\Placeholder::make('base_calc_risk')
                    ->label(__('Risk'))
                    ->content(function ($get, $set) {
                        $baseSeverityId = $get('base_severity_id');
                        $baseProbabilityId = $get('base_probability_id');
                        $baseFrequencyId = $get('base_frequency_id');
                        $riskMethod = RiskMethod::find($get('../../risk_method_id'));

                            if($riskMethod->is_risk_calculated === 0) {
                                if ($baseSeverityId && $baseProbabilityId) {
                                    $riskZone = RiskZone::where('risk_severity_id', $baseSeverityId)->where('risk_probability_id', $baseProbabilityId)->first();
                                    $set('base_calc_risk', $riskZone->id);
                                    return $riskZone->name;} //TODO color
                                }
                            if($riskMethod->is_risk_calculated === 1) {
                                if ($riskMethod->is_risk_frequency === 1 && $baseSeverityId && $baseProbabilityId && $baseFrequencyId) {
                                    $calculation = RiskSeverity::find($baseSeverityId)->value * RiskProbability::find($baseProbabilityId)->value *
                                        RiskFrequency::find($baseFrequencyId)->value;
                                    $riskZone = $riskMethod->riskZones()->where('value' , '>=', $calculation)->first();
                                    $set('base_calc_risk', $riskZone->id);
                                    return $riskZone->name;}

                                if($riskMethod->is_risk_frequency === 0 && $baseSeverityId && $baseProbabilityId) {
                                    $calculation = RiskSeverity::find($baseSeverityId)->value * RiskProbability::find($baseProbabilityId)->value;
                                    $riskZone = $riskMethod->riskZones()->where('value' , '>=', $calculation)->first();
                                    $set('base_calc_risk', $riskZone->id);
                                    return $riskZone->name;
                                } //TODO color
                                }
                        return '-';
                    })
                ,

            ])->columnSpan(3)
                        ->columns(4),

                        Forms\Components\Fieldset::make('Proposition risk')
                            ->label(__('Proposition risk'))
                            ->schema([
                                Forms\Components\TextInput::make('prop_preventive_action')
                                    ->label(__('Proposition preventive action'))
                                ->columnSpan(4),
                                Forms\Components\Select::make('prop_severity_id')
                                    ->label(__('Severity'))
                                    ->relationship('propSeverity', 'name',
                                        fn (Builder $query, $get) => $query->where('risk_method_id', $get('../../risk_method_id')))
                                    ->reactive(),
                                Forms\Components\Select::make('prop_probability_id')
                                    ->label(__('Probability'))
                                    ->relationship('propProbability', 'name',
                                        fn (Builder $query, $get) => $query->where('risk_method_id', $get('../../risk_method_id')))
                                    ->reactive(),
                                Forms\Components\Select::make('prop_frequency_id')
                                    ->label(__('Frequency'))
                                    ->relationship('propFrequency', 'name',
                                        fn (Builder $query, $get) => $query->where('risk_method_id', $get('../../risk_method_id')))
                                    ->reactive()
                                    ->visible(fn($get) => RiskMethod::find($get('../../risk_method_id'))->is_risk_frequency)
                                ,

                                Forms\Components\Placeholder::make('prop_calc_risk')
                                    ->label(__('Risk'))
                                    ->content(function ($get, $set) {
                                        $propSeverityId = $get('prop_severity_id');
                                        $propProbabilityId = $get('prop_probability_id');
                                        $propFrequencyId = $get('prop_frequency_id');
                                        $riskMethod = RiskMethod::find($get('../../risk_method_id'));

                                        if($riskMethod->is_risk_calculated === 0) {
                                            if ($propSeverityId && $propProbabilityId) {
                                                $riskZone = RiskZone::where('risk_severity_id', $propSeverityId)->where('risk_probability_id', $propProbabilityId)->first();
                                                $set('prop_calc_risk', $riskZone->id);
                                                return $riskZone->name;} //TODO color
                                        }
                                        if($riskMethod->is_risk_calculated === 1) {
                                            if ($riskMethod->is_risk_frequency === 1 && $propSeverityId && $propProbabilityId && $propFrequencyId) {
                                                $calculation = RiskSeverity::find($propSeverityId)->value * RiskProbability::find($propProbabilityId)->value *
                                                    RiskFrequency::find($propFrequencyId)->value;
                                                $riskZone = $riskMethod->riskZones()->where('value' , '>=', $calculation)->first();
                                                $set('base_calc_risk', $riskZone->id);
                                                return $riskZone->name;}

                                            if($riskMethod->is_risk_frequency === 0 && $propSeverityId && $propProbabilityId) {
                                                $calculation = RiskSeverity::find($propSeverityId)->value * RiskProbability::find($propProbabilityId)->value;
                                                $riskZone = $riskMethod->riskZones()->where('value' , '>=', $calculation)->first();
                                                $set('base_calc_risk', $riskZone->id);
                                                return $riskZone->name;
                                            } //TODO color
                                        }
                                        return '-';
                                    }),

                            ])->columnSpan(3)
                        ->columns(4),






//                Forms\Components\DatePicker::make('control_review_date')
//                    ->label(__('Reviewed date'))
//                    ->withoutSeconds(),
//
//                Forms\Components\Select::make('risk_status') //TODO risk statuses thinking
//                    ->label(__('Risk status'))
//                    ->options([
//                        'Created',
//                        'Has Actions',
//                        'Action closed',
//                        'Reviewed',
//                        'Archive',
//                    ])
                    ])->defaultItems(1)
                    ->maxItems(10)
                    ->columns(6)
                    ->columnSpan(2)
                    ->createItemButtonLabel(__('Add risk')),

               //TODO actions_id process
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //TODO tuning risk table
//                Tables\Columns\TextColumn::make('units.name')
//                    ->label(__('Units'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->sortable()
//                    ->searchable()
//                    ->toggleable()
//                    ->wrap(),
//                Tables\Columns\TextColumn::make('territories.name')
//                    ->label(__('Territories'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->sortable()
//                    ->searchable()
//                    ->toggleable()
//                    ->wrap(),
//                Tables\Columns\TextColumn::make('dep/pos')
//                    ->label(__('Depart./Positions'))
//                    ->formatStateUsing(function ($record) {
//                        $departments = $record->departments->implode('name', ', ');
//                        $positions = $record->positions->implode('name', ', ');
//                        return  new HtmlString('Deps: ' . $departments . '<br>' . 'Pos: ' . $positions) ;
//                    })
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->toggleable(isToggledHiddenByDefault: true),


//                Tables\Columns\TextColumn::make('departments.name')
//                    ->label(__('Departments'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->sortable()
//                    ->searchable()
//                    ->toggleable()
//                    ->wrap(),
//                Tables\Columns\TextColumn::make('positions.name')
//                    ->label(__('Positions'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->sortable()
//                    ->searchable()
//                    ->toggleable()
//                    ->wrap()
//                    ->extraAttributes(['class' => 'text-xs']),

//                Tables\Columns\TextColumn::make('proc/prod/serv')
//                    ->label(__('Proc./Prod./Serv.'))
//                    ->formatStateUsing(function ($record) {
//                        $process = $record->process;
//                        $product = $record->product;
//                        $service = $record->service;
//                        return  new HtmlString('Proc: ' . substr($process, 0 ,20) . '<br>' . 'Prod: ' . substr($product, 0 ,20) . '<br>' . 'Serv:' . substr($service, 0, 20) ) ;
//                    })
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->searchable()
//                    ->toggleable(isToggledHiddenByDefault: true),


                Tables\Columns\TextColumn::make('hazard_info')
                    ->label(__('Hazard'))
                    ->limit(30)
                    ->wrap()
                    ->extraAttributes(['class' => 'text-xs'])
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('base_risk_info')
                    ->label(__('Base risk info'))
                    ->limit(30)
                    ->wrap()
                    ->extraAttributes(['class' => 'text-xs'])
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('base_preventive_action')
                    ->label(__('Base prev.actions'))
                    ->limit(30)
                    ->wrap()
                    ->extraAttributes(['class' => 'text-xs'])
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

//                Tables\Columns\TextColumn::make('baseRisk')
//                    ->label(__('Base risk'))
//                    ->formatStateUsing(function ($record) {
//                        $riskFrequency = '';
//                        $riskZoneName = $record->baseCalcRisk->name;
//                        $riskZoneColor = $record->baseCalcRisk->colour;
//                        $riskSeverity = $record->baseSeverity->name;
//                        $riskProbability = $record->baseProbability->name;
//                        if ($record->baseFrequency) {$riskFrequency = $record->baseFrequency->name;}
//
//                        return  new HtmlString('<p class="font-bold">' . $riskZoneName . '</p><br>' . $riskSeverity . '; ' . $riskProbability . '; ' . $riskFrequency) ;
//                    })
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->toggleable(isToggledHiddenByDefault: true),




//
//                Tables\Columns\TextColumn::make('baseSeverity.name')
//                    ->label(__('Severity'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->sortable()
//                    ->searchable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//                Tables\Columns\TextColumn::make('baseProbability.name')
//                    ->label(__('Probability'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->sortable()
//                    ->searchable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//                Tables\Columns\TextColumn::make('baseFrequency.name')
//                    ->label(__('Frequency'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->sortable()
//                    ->searchable()
//                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('baseCalcRisk.name')
                    ->label(__('Base Risk'))
                    ->extraAttributes(['class' => 'text-xs'])
                    ->sortable()
                    ->searchable(),


                Tables\Columns\TextColumn::make('prop_preventive_action')
                    ->label(__('Prevent.actions'))
                    ->extraAttributes(['class' => 'text-xs'])
                    ->limit(30)
                    ->wrap()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

//                Tables\Columns\TextColumn::make('propRisk')
//                    ->label(__('Prop. risk'))
//                    ->formatStateUsing(function ($record) {
//                        $riskFrequency = '';
//                        $riskZoneName = $record->propCalcRisk->name;
//                        $riskZoneColor = $record->propCalcRisk->colour;
//                        $riskSeverity = $record->propSeverity->name;
//                        $riskProbability = $record->propProbability->name;
//                        if ($record->propFrequency) {$riskFrequency = $record->propFrequency->name;}
//
//                        return  new HtmlString('<p class="font-bold">' . $riskZoneName . '</p><br>' . $riskSeverity . '; ' . $riskProbability . '; ' . $riskFrequency) ;
//                    })
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->toggleable(isToggledHiddenByDefault: true),


//                Tables\Columns\TextColumn::make('propSeverity.name')
//                    ->label(__('Severity'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->sortable()
//                    ->searchable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//                Tables\Columns\TextColumn::make('propProbability.name')
//                    ->label(__('Probability'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->sortable()
//                    ->searchable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//                Tables\Columns\TextColumn::make('propFrequency.name')
//                    ->label(__('Frequency'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->sortable()
//                    ->searchable()
//                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('propCalcRisk.name') //TODO design for risk column
                    ->label(__('Prop.Risk'))
                    ->extraAttributes(['class' => 'text-xs'])
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('creator/date')
                    ->label(__('Creator/Date'))
                    ->formatStateUsing(function ($record) {
                        $name = $record->creator->name;
                        $date = date_create($record->create_date_time);
                        return  new HtmlString($name . '<br>' . date_format($date, 'd-m-Y')) ;
                    })
                    ->extraAttributes(['class' => 'text-xs'])
                    ->toggleable(isToggledHiddenByDefault: true),

//                Tables\Columns\TextColumn::make('create_date_time')
//                    ->label(__('Created'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->dateTime('d-m-Y')
//                    ->sortable()
//                    ->searchable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//                Tables\Columns\TextColumn::make('creator.name')
//                    ->label(__('Created by'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->sortable()
//                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('auditor/date')
                    ->label(__('Reviewer/PlanDate'))
                    ->formatStateUsing(function ($record) {
                        $name = $record->auditor->name;
                        $date = date_create($record->review_date);
                        return  new HtmlString($name . '<br>' . date_format($date, 'd-m-Y')) ;
                    })
                    ->extraAttributes(['class' => 'text-xs'])
                    ->toggleable(isToggledHiddenByDefault: true),

//                Tables\Columns\TextColumn::make('review_date')
//                    ->label(__('Review'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->dateTime('d-m-Y')
//                    ->sortable()
//                    ->searchable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//                Tables\Columns\TextColumn::make('auditor.name')
//                    ->label(__('Control by'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->sortable()
//                    ->toggleable(isToggledHiddenByDefault: true),


//                Tables\Columns\TextColumn::make('control_review_date')
//                    ->label(__('Reviewed'))
//                    ->extraAttributes(['class' => 'text-xs'])
//                    ->dateTime('d-m-Y')
//                    ->sortable()
//                    ->searchable()
//                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('risk_status')
                    ->label(__('Status'))
                    ->extraAttributes(['class' => 'text-xs'])
                    ->sortable()
                    ->toggleable(),
//                Tables\Columns\TextColumn::make('actions_id')
//            ->extraAttributes(['class' => 'text-xs'])
//                    ->label(__('Actions'))
//                    ->sortable()
//                    ->toggleable(),



            ])
            ->filters([
                //TODO filters for risk resource

                Tables\Filters\SelectFilter::make('unit')
                    ->label(__('Unit'))
                    ->relationship('unit', 'name'),
                Tables\Filters\MultiSelectFilter::make('territories')
                    ->label(__('Territories'))
                    ->relationship('territories', 'name'),
                Tables\Filters\MultiSelectFilter::make('departments')
                    ->label(__('Departments'))
                    ->relationship('departments', 'name'),
                Tables\Filters\MultiSelectFilter::make('positions')
                    ->label(__('Positions'))
                    ->relationship('positions', 'name'),


                Tables\Filters\MultiSelectFilter::make('hazardCategories')
                    ->label(__('Hazard categories'))
                    ->relationship('hazardCategory', 'name'),
                Tables\Filters\MultiSelectFilter::make('injuredBodyParts')
                    ->label(__('Injured body parts'))
                    ->relationship('injuredBodyPart', 'name'),


                Tables\Filters\MultiSelectFilter::make('processes')
                    ->label(__('Processes'))
                    ->relationship('processes', 'name')
                ,
                Tables\Filters\MultiSelectFilter::make('products')
                    ->label(__('Products'))
                    ->relationship('products', 'name')
                ,
                Tables\Filters\MultiSelectFilter::make('services')
                    ->label(__('Services'))
                    ->relationship('services', 'name')
                ,


            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ;
    }

    public static function getRelations(): array
    {
        return [
            //

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => pages\ListRisks::route('/'),
            'create' => pages\CreateRisk::route('/create'),
            'edit' => pages\EditRisk::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}

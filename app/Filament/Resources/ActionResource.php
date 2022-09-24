<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActionResource\Pages;
use App\Filament\Resources\ActionResource\RelationManagers;
use App\Models\Action;
use App\Models\Unit\Unit;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\Placeholder;

class ActionResource extends Resource
{
    protected static ?string $model = Action::class;
    protected static ?string $navigationGroup = 'Actions management';
    protected static ?string $navigationLabel = 'Actions';
    protected static ?string $pluralLabel = 'Actions';
    protected static ?string $label = 'Action';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('unit_data')
                    ->label(__('Unit data'))
                    ->schema([
                        Forms\Components\Select::make('unit_id')
                            ->label(__('Unit'))
                            ->reactive()
                            ->relationship('unit', 'name'),
                        Forms\Components\MultiSelect::make('territories')
                            ->label(__('Territories'))
                            ->relationship('territories', 'name'),
                        Forms\Components\MultiSelect::make('departments')
                            ->label(__('Departments'))
                            ->relationship('departments', 'name'),
                        Forms\Components\MultiSelect::make('positions')
                            ->label(__('Positions'))
                            ->relationship('positions', 'name'),
                        Forms\Components\MultiSelect::make('workers')
                            ->label(__('Workers'))
                            ->relationship('workers', 'last_name'),
                    ])->columns(5),
                Forms\Components\Repeater::make('action')
                    ->label(__('Actions'))
                    ->schema([

                        Forms\Components\Fieldset::make('')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('Name')),
                                Forms\Components\Textarea::make('description')
                                    ->label(__('Description'))
                                    ->rows(4)
                                    ->columnSpan(2), //TODO validate
                                Forms\Components\Select::make('responsible_id')
                                    ->label(__('Responsible'))
                                    ->relationship('responsible', 'last_name'),
                                Forms\Components\DatePicker::make('plan_date')
                                    ->label(__('Plan date'))
                                    ->withoutTime(),
                                Forms\Components\FileUpload::make('photo_before')
                                    ->label(__('Photo')),
                            ])->columnSpan(3)->columns(3),
                        Forms\Components\Fieldset::make('')
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->label(__('Type'))
                                    ->options([
                                        'Safety' => 'Safety',
                                        'Health' => 'Health',
                                        'Ecology' => 'Ecology',
                                    ]),
                                Forms\Components\Select::make('parent_id')
                                    ->label(__('Parent'))
                                    ->relationship('parent', 'name'),
                                Forms\Components\Select::make('priority')
                                    ->label(__('Priority'))
                                    ->options([
                                        'High' => 'High',
                                        'Normal' => 'Normal',
                                        'Low' => 'Low',
                                    ])
                                    ->default('Normal'),
                            ])->columns(1)
                            ->columnSpan(1),
                        Forms\Components\Placeholder::make('creator_id')
                            ->label(__('Creator'))
                            ->content(fn() => auth()->user()->name)
                            ->hidden(1),
                        Forms\Components\Placeholder::make('status')
                            ->label(__('Status'))
                            ->content('Created')
                            ->hidden(1),
                    ])->visibleOn('create')
                    ->columnSpan(2)
                    ->columns(4),

                Forms\Components\Fieldset::make('action')
                    ->label(__('Action'))
                    ->schema([
                        Forms\Components\Fieldset::make('')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('Name')),
                                Forms\Components\Textarea::make('description')
                                    ->label(__('Description'))
                                    ->rows(4)
                                    ->columnSpan(2), //TODO validate
                                Forms\Components\Select::make('responsible_id')
                                    ->label(__('Responsible'))
                                    ->relationship('responsible', 'last_name'),
                                Forms\Components\DatePicker::make('plan_date')
                                    ->label(__('Plan date'))
                                    ->withoutTime(),
                                Forms\Components\FileUpload::make('photo_before')
                                    ->label(__('Photo')),
                            ])->columnSpan(3)->columns(3),
                        Forms\Components\Fieldset::make('')
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->label(__('Type'))
                                    ->options([
                                        'Safety' => 'Safety',
                                        'Health' => 'Health',
                                        'Ecology' => 'Ecology',
                                    ]),
                                Forms\Components\Select::make('parent_id')
                                    ->label(__('Parent'))
                                    ->relationship('parent', 'name'),
                                Forms\Components\Select::make('priority')
                                    ->label(__('Priority'))
                                    ->options([
                                        'High' => 'High',
                                        'Normal' => 'Normal',
                                        'Low' => 'Low',
                                    ])
                                    ->default('Normal'),
                            ])->columns(1)
                            ->columnSpan(1),
                        Forms\Components\Placeholder::make('creator_id')
                            ->label(__('Creator'))
                            ->content(fn() => auth()->user()->name)
                            ,
                        Forms\Components\Placeholder::make('status')
                            ->label(__('Status'))
                            ->content('Created')
                            ->hidden(1),
                    ])->columns(4)
                    ->visibleOn('edit'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('parent.name')
                ->label(__('Parent')),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('Description'))
                    ->limit(30)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('priority')
                    ->label(__('Priority'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('responsible.last_name')
                    ->label(__('Responsible')),
                Tables\Columns\TextColumn::make('plan_date')
                    ->label(__('Plan'))
                    ->date('d-m-Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('Start'))
                    ->date('d-m-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('due_date')
                    ->label(__('Due'))
                    ->date('d-m-Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\ImageColumn::make('photo_before')
                    ->label(__('Before'))
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('photo_after')
                    ->label(__('After'))
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label(__('Creator'))
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label(__('Type'))
                    ->options([
                        'Safety' => 'Safety',
                        'Health' => 'Health',
                        'Ecology' => 'Ecology',
                    ]),
                Tables\Filters\SelectFilter::make('unit')
                    ->label(__('Unit'))
                    ->relationship('unit', 'name', fn($query) => $query->whereHas('actions')),
                Tables\Filters\MultiSelectFilter::make('territories')
                    ->label(__('Territories'))
                    ->relationship('territories', 'name', fn($query) => $query->whereHas('actions')),
                Tables\Filters\MultiSelectFilter::make('departments')
                    ->label(__('Departments'))
                    ->relationship('departments', 'name', fn($query) => $query->whereHas('actions')),
                Tables\Filters\MultiSelectFilter::make('positions')
                    ->label(__('Positions'))
                    ->relationship('positions', 'name', fn($query) => $query->whereHas('actions')),
                Tables\Filters\MultiSelectFilter::make('workers')
                    ->label(__('Workers'))
                    ->relationship('workers', 'last_name', fn($query) => $query->whereHas('actions')),
                Tables\Filters\MultiSelectFilter::make('risks')
                    ->label(__('Risks'))
                    ->relationship('risks', 'base_risk_info', fn($query) => $query->whereHas('actions')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListActions::route('/'),
            'create' => Pages\CreateAction::route('/create'),
            'edit' => Pages\EditAction::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\UnitResource\RelationManagers;

use App\Models\Unit\Department;
use App\Models\Unit\JobPosition;
use App\Models\Unit\Unit;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkersRelationManager extends RelationManager
{
    protected static string $relationship = 'workers';

    protected static ?string $recordTitleAttribute = 'short_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('')
                    ->schema([
                        Forms\Components\TextInput::make('last_name')
                            ->label(__('Last name'))
                            ->required(),
                        Forms\Components\TextInput::make('first_name')
                            ->label(__('First Name'))
                            ->required(),
                        Forms\Components\TextInput::make('middle_name')
                            ->label(__('Middle name')),
                    ])->columns(3),
                Forms\Components\Fieldset::make('')
                    ->schema([
                        Forms\Components\Select::make('unit_id')
                            ->label(__('Unit'))
                            ->options(Unit::all()->pluck('short_name', 'id')),
                        Forms\Components\Select::make('department_id')
                            ->label(__('Department'))
                            ->options(Department::all()->pluck('name', 'id')),
                        Forms\Components\Select::make('job_position_id')
                            ->label(__('Job position'))
                            ->options(JobPosition::all()->pluck('name', 'id')),
                    ])->columns(3),
                Forms\Components\Fieldset::make('')
                    ->schema([
                        Forms\Components\TextInput::make('personnel_number')
                            ->label(__('Number'))
                            ->unique(),
                        Forms\Components\TextInput::make('phone')
                            ->label(__('Phone'))
                            ->unique()
                            ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->pattern('+3{8}(000)000-00-00')),
                        Forms\Components\TextInput::make('email')
                            ->label(__('Email'))
                            ->unique()
                            ->email(),
                    ])->columns(3),

                Forms\Components\DatePicker::make('birthday')
                    ->label(__('Birthday'))
                ,
                Forms\Components\Select::make('status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                    ])
                    ->default('Active')
                    ->label(__('Status'))
                    ->disablePlaceholderSelection(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('last_name')
                    ->label(__('Last name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->label(__('Name'))
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->label(__('Middle name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('personnel_number')
                    ->label(__('Number'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('jobPosition.name')
                    ->label(__('Job position'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->label(__('Department'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('unit.name')
                    ->label(__('Unit'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('birthday')
                    ->label(__('Birthday'))
                    ->dateTime('d-m-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated'))
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
            ])
            ->filters([
                Tables\Filters\SelectFilter::make(__('Department'))
                    ->options(Department::all()->pluck('name', 'id'))
                    ->column('id'),
                Tables\Filters\SelectFilter::make(__('Unit'))
                    ->options(JobPosition::all()->pluck('name', 'id'))
                    ->column('id'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}

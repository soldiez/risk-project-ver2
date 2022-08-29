<?php

namespace App\Filament\Resources\UnitResource\RelationManagers;

use App\Models\Unit\Territory;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Filament\Forms;

use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TerritoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'territories';
    protected static ?string $recordTitleAttribute = 'short_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('unit_id')
                    ->options(Unit::all()->pluck('short_name', 'id'))
                    ->searchable()
                    ->label(__('Unit')),
                Forms\Components\Select::make('parent_id')
                    ->reactive()
                    ->options(function (callable $get){ //do not choice by myself
                        if($get('name') != NULL) {
                            return Territory::where('name', '!=', $get('name'))->pluck('name', 'id');
                        }
                        return Territory::all()->pluck('name', 'id');
                    })
                    ->searchable()
                    ->label(__('Parent'))
                    ->default(1),
                Forms\Components\TextInput::make('name')
                    ->label(__('Name')),
                Forms\Components\Select::make('responsible_id')
                    ->label(__('Responsible person'))
                    ->options(Worker::all()->pluck('last_name', 'id')),
//                Forms\Components\Select::make('department_id')
//                    ->label(__('Подразделение'))
//                    ->options(Department::all()->pluck('name', 'id')),
//               Forms\Components\Fieldset::make(__('Контакты'))
//                   ->schema([
//                   Forms\Components\TextInput::make('coordinate')
//                       ->label(__('Координаты')),
//                   Forms\Components\TextInput::make('address')
//                       ->label(__('Адрес')),
//                   Forms\Components\TextInput::make('info')
//                       ->label(__('Информация')),
//               ])->columns(3),

                Forms\Components\Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                    ])
                    ->default('Active')
                    ->disablePlaceholderSelection(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('unit.short_name')
                    ->label(__('Unit'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label(__('Parent'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->limit(15)
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('responsible_id')
                    ->label(__('Resp.person'))
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function ($state){if(Worker::find($state) !== null){return Worker::find($state)->last_name;} return '-';})
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('coordinate')
                    ->label(__('Coordinates'))
                    ->limit(10)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('Address'))
                    ->limit(10)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('info')
                    ->label(__('Info'))
                    ->limit(10)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->dateTime('d-m-Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated'))
                    ->dateTime('d-m-Y')
                    ->hidden()
                    ->toggleable(isToggledHiddenByDefault: true)
            ])
            ->filters([
//
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ReplicateAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}

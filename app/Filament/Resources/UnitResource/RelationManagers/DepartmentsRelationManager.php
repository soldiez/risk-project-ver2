<?php

namespace App\Filament\Resources\UnitResource\RelationManagers;

use App\Models\Unit\Department;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'departments';

    protected static ?string $recordTitleAttribute = 'short_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('unit_id')
                    ->label(__('Unit'))
                    ->searchable()
                    ->options(Unit::all()->pluck('short_name', 'id')),
                Forms\Components\Select::make('parent_id')
                    ->reactive()
                    ->options(function (callable $get){ //do not choice by myself
                        if($get('name') != NULL) {
                            return Department::where('name', '!=', $get('name'))->pluck('name', 'id'); //TODO for same name for diff unit
                        }
                        return Department::all()->pluck('name', 'id');
                    })
                    ->searchable()
                    ->label(__('Parent'))
                    ->default(1),
                Forms\Components\TextInput::make('name')
                    ->label(__('Name')),
                Forms\Components\Select::make('manager_id')
                    ->label(__('Manager'))
                    ->searchable()
                    ->options(Worker::all()->pluck('last_name', 'id')),
                Forms\Components\TextInput::make('info')
                    ->label(__('Info')),
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
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('manager.last_name')
                    ->label(__('Manager'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('info')
                    ->label(__('Info'))
                    ->limit(20)
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
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated'))
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

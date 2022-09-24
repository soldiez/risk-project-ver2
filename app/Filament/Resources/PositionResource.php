<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PositionResource\Pages;
use App\Filament\Resources\PositionResource\RelationManagers;
use App\Models\Unit\Department;
use App\Models\Unit\Position;
use App\Models\Unit\Unit;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Units management';
    protected static ?string $label = 'Position';
    protected static ?string $pluralLabel = 'Positions';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('unit_id')
                    ->label(__('Unit'))
                    ->searchable()
                    ->reactive()
                    ->options(Unit::all()->pluck('name', 'id')),
                Forms\Components\Select::make('department_id')
                    ->label(__('Department'))
                    ->searchable()
                    ->options(fn($get)=>Department::where('unit_id', $get('unit_id'))->pluck('name', 'id')),
                Forms\Components\Select::make('parent_id')
                    ->reactive()
                    ->options(function (callable $get){ //do not choice by myself
                        if($get('name') != NULL) {
                            return Position::where('name', '!=', $get('name'))->pluck('name', 'id');
                        }
                        return Position::all()->pluck('name', 'id');
                    })
                    ->searchable()
                    ->label(__('Parent'))
                    ->default(1),
                Forms\Components\TextInput::make('name')
                    ->label(__('Name')),
                Forms\Components\TextInput::make('grade')
                    ->label(__('Grade')),
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
                Tables\Columns\TextColumn::make('unit.name')
                    ->label(__('Unit'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->label(__('Department'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label(__('Parent'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('grade')
                    ->label(__('Grade'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('info')
                    ->label(__('Info'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->date('d-m-Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated'))
                    ->date('d-m-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)

            ])
            ->filters([

                Tables\Filters\SelectFilter::make('unit')
                    ->label(__('Unit'))
                    ->relationship('unit', 'name'),
                Tables\Filters\SelectFilter::make('parent')
                    ->label(__('Parent'))
                    ->options(
                        function (){
                            return Position::whereIn('id', Position::get('parent_id'))->pluck('name', 'id');
                        })->column('parent_id'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ReplicateAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\WorkersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPositions::route('/'),
            'create' => Pages\CreatePosition::route('/create'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),
        ];
    }

}

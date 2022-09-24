<?php

namespace App\Filament\Resources\UnitResource\RelationManagers;

use App\Models\Unit\Territory;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Closure;
use Filament\Forms;

use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use http\QueryString;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TerritoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'territories';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('parent_id')
                ->options(fn($livewire, $get)=>Unit::find($livewire->ownerRecord->id)
                    ->territories->where('name', '!=', $get('name'))->pluck('name', 'id')->prepend('-', '1'))
                    ->searchable()
                    ->label(__('Parent'))
                    ->default(1)
                ,
                Forms\Components\TextInput::make('name')
                    ->label(__('Name')),
                Forms\Components\MultiSelect::make('departments')
                    ->label(__('Departments'))
                    ->searchable()
                    ->relationship('departments', 'name'),
               Forms\Components\Fieldset::make('contacts')
                   ->label(__('Contacts'))
                   ->schema([
                       Forms\Components\Select::make('responsible_id')
                           ->label(__('Responsible person'))
                           ->relationship('responsible', 'last_name'),
                   Forms\Components\TextInput::make('coordinate')
                       ->label(__('Coordinates')),
                   Forms\Components\TextInput::make('address')
                       ->label(__('Address')),
                   Forms\Components\TextInput::make('info')
                       ->label(__('Information')),
               ])->columns(2),
                Forms\Components\Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                    ])
                    ->default('Active')
                    ->disablePlaceholderSelection(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                Tables\Columns\TextColumn::make('responsible.last_name')
                    ->label(__('Resp.person'))
                    ->sortable()
                    ->searchable()
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

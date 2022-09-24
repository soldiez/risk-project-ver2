<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TerritoryResource\Pages;
use App\Filament\Resources\TerritoryResource\RelationManagers;
use App\Models\Unit\Territory;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;


class TerritoryResource extends Resource
{
    protected static ?string $model = Territory::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Units management';
    protected static ?string $navigationLabel = 'Territories';
    protected static ?string $pluralLabel = 'Territories';
    protected static ?string $label = 'Territory';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {

        return $form
            ->schema([

                Forms\Components\Select::make('unit')
                    ->relationship('unit', 'name')
                    ->label(__('Unit'))
                    ->reactive(),
                Forms\Components\Select::make('parent')
                    ->reactive()
                    ->options(function (callable $get){
                        if($get('name') != NULL) {
                            return Territory::where('name', '!=', $get('name'))->pluck('name', 'id');
                        }
                        return Territory::all()->pluck('name', 'id');
                    })
                    ->label(__('Parent')),
                Forms\Components\TextInput::make('name')
                    ->label(__('Name')),
                Forms\Components\Select::make('responsible_id')
                    ->label(__('Responsible person'))
                    ->options(fn($get)=>Worker::where('unit_id', $get('unit_id'))->pluck('last_name', 'id')),
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
                Tables\Columns\TextColumn::make('unit.name')
                    ->label(__('Unit'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label(__('Parent'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->limit(15)
                    ->sortable()
                    ->searchable(),
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
                    ->date('d-m-Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated'))
                    ->date('d-m-Y')
                    ->hidden()
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
                           return Territory::whereIn('id', Territory::get('parent_id'))->pluck('name', 'id');
                        })
                    ->column('parent_id')
                ,
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
            //
//            RelationManagers\TerritoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTerritories::route('/'),
            'create' => Pages\CreateTerritory::route('/create'),
            'edit' => Pages\EditTerritory::route('/{record}/edit'),
        ];
    }

}

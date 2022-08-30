<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitResource\Pages;
use App\Filament\Resources\UnitResource\RelationManagers;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;
    protected static ?string $navigationIcon = 'heroicon-o-office-building';
    protected static ?string $navigationGroup = 'Units management';
    protected static ?string $navigationLabel = 'Units';
    protected static ?string $pluralLabel = 'Units';
    protected static ?string $label = 'Unit';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('short_name')
                    ->required()
                    ->label(__('Short Name')),
                Forms\Components\TextInput::make('long_name')
                    ->label(__('Full name')),
                Forms\Components\FileUpload::make('logo_unit')
                    ->label(__('Logo'))
                    ->image()
                    ->imagePreviewHeight('100')
                    ->maxSize(2048),
                Forms\Components\Select::make('parent_id')
                    ->reactive()
                    ->options(function (callable $get){ //do not choice by myself
                        if($get('short_name') != NULL) {
                            return Unit::where('short_name', '!=', $get('short_name'))->pluck('short_name', 'id');
                        }
                        return Unit::all()->pluck('short_name', 'id');
                    })
                    ->searchable()
                    ->label(__('Parent'))
                    ->default(1)
                    ->searchable()
                    ->label(__('Parent unit')),
                Forms\Components\TextArea::make('legal_address')
                    ->label(__('Legal address')),
                Forms\Components\TextArea::make('post_address')
                    ->label(__('Post address')),
                Forms\Components\TextInput::make('phone_main')
                    ->label(__('Phone'))
                    ->tel()
                    ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->pattern('+3{8}(000)000-00-00')),
                Forms\Components\TextInput::make('phone_reserve')
                    ->label(__('Reserve phone'))
                    ->tel()
                    ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->pattern('+3{8}(000)000-00-00')),
                Forms\Components\TextInput::make('email')
                    ->label(__('Email'))
                    ->email(),
                Forms\Components\Fieldset::make('')
                    ->schema([
                        Forms\Components\Select::make('manager_id')
                            ->label(__('Manager'))
                            ->options(Worker::all()->pluck('last_name', 'id')),
                        Forms\Components\Select::make('safety_manager_id')
                            ->label(__('Safety manager'))
                            ->options(Worker::all()->pluck('last_name', 'id')),
                    ]),
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
                Tables\Columns\ImageColumn::make('logo_unit')
                    ->label(__('Logo'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('short_name')
                    ->label(__('Short name'))
                    ->sortable()
                    ->searchable()
                    ->limit(15),
                Tables\Columns\TextColumn::make('long_name')
                    ->label(__('Full name'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone_main')
                    ->label(__('Phone'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone_reserve')
                    ->label(__('Reserve phone'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->sortable()
                    ->searchable()
                    ->limit(15)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('legal_address')
                    ->label(__('Legal address'))
                    ->searchable()->limit(20)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('post_address')
                    ->label(__('Post address'))
                    ->searchable()->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('manager.last_name')
                    ->label(__('Manager'))
                    ->sortable()
//                    ->formatStateUsing(function ($state){if(Worker::find($state) !== null){return Worker::find($state)->fullName();} return '-';})
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('safetyManager.last_name')
                    ->label(__('Safety manager'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('parent.short_name')
                    ->label(__('Parent'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->sortable()
                    ->dateTime('d-m-Y')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make(__('Unit'))
                    ->options(Unit::all()->pluck('short_name', 'id'))
                    ->column('id'),
                Tables\Filters\SelectFilter::make(__('Parent'))
                    ->options(
                        function (){
                            return Unit::whereIn('id', Unit::get('parent_id'))->pluck('short_name', 'id');
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
            RelationManagers\TerritoriesRelationManager::class,
                RelationManagers\DepartmentsRelationManager::class,
                RelationManagers\JobPositionsRelationManager::class,
                RelationManagers\WorkersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnits::route('/'),
            'create' => Pages\CreateUnit::route('/create'),
            'edit' => Pages\EditUnit::route('/{record}/edit'),
        ];
    }
    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count()-1;
    }
}

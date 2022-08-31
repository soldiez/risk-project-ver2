<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkerResource\Pages;
use App\Filament\Resources\WorkerResource\RelationManagers;
use App\Models\Unit\Department;
use App\Models\Unit\Position;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkerResource extends Resource
{
    protected static ?string $model = Worker::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Units management';
    protected static ?string $navigationLabel = 'Workers';
    protected static ?string $label = 'Worker';
    protected static ?string $pluralLabel = 'Workers';
    protected static ?int $navigationSort = 5;

    //for translate
    protected static function getNavigationGroup(): ?string
    {
        return __('Units management');
    }

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
                        Forms\Components\Select::make('position_id')
                            ->label(__('Job position'))
                            ->options(Position::all()->pluck('name', 'id')),
                    ])->columns(3),
                Forms\Components\Fieldset::make('')
                    ->schema([
                        Forms\Components\TextInput::make('personnel_number')
                            ->label(__('Number')),
                        Forms\Components\TextInput::make('phone')
                            ->label(__('Phone'))
                            ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->pattern('+3{8}(000)000-00-00')),
                        Forms\Components\TextInput::make('email')
                            ->label(__('Email'))
                            ->email(),
                    ])->columns(3),
                Forms\Components\DatePicker::make('birthday')
                    ->label(__('Birthday')),
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
                Tables\Columns\TextColumn::make('position.name')
                    ->label(__('Job position'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->label(__('Department'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('unit.short_name')
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
                Tables\Filters\SelectFilter::make(__('Unit'))
                    ->options(
                        function (){
                            return Unit::whereIn('id', Worker::get('unit_id'))->pluck('short_name', 'id');
                        })
                    ->column('unit_id')
                ,
                Tables\Filters\SelectFilter::make(__('Department'))
                    ->options(
                        function (){
                            return Department::whereIn('id', Worker::get('department_id'))->pluck('name', 'id');
                        })
                    ->column('department_id')
                ,
                Tables\Filters\SelectFilter::make(__('Position'))
                    ->options(
                        function (){
                            return Position::whereIn('id', Worker::get('position_id'))->pluck('name', 'id');
                        })
                    ->column('position_id'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkers::route('/'),
            'create' => Pages\CreateWorker::route('/create'),
            'edit' => Pages\EditWorker::route('/{record}/edit'),
        ];
    }
    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}

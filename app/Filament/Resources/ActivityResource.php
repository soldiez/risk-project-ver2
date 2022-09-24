<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Filament\Resources\ActivityResource\RelationManagers;
use App\Models\Unit\Activity;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use http\QueryString;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Units management';
    protected static ?string $navigationLabel = 'Activities';
    protected static ?string $label = 'Activity';
    protected static ?string $pluralLabel = 'Activities';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('unit_data')
                                    ->label(__('Unit data'))
                                    ->schema([
                                        Forms\Components\Select::make('unit')
                                            ->label(__('Unit'))
                                            ->reactive()
                                            ->relationship('unit', 'name'),//todo default unit
                                        Forms\Components\MultiSelect::make('territories')
                                            ->label(__('Territories'))
                                            ->searchable()
                                            ->relationship('territories', 'name'),
                                        Forms\Components\MultiSelect::make('departments')
                                            ->label(__('Departments'))
                                            ->searchable()
                                            ->relationship('departments', 'name'),
                                        Forms\Components\MultiSelect::make('positions')
                                            ->label(__('Positions'))
                                            ->searchable()
                                            ->relationship('positions', 'name'),
                                    ])->columns(5),
                                Forms\Components\Select::make('parent')
                                    ->label(__('Parent'))
                                    ->options(function (callable $get) {
                                        if ($get('name') != NULL) {
                                            return Activity::where('name', '!=', $get('name'))->pluck('name', 'id')->prepend('-', '1');
                                        }
                                        return Activity::all()->pluck('name', 'id');
                                    })
                                    ->default(1),
                                Forms\Components\Select::make('type')
                                    ->label(__('Type'))
                                    ->options([
                                        'Process' => 'Process',
                                        'Product' => 'Product',
                                        'Service' => 'Service',
                                    ]),

                                Forms\Components\TextInput::make('name')
                                    ->label(__('Name')),
                                Forms\Components\Textarea::make('description')
                                    ->label(__('Description'))
                                    ->rows(2),
                                Forms\Components\Select::make('status')
                                    ->label(__('Status'))
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
                //
                Tables\Columns\TextColumn::make('type')
                    ->label(__('Type')),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label(__('Parent')),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('Description'))
                    ->limit(50)
                ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->date('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated'))
                    ->date('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                ->label(__('Type'))
                ->options([
                    'Process' => 'Process',
                    'Product' => 'Product',
                    'Service' => 'Service',
                ])
                ->column('type'),

//                Filter::make('process')
//                    ->label('Process')
//                    ->query(fn (Builder $query): Builder => $query->where('type', 'like','Process'))
//                    ->toggle(),
//                Filter::make('product')
//                    ->label('Product')
//                    ->query(fn (Builder $query): Builder => $query->where('type', 'like','Product'))
//                    ->toggle(),
//                Filter::make('service')
//                    ->label('Service')
//                    ->query(fn (Builder $query): Builder => $query->where('type', 'like','Service'))
//                    ->toggle(),
                Tables\Filters\SelectFilter::make('unit')
                    ->relationship('unit', 'name'),
                Tables\Filters\MultiSelectFilter::make('territories')
                    ->relationship('territories', 'name'),
                Tables\Filters\MultiSelectFilter::make('departments')
                    ->relationship('departments', 'name'),
                Tables\Filters\MultiSelectFilter::make('positions')
                    ->relationship('positions','name'),



            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}

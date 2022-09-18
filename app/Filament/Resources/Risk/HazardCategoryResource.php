<?php

namespace App\Filament\Resources\Risk;

use App\Filament\Resources\Risk\HazardCategoryResource\Pages;
use App\Filament\Resources\Risk\HazardCategoryResource\RelationManagers;
use App\Models\Risk\HazardCategory;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HazardCategoryResource extends Resource
{
    protected static ?string $model = HazardCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Risks management';
    protected static ?string $navigationLabel = 'Hazard categories';
    protected static ?string $pluralLabel = 'Hazard categories';
    protected static ?string $label = 'Hazard category';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('type')
                    ->label(__('Type'))
                    ->options([
                        'Safety',
                        'Biological',
                        'Chemical',
                        'Ergonomic',
                        'Work organisational',
                        'Physical'
                    ])
                    ->columns(1),
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                ->columnSpan(3)
            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('type')
                ->label(__('Type'))
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('name')
                ->label(__('Name'))
                    ->limit(80)
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageHazardCategories::route('/'),
        ];
    }
    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}

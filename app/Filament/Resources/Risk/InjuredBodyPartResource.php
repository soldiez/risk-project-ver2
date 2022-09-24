<?php

namespace App\Filament\Resources\Risk;

use App\Filament\Resources\Risk\InjuredBodyPartResource\Pages;
use App\Filament\Resources\Risk\InjuredBodyPartResource\RelationManagers;
use App\Models\Risk\InjuredBodyPart;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InjuredBodyPartResource extends Resource
{
    protected static ?string $model = InjuredBodyPart::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Risks management';
    protected static ?string $navigationLabel = 'Injured body parts';
    protected static ?string $pluralLabel = 'Injured body parts';
    protected static ?string $label = 'Injured body part';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('code')
                    ->label(__('Code'))
                    ->columns(1),
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->columnSpan(3),
            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('code')
                    ->label(__('Code'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
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
            'index' => Pages\ManageInjuredBodyParts::route('/'),
        ];
    }

}

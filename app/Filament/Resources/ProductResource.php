<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Unit\Product;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Units management';
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $pluralLabel = 'Products';
    protected static ?string $label = 'Product';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Fieldset::make('')
                    ->schema([
                        Forms\Components\MultiSelect::make('unit')
                            ->label(__('Unit'))
                            ->relationship('unit', 'name'),
                        Forms\Components\MultiSelect::make('territories')
                            ->label(__('Territories'))
                            ->relationship('territories', 'name'),
                        Forms\Components\MultiSelect::make('departments')
                            ->label(__('Departments'))
                            ->relationship('departments', 'name'),
                        Forms\Components\MultiSelect::make('positions')
                            ->label(__('Positions'))
                            ->relationship('positions', 'name'),
                        Forms\Components\MultiSelect::make('workers')
                            ->label(__('Workers'))
                            ->relationship('workers', 'name'),
                    ])->columns(5),
                Forms\Components\Select::make('parent')
                    ->label(__('Parent'))
                    ->options(function (callable $get){
                        if($get('name') != NULL) {
                            return Product::where('name', '!=', $get('name'))->pluck('name', 'id');
                        }
                        return Product::all()->pluck('name', 'id');
                    }),

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
                Tables\Columns\TextColumn::make('parent.name')
                    ->label(__('Parent')),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name')),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('Description'))
                    ->limit(50),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->date('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('updated_at'))
                    ->date('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                Tables\Filters\MultiSelectFilter::make('unit')
                    ->label(__('Units'))
                    ->relationship('unit', 'name'),
                Tables\Filters\MultiSelectFilter::make('territories')
                    ->label(__('Territories'))
                    ->relationship('territories', 'name', fn(Builder $query) => $query->has('products')),
                Tables\Filters\MultiSelectFilter::make('departments')
                ->label(__('Departments'))
                    ->relationship('departments', 'name', fn(Builder $query, $livewire) => $query->has('products')),
                Tables\Filters\MultiSelectFilter::make('positions')
                    ->label(__('Positions'))
                    ->relationship('positions', 'name', fn(Builder $query) => $query->has('products')),
                Tables\Filters\MultiSelectFilter::make('workers')
                    ->label(__('Workers'))
                    ->relationship('workers', 'last_name', fn(Builder $query) => $query->has('products')),

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
            'index' => Pages\ManageProducts::route('/'),
        ];
    }
}

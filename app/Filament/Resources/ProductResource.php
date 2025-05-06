<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductModel;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use App\Filament\Clusters\Products;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-m-building-storefront';

    protected static ?string $cluster = Products::class;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('slug', Product::generateUniqueSlug($state));
                    })
                    ->live(onBlur: true)
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->options(Category::whereNull('deleted_at')->get()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->searchDebounce(300),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->readOnly()
                    ->maxLength(255),
                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp '),
                Forms\Components\FileUpload::make('image')
                    ->image(),
                Forms\Components\TextInput::make('barcode')
                    ->maxLength(255),
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->options(Brand::whereNull('deleted_at')->get()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->searchDebounce(300),
                Forms\Components\Select::make('product_model_id')
                    ->relationship('productModel', 'name')
                    ->options(ProductModel::whereNull('deleted_at')->get()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->searchDebounce(300),
                Forms\Components\TextInput::make('imei1')
                    ->maxLength(255),
                Forms\Components\TextInput::make('imei2')
                    ->maxLength(255),
                Forms\Components\TextInput::make('color')
                    ->maxLength(255),
                Forms\Components\TextInput::make('condition')
                    ->maxLength(255),
                    Forms\Components\TextInput::make('storage_capacity')
                    ->maxLength(255),
                    Forms\Components\TextInput::make('screen_size')
                    ->maxLength(255),
                    Forms\Components\TextInput::make('processor')
                    ->maxLength(255),
                    Forms\Components\TextInput::make('ram')
                    ->maxLength(255),
                Forms\Components\TextInput::make('battery_capacity')
                    ->maxLength(255),
                Forms\Components\TextInput::make('additional_specs'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->width(400)
                    ->height(400)
                    ->size(80),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('barcode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('productModel.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('imei1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('imei2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('color')
                    ->searchable(),
                Tables\Columns\TextColumn::make('condition')
                    ->searchable(),
                Tables\Columns\TextColumn::make('storage_capacity')
                    ->searchable(),
                Tables\Columns\TextColumn::make('screen_size')
                    ->searchable(),
                Tables\Columns\TextColumn::make('processor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ram')
                    ->searchable(),
                Tables\Columns\TextColumn::make('battery_capacity')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

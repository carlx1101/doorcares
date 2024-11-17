<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Unit;
use Filament\Tables;
use App\Models\Property;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UnitResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UnitResource\RelationManagers;
use Filament\Forms\Components\Section;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Property Details')->schema([
                    Select::make('property_id')->label('Property')->required()
                    ->options(Property::all()->pluck('property_name','id')),
                    Select::make('tenure')->options(['Freehold' => 'Freehold', 'Leasehold' => 'Leasehold'] ),
                    TextInput::make('block')->required(),
                    TextInput::make('level')->required(),
                    TextInput::make('unit')->required(),
                    TextInput::make('layout_type'),
                ])->columns(2),

                Section::make('Unit Details')->schema([
                    TextInput::make('bedrooms')->required()->numeric(),
                    TextInput::make('bathrooms')->required()->numeric(),
                    TextInput::make('car_parks')->required()->numeric(),
                    Select::make('balcony')
                            ->options(['Yes' => 'Yes', 'No' => 'No'])
                            ->default('Yes')
                            ->selectablePlaceholder(false),
                    Select::make('cooker_type')
                            ->options(['None' => 'None', 'Electrical' => 'Electrical', 'Gas' => 'Gas'] )
                            ->default('None')
                            ->selectablePlaceholder(false),
                    Select::make('bathtub')
                            ->options(['Yes' => 'Yes', 'No' => 'No'] )
                            ->default("No")
                            ->selectablePlaceholder(false),
                    TextInput::make('built_up_area')->required()->numeric(),
                    TextInput::make('land_area')->required()->numeric(),
                    Select::make('type')->options(['Rental' => 'Rental', 'For_Sale' => 'For_Sale']),
                    TextInput::make('price')->required()->numeric()->rules('regex:/^\d{1,10}(\.\d{1,2})?$/'), 
                    Select::make('furnishing_status')->required()
                            ->options(['Fully Furnished' => 'Fully Furnished', 'Partially Furnished' => 'Partially Furnished', 'Unfurnished' => 'Unfurnished'] )
                            ->selectablePlaceholder(false),
                    Textarea::make('description')->columnSpanFull(),
                    FileUpload::make('image_url')->image()->columnSpanFull()
                ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('property.property_name'),
                TextColumn::make('tenure'),
                TextColumn::make('block'),
                TextColumn::make('level'),
                TextColumn::make('unit'),
                TextColumn::make('layout_type'),
                TextColumn::make('bedrooms'),
                TextColumn::make('bathrooms'),
                TextColumn::make('car_parks'),
                TextColumn::make('balcony'),
                TextColumn::make('cooker_type'),
                TextColumn::make('bathtub'),
                TextColumn::make('built_up_area'),
                TextColumn::make('land_area'),
                TextColumn::make('type'),
                TextColumn::make('price'),
                TextColumn::make('furnishing_status'),
                TextColumn::make('description'),
                
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
            'index' => Pages\ListUnits::route('/'),
            'create' => Pages\CreateUnit::route('/create'),
            'edit' => Pages\EditUnit::route('/{record}/edit'),
        ];
    }
}

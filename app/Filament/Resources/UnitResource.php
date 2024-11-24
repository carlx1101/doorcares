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
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UnitResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UnitResource\RelationManagers;
use App\Filament\Resources\UnitResource\RelationManagers\SpaceRelationManager;
use Filament\Tables\Filters\SelectFilter;

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
                    ->relationship('property','property_name')->searchable(),
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
                    Select::make('type')
                            ->options(['Rental' => 'Rental', 'For_Sale' => 'For_Sale'])->required(),
                    TextInput::make('price')->required()->numeric()->rules('regex:/^\d{1,10}(\.\d{1,2})?$/'), 
                    Select::make('furnishing_status')->required()
                            ->options(['Fully Furnished' => 'Fully Furnished', 'Partially Furnished' => 'Partially Furnished', 'Unfurnished' => 'Unfurnished'] )
                            ->default("Fully Furnished")
                            ->selectablePlaceholder(false),
                    Textarea::make('description')->columnSpanFull()->required(),
                    FileUpload::make('image_url')->image()->columnSpanFull()
                ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('property.property_name')->sortable()->searchable(),
                TextColumn::make('tenure')->sortable()->searchable(),
                TextColumn::make('block')->sortable()->searchable(),
                TextColumn::make('level')->sortable()->searchable(),
                TextColumn::make('unit')->sortable()->searchable(),
                TextColumn::make('layout_type')->sortable()->searchable(),
                TextColumn::make('bedrooms')->sortable()->searchable(),
                TextColumn::make('bathrooms')->sortable()->searchable(),
                TextColumn::make('car_parks')->sortable()->searchable(),
                TextColumn::make('balcony')->sortable()->searchable(),
                TextColumn::make('cooker_type')->sortable()->searchable(),
                TextColumn::make('bathtub')->sortable()->searchable(),
                TextColumn::make('built_up_area')->sortable()->searchable(),
                TextColumn::make('land_area')->sortable()->searchable(),
                TextColumn::make('type')->sortable()->searchable(),
                TextColumn::make('price')->sortable()->searchable(),
                TextColumn::make('furnishing_status')->sortable()->searchable(),
                TextColumn::make('description'),
                
            ])
            ->filters([
                SelectFilter::make('property_id')
                    ->label('Property')
                    ->relationship('property','property_name')
                    ->preload()
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
             SpaceRelationManager::class,
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

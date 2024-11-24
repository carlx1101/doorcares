<?php

namespace App\Filament\Resources\PropertyResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class UnitsRelationManager extends RelationManager
{
    protected static string $relationship = 'Units';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Property Details')->schema([
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

    public function table(Table $table): Table
    {
        return $table
        ->recordTitleAttribute('title')
        ->columns([
            Tables\Columns\TextColumn::make('block'),
            Tables\Columns\TextColumn::make('level'),
            Tables\Columns\TextColumn::make('unit'),
            Tables\Columns\TextColumn::make('layout_type'),
            Tables\Columns\TextColumn::make('furnishing_status'),
        ])
        ->filters([
            //
        ])
        ->headerActions([
            Tables\Actions\CreateAction::make(),
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
}

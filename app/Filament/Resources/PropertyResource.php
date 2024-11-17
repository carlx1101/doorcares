<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Property;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PropertyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PropertyResource\RelationManagers;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('property_name')->required(),
                TextInput::make('street')->required(),
                TextInput::make('residential_area'),
                TextInput::make('city')->required(),
                TextInput::make('postal_code')->required(),
                Select::make('state')
                        ->options([
                            'Johor' => 'Johor',
                            'Kedah' => 'Kedah',
                            'Kelantan' => 'Kelantan',
                            'Melaka' => 'Melaka',
                            'Negeri Sembilan' => 'Negeri Sembilan',
                            'Pahang' => 'Pahang',
                            'Perak' => 'Perak',
                            'Perlis' => 'Perlis',
                            'Pulau Pinang' => 'Pulau Pinang',
                            'Sabah' => 'Sabah',
                            'Sarawak' => 'Sarawak',
                            'Selangor' => 'Selangor',
                            'Terengganu' => 'Terengganu',
                            'Kuala Lumpur' => 'Kuala Lumpur (Federal Territory)',
                            'Labuan' => 'Labuan (Federal Territory)',
                            'Putrajaya' => 'Putrajaya (Federal Territory)',
                        ])
                        ->label('State')
                        ->searchable() // Makes the dropdown searchable
                        ->native(false), // Ensures it renders as a custom dropdown
                Textarea::make('description')->required(),
                Select::make('tenure')->options(['Freehold' => 'Freehold', 'Leasehold' => 'Leasehold'] ),
                Select::make('property_type')->options(['Condominium' => 'Condominium', 'Landed' => 'Landed'] ),
                TextInput::make('build_year')->required()->numeric(),
                TextInput::make('developer_name'),
                FileUpload::make('image_url')->image()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('property_name'),
                TextColumn::make('street'),
                TextColumn::make('city'),
                TextColumn::make('postal_code'),
                TextColumn::make('state'),
                TextColumn::make('tenure'),
                TextColumn::make('property_type'),
                TextColumn::make('build_year'),
                TextColumn::make('developer_name'),
                ImageColumn::make('image_url')
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}

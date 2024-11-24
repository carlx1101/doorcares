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
use App\Filament\Resources\PropertyResource\RelationManagers\UnitsRelationManager;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('property_name')->rules('min:3')->required(),
                TextInput::make('street')->required(),
                TextInput::make('residential_area'),
                TextInput::make('city')->required(),
                TextInput::make('postal_code')->numeric()->rules(['digits:5'])->required(),
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
                        ->required()
                        ->searchable() // Makes the dropdown searchable
                        ->native(false), // Ensures it renders as a custom dropdown
                Select::make('tenure')->options(['Freehold' => 'Freehold', 'Leasehold' => 'Leasehold'] )->required(),
                Select::make('property_type')->options(['Condominium' => 'Condominium', 'Landed' => 'Landed'] ),
                TextInput::make('build_year')->numeric(),
                TextInput::make('developer_name'),
                Textarea::make('description')->columnSpanFull(),
                FileUpload::make('image_url')->image()->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('property_name')->sortable()->searchable(),
                TextColumn::make('street')->sortable(),
                TextColumn::make('city')->sortable(),
                TextColumn::make('postal_code')->sortable(),
                TextColumn::make('state')->sortable(),
                TextColumn::make('tenure')->sortable(),
                TextColumn::make('property_type')->sortable(),
                TextColumn::make('build_year')->sortable(),
                TextColumn::make('developer_name')->sortable(),
                ImageColumn::make('image_url')->sortable()->label('Image'),
                TextColumn::make('created_at')->date()
            ])
            ->filters([
                //
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
            UnitsRelationManager::class,
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

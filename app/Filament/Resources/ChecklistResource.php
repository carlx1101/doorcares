<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Unit;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Checklist;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ChecklistResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ChecklistResource\RelationManagers;
use App\Filament\Resources\ChecklistResource\RelationManagers\ItemsRelationManager;

class ChecklistResource extends Resource
{
    protected static ?string $model = Checklist::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Details ')->schema([
                    Select::make('unit_id')
                        ->label('Unit')
                        ->relationship('unit', 'id') // Use 'id' as the relationship field
                        ->getOptionLabelUsing(fn ($value) => Unit::with('property')->find($value)?->property->property_name
                            . ' - Block ' . Unit::find($value)?->block
                            . ', Level ' . Unit::find($value)?->level
                            . ', Unit ' . Unit::find($value)?->unit) // Combine property and unit details
                        ->getSearchResultsUsing(fn (string $query) => Unit::with('property')
                            ->whereHas('property', fn ($q) => $q->where('property_name', 'like', "%$query%"))
                            ->orWhere('block', 'like', "%$query%")
                            ->orWhere('level', 'like', "%$query%")
                            ->orWhere('unit', 'like', "%$query%")
                            ->get()
                            ->mapWithKeys(fn ($unit) => [
                                $unit->id => $unit->property->property_name
                                    . ' - Block ' . $unit->block
                                    . ', Level ' . $unit->level
                                    . ', Unit ' . $unit->unit,
                            ]))
                            ->required()
                            ->columns(1)
                        ->searchable(),
                        
                        Select::make('tenant_id')
                            ->label('Tenant')
                            ->relationship('tenant', 'full_name') // Show tenant details
                            ->searchable()
                            ->columns(1)
                            ->required(),
                        ])->columns(2),
                    
                Repeater::make('items')
                    ->relationship('items') // Handles related ChecklistItem models
                    ->schema([
                        Select::make('space_id')
                            ->label('Space')
                            ->relationship('space', 'space_name') // Show space names
                            ->required(),
                        FileUpload::make('photo_path')
                            ->label('Photo')
                            ->directory('checklist-photos')
                            ->nullable(),
                        Textarea::make('remark')
                            ->label('Remark')
                            ->rows(3)
                            ->nullable(),
                    ])->columns(1)
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unit.property.property_name'),
                TextColumn::make('unit.title')->label('Unit'),
                TextColumn::make('tenant.full_name')->label('Tenant'),
                TextColumn::make('created_at')->label('Created At')->dateTime(),
            ])
            ->filters([
                // SelectFilter::make('unit_id')
                //     ->label('Unit')
                //     ->relationship('unit', 'title'),

                SelectFilter::make('tenant_id')
                    ->label('Tenant')
                    ->relationship('tenant', 'full_name'),
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
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChecklists::route('/'),
            'create' => Pages\CreateChecklist::route('/create'),
            'edit' => Pages\EditChecklist::route('/{record}/edit'),
        ];
    }
}

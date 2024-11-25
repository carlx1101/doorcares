<?php

namespace App\Filament\Resources\ChecklistResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Space;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'Items';

    protected static ?string $recordTitleAttribute = 'space.space_name'; // Show space names in the relation manager

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('space_id')
                    ->label('Space')
                    ->options(function (RelationManager $livewire) {
                        // Dynamically fetch spaces for the current unit
                        $unitId = $livewire->ownerRecord->unit_id;

                        return Space::where('unit_id', $unitId)
                            ->pluck('space_name', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->required(),
                FileUpload::make('photo_path')
                    ->label('Photo')
                    ->directory('checklist-photos')
                    ->nullable(),
                Textarea::make('remark')
                    ->label('Remark')
                    // ->rows()
                    ->nullable(),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('space')
            ->columns([
                TextColumn::make('space.space_name')->label('Space'),
                ImageColumn::make('photo_path')->label('Photo'),
                TextColumn::make('remark')->label('Remark'),
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

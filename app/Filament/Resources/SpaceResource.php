<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Unit;
use Filament\Tables;
use App\Models\Space;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SpaceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SpaceResource\RelationManagers;
use App\Filament\Resources\UnitResource\RelationManagers\SpaceRelationManager;

class SpaceResource extends Resource
{
    protected static ?string $model = Space::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Hides this resource from the sidebar
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('unit_id')->label('Unit')->required()
                    ->relationship('Unit','title')->searchable()
                    ->getSearchResultsUsing(fn (string $query) => Unit::where('block', 'like', "%$query%")
                    ->orWhere('level', 'like', "%$query%")
                    ->orWhere('unit', 'like', "%$query%")
                    ->get()
                    ->mapWithKeys(fn ($unit) => [
                        $unit->id => "Block {$unit->block} - Level {$unit->level}, Unit {$unit->unit}",
                    ])),
                TextInput::make('space_name')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpaces::route('/'),
            'create' => Pages\CreateSpace::route('/create'),
            'edit' => Pages\EditSpace::route('/{record}/edit'),
        ];
    }
}

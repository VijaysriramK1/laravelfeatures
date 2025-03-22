<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassRoutineResource\Pages;
use App\Filament\Resources\ClassRoutineResource\RelationManagers;
use App\Models\ClassRoutine;
use App\SmClassRoutine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassRoutineResource extends Resource
{
    protected static ?string $model = SmClassRoutine::class;
    protected static ?string $navigationLabel = 'Class Routine';
    protected static ?string $navigationGroup = 'Academics';
   

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassRoutines::route('/'),
            'create' => Pages\CreateClassRoutine::route('/create'),
            'edit' => Pages\EditClassRoutine::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GenerateIDCardResource\Pages;
use App\Filament\Resources\GenerateIDCardResource\RelationManagers;
use App\Models\GenerateIDCard;
use App\SmStudentIdCard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GenerateIDCardResource extends Resource
{
    protected static ?string $model = SmStudentIdCard::class;

    protected static ?string $navigationGroup = 'Admission Section';
    protected static ?string $navigationLabel = 'Generate ID Card';

   

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
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
            'index' => Pages\ListGenerateIDCards::route('/'),
            'create' => Pages\CreateGenerateIDCard::route('/create'),
            'edit' => Pages\EditGenerateIDCard::route('/{record}/edit'),
        ];
    }
}

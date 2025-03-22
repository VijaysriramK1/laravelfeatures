<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassRoomResource\Pages;
use App\Filament\Resources\ClassRoomResource\RelationManagers;
use App\Models\ClassRoom;
use App\SmClassRoom;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class ClassRoomResource extends Resource
{
    protected static ?string $model = SmClassRoom::class;

    protected static ?string $navigationLabel = 'Class Room';
    protected static ?string $navigationGroup = 'Academics';
  
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Class Room')
               
                ->schema([
                TextInput::make('room_no')
                    ->required()
                    ->label('Room No'),
                TextInput::make('capacity')
                ->required()
                ->label('Capacity'),
                    ])
           
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('No.')
                    ->rowIndex(),
                TextColumn::make('room_no')
                    ->label('Room No')
                    ->searchable(),
                TextColumn::make('capacity')
                    ->label('Capacity')
                    ->sortable(),
            ])
            ->filters([
                // You can add filters here, for example:
                // Tables\Filters\SelectFilter::make('section')
                //     ->relationship('section', 'name'),
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
            // You can add relation managers here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassRooms::route('/'),
            'create' => Pages\CreateClassRoom::route('/create'),
            'edit' => Pages\EditClassRoom::route('/{record}/edit'),
        ];
    }
}
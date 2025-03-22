<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Filament\Resources\SubjectResource\RelationManagers;
use App\Models\Subject;
use App\SmSubject;
use Dompdf\FrameDecorator\Text;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubjectResource extends Resource
{
    protected static ?string $model = SmSubject::class;
    protected static ?string $navigationLabel = 'Subject';

    
    protected static ?string $navigationGroup = 'Academics';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('subject_name')->required(),
                TextInput::make('subject_code')->required(),
                Select::make('duration_type')->options([
                    'Hours' => 'Hours',
                    'Days' => 'Days',
                    'Weeks' => 'Weeks',
                ])->required(),
                TextInput::make('duration')->required(),
                FileUpload::make('image')->required(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl'),
                TextColumn::make('subject_name'),
                TextColumn::make('subject_code'),
                TextColumn::make('duration_type'),
                TextColumn::make('duration'),
                TextColumn::make('image'),
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
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }

    
}

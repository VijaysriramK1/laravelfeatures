<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostalReceiveResource\Pages;
use App\Filament\Resources\PostalReceiveResource\RelationManagers;
use App\Models\PostalReceive;
use App\SmPostalReceive;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostalReceiveResource extends Resource
{
    protected static ?string $model = SmPostalReceive::class;

    protected static ?string $navigationGroup = 'Admission Section';

    protected static ?string $navigationLabel = 'Postal Receive';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               TextInput::make('from_title')->label('FROM TITLE')->required(),
               TextInput::make('reference_no')->label('REFERENCE NO')->required(),
               Textarea::make('address')->label('ADDRESS')->required()->columnSpanFull(),
               MarkdownEditor::make('note')->label('NOTE')->columnSpanFull(),
               TextInput::make('to_title')->label('TO TITLE')->required(),
               DatePicker::make('date')->label('DATE'),
               FileUpload::make('file')->label('FILE')->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('from_title')->label('From Title'),
            TextColumn::make('reference_no')->label('Reference No'),
            TextColumn::make('address')
                ->label('Address')
                ->listWithLineBreaks() 
                ->wrap(), 
            TextColumn::make('to_title')->label('To Title'),
            TextColumn::make('note')
                ->label('Note')
                ->listWithLineBreaks() 
                ->wrap(), 
            TextColumn::make('date')->label('Date'),
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
            'index' => Pages\ListPostalReceives::route('/'),
            'create' => Pages\CreatePostalReceive::route('/create'),
            'edit' => Pages\EditPostalReceive::route('/{record}/edit'),
        ];
    }
}

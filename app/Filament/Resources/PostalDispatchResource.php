<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostalDispatchResource\Pages;
use App\Filament\Resources\PostalDispatchResource\RelationManagers;
use App\Models\PostalDispatch;
use App\SmPostalDispatch;
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

class PostalDispatchResource extends Resource
{
    protected static ?string $model = SmPostalDispatch::class;

    protected static ?string $navigationGroup = 'Admission Section';
    protected static ?string $navigationLabel = 'Postal Dispatch';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                TextInput::make('to_title')->label('TO TITLE')->required(),
                TextInput::make('reference_no')->label('REFERENCE NO')->required(),
                Textarea::make('address')->label('ADDRESS')->required()->columnSpanFull(),
                MarkdownEditor::make('note')->label('NOTE')->columnSpanFull(),
                TextInput::make('from_title')->label('FROM TITLE')->required(),
                DatePicker::make('date')->label('DATE'),
                FileUpload::make('file')->label('FILE')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('to_title')->label('To Title'),
                TextColumn::make('reference_no')->label('Reference No'),
                TextColumn::make('address')
                    ->label('Address')
                    ->listWithLineBreaks() 
                    ->wrap(), 
                TextColumn::make('from_title')->label('To Title'),
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
            'index' => Pages\ListPostalDispatches::route('/'),
            'create' => Pages\CreatePostalDispatch::route('/create'),
            'edit' => Pages\EditPostalDispatch::route('/{record}/edit'),
        ];
    }
}

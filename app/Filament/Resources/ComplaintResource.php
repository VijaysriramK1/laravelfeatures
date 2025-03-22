<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComplaintResource\Pages;
use App\Filament\Resources\ComplaintResource\RelationManagers;
use App\Models\Complaint;
use App\SmComplaint;
use App\SmSetupAdmin;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use League\CommonMark\Input\MarkdownInput;
use League\CommonMark\Parser\MarkdownParser;

class ComplaintResource extends Resource
{
    protected static ?string $model = SmComplaint::class;
    protected static ?string $navigationGroup = 'Admission Section';
    protected static ?string $navigationLabel = 'Complaint';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('complaint_by')->label('Complaint By')->required(),
               
                    Select::make('complaint_type')
                    ->label('Complaint Type')
                    ->relationship('complaintType', 'name', fn ($query) => $query->where('type', 2))
                    ->placeholder('Complaint Type')->required(),

                    Select::make('complaint_source')
                    ->label('Complaint Source')
                    ->relationship('complaintSource', 'name', fn ($query) => $query->where('type', 3))
                    ->placeholder('Select a Source'),

                    TextInput::make('phone')->label('Phone'),
                    DatePicker::make('date')->label('Date')->columnSpanFull(),
                    TextInput::make('action_taken')->label('Actions Taken'),
                    TextInput::make('assigned')->label('Assigned'),
                    MarkdownEditor::make('description')->label('Description')->columnSpanFull(),
                    FileUpload::make('file')->label('File')->columnSpanFull(),


              
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl'),
                TextColumn::make('complaint_by')->label('Complaint By'),
                TextColumn::make('complaint_type')->label('Complaint Type')
                ->getStateUsing(fn($record) => $record->complaintType->name ?? 'No Source')
                ,
                TextColumn::make('complaint_source')->label('Source')
                ->getStateUsing(fn($record) => $record->complaintSource->name ?? 'No Source'),
                TextColumn::make('phone')->label('Phone'),
                TextColumn::make('date')->label('Date'),
               
                
            ])
            ->filters([
                
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
            'index' => Pages\ListComplaints::route('/'),
            'create' => Pages\CreateComplaint::route('/create'),
            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }
}

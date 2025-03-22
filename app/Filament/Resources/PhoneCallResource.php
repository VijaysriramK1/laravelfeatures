<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhoneCallResource\Pages;
use App\Filament\Resources\PhoneCallResource\RelationManagers;
use App\Models\PhoneCall;
use App\SmPhoneCallLog;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PhoneCallResource extends Resource
{
    protected static ?string $model = SmPhoneCallLog::class;

    protected static ?string $navigationGroup = 'Admission Section';

    protected static ?string $navigationLabel = 'Phone Call Log';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Name')->required(),
                TextInput::make('phone')->label('Phone')->required(),
                DatePicker::make('date')->label('Date')->required(),
                DatePicker::make('next_follow_up_date')->label('Follow Up Date')->required(),
                TextInput::make('call_duration')->label('call Duration')->columnSpanFull(),
                MarkdownEditor::make('description')->label('Description')->columnSpanFull(),
                Radio::make('call_type')
                    ->options([
                        'Incoming' => 'Incoming',
                        'Outgoing' => 'Outgoing',
                        
                    ])
                    ->default('Incoming') 
                    ->label('Type')
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name'),
                TextColumn::make('phone')->label('Phone'),

                TextColumn::make('date')->label('Date'),
                TextColumn::make('next_follow_up_date')->label('Follow Up Date'),
                TextColumn::make('call_duration')->label('call Duration'),
                TextColumn::make('description')
                    ->label('Description')
                    ->listWithLineBreaks()
                    ->wrap(),
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
            'index' => Pages\ListPhoneCalls::route('/'),
            'create' => Pages\CreatePhoneCall::route('/create'),
            'edit' => Pages\EditPhoneCall::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitorBookResource\Pages;
use App\Filament\Resources\VisitorBookResource\RelationManagers;
use App\Models\VisitorBook;
use App\SmVisitor;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitorBookResource extends Resource
{
    protected static ?string $model = SmVisitor::class;
    protected static ?string $navigationGroup = 'Admission Section';

    protected static ?string $navigationLabel = 'Visitor Book';
 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                TextInput::make('purpose')->label('PURPOSE')->required(),
                TextInput::make('name')->label('NAME')->required(),
                TextInput::make('phone')->label('PHONE')->required(),
                TextInput::make('no_of_person')->label('NO. OF PERSON')->required(),
                
                DatePicker::make('date')->label('DATE')->required()->columnSpanFull(),
                TimePicker::make('in_time')->label('IN TIME')->required(),
                TimePicker::make('out_time')->label('OUT TIME')->required(),
                FileUpload::make('file')->label('IMAGE')->required()->columnSpanFull(),




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl'),
                TextColumn::make('name')->label('Name'),
                TextColumn::make('no_of_person')->label('No. of Person'),
                TextColumn::make('phone')->label('Phone'),
                TextColumn::make('purpose')->label('Purpose'),
                TextColumn::make('date')->label('Date'),
                TextColumn::make('in_time')->label('In Time'),
                TextColumn::make('out_time')->label('Out Time'),
                TextColumn::make('user.full_name')->label('Created By')->searchable(),
                
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
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        TimePicker::make('in_time')->label('In time'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['in_time'], fn ($query, $date) => $query->whereDate('in_time', '>=', $date));
                    }),
                Tables\Filters\Filter::make('follow_up_date')
                    ->form([
                        TimePicker::make('out_time')->label('Out time'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['out_time'], fn ($query, $date) => $query->whereDate('out_time', '<=', $date));
                    }),
                    Tables\Filters\Filter::make('date')
                    ->form([
                        DatePicker::make('date')->label('Date'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['date'], fn ($query, $date) => $query->whereDate('date', '<=', $date));
                    })     
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(3);
            
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
            'index' => Pages\ListVisitorBooks::route('/'),
            'create' => Pages\CreateVisitorBook::route('/create'),
            'edit' => Pages\EditVisitorBook::route('/{record}/edit'),
        ];
    }
}

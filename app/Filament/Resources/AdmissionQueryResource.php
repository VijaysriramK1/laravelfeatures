<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdmissionQueryResource\Pages;
use App\Filament\Resources\AdmissionQueryResource\RelationManagers;
use App\Models\AdmissionQuery;
use App\SmAdmissionQuery;
use App\SmSetupAdmin;
use DateTime;
use DeepCopy\Filter\Filter;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Search;
use Predis\Command\Argument\Search\SchemaFields\TextField;

class AdmissionQueryResource extends Resource
{
    protected static ?string $model = SmAdmissionQuery::class;
    protected static ?string $navigationGroup = 'Admission Section';
    protected static ?string $navigationLabel = 'Admission Query';




    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        TextInput::make('name')
                            ->label('NAME')
                            ->required()
                            ->suffixIcon('heroicon-o-user'),

                        TextInput::make('phone')
                            ->label('PHONE')
                            ->required()
                            ->suffixIcon('heroicon-o-phone'),

                        TextInput::make('email')
                            ->label('EMAIL')
                            ->required()
                            ->email()
                            ->suffixIcon('heroicon-s-envelope'),
                    ]),
                Textarea::make('address')->label('ADDRESS'),
                Textarea::make('description')->label('DESCRIPTION'),
                Grid::make(3)
                    ->schema([
                        DatePicker::make('date')
                            ->label('DATE FORM')
                            ->required(),

                        DatePicker::make('follow_up_date')
                            ->label('NEXT FOLLOW UP DATE')
                            ->required(),

                        TextInput::make('assigned')
                            ->label('ASSIGNED')
                            ->required(),
                    ]),
                Grid::make(4)
                    ->schema([
                        Select::make('reference')
                            ->label('REFERENCE')
                            ->relationship('sourceSetup', 'name', fn ($query) => $query->where('type',4 ))
                            ->placeholder('Select a Reference'),

                            Select::make('source')
                            ->label('SOURCE')
                            ->relationship('sourceSetup', 'name', fn ($query) => $query->where('type', 3))
                            ->placeholder('Select a Source')
                            ,
                        

                        Select::make('class')
                            ->label('CLASS')
                            ->relationship('className', 'class_name')
                            ->placeholder('Select a Class')
                            ->required(),

                        TextInput::make('no_of_child')
                            ->label('NUMBER OF CHILD')
                            ->required(),
                    ]),

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl'),
                TextColumn::make('name')->label('Name'),
                TextColumn::make('phone')->label('Phone'),
                TextColumn::make('source')
                    ->label('Source')
                    ->getStateUsing(fn($record) => $record->sourceSetup->name ?? 'No Source'),
                TextColumn::make('active_status')
                    ->label('Status')
                    ->formatStateUsing(function ($record) {
                        switch ($record->active_status) {
                            case 1:
                                return 'Pending';
                            case 2:
                                return 'Converted';
                            default:
                                return 'Unknown';
                        }
                    })
                    ->badge()
                    ->color(function ($record) {
                        return match ($record->active_status) {
                            1 => 'danger',
                            2 => 'success',
                            default => 'secondary',
                        };
                    }),
                TextColumn::make('date')->label('Query Date'),
                TextColumn::make('follow_up_date')->label('Last Follow Up Date'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->searchable()
            ->filters([

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('date')->label('Date From'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['date'], fn($query, $date) => $query->whereDate('date', '>=', $date));
                    }),


                Tables\Filters\Filter::make('follow_up_date')
                    ->form([
                        DatePicker::make('follow_up_date')->label('Date To'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['follow_up_date'], fn($query, $date) => $query->whereDate('follow_up_date', '<=', $date));
                    }),


                SelectFilter::make('active_status')
                    ->label('Status')
                    ->options([
                        '1' => 'Pending',
                        '2' => 'Converted',
                    ]),


                    SelectFilter::make('source')
                    ->label('Source')
                    ->options(
                        SmSetupAdmin::where('type', 3)
                            ->pluck('name', 'id') 
                            ->toArray()
                    ),   
            ], layout: FiltersLayout::AboveContent);
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
            'index' => Pages\ListAdmissionQueries::route('/'),
            'create' => Pages\CreateAdmissionQuery::route('/create'),
            'edit' => Pages\EditAdmissionQuery::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassResource\Pages;
use App\Filament\Resources\ClassResource\RelationManagers;
use App\Models\Class;
use App\SmClass;
use App\SmClassSection;
use App\SmSection;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Chat\Entities\Group;

class ClassResource extends Resource
{
    protected static ?string $model = SmClass::class;
    protected static ?string $navigationLabel = 'Class';
    protected static ?string $navigationGroup = 'Academics';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('class_name')
                    ->label('Class Name')
                    ->required()
                    ->maxLength(255)->columnSpanFull(),

                Radio::make('section_id')
                    ->label('Section')
                    ->options(
                        SmSection::where('school_id', Auth::user()->school_id)
                            ->pluck('section_name', 'id')
                    )
                    ->required()


            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('class_name'),
                TextColumn::make('classSection.sectionName.section_name')
                    ->label('Sections')
                    ->getStateUsing(function ($record) {
                        return $record->classSections
                            ->pluck('sectionName.section_name')
                            ->implode(', ');
                    }),
                TextColumn::make('records_count')
                    ->counts('records')
                    ->label('Students')
            ])

            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClasses::route('/'),
            'create' => Pages\CreateClass::route('/create'),
            'edit' => Pages\EditClass::route('/{record}/edit'),
        ];
    }

    public static function beforeCreate(array $data): array
    {
        $data['school_id'] = Auth::user()->school_id;
        
        return $data;
    }
}

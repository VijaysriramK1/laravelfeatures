<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignClassTeacherResource\Pages;
use App\Filament\Resources\AssignClassTeacherResource\RelationManagers;
use App\Models\AssignClassTeacher;
use App\SmAssignClassTeacher;
use App\SmClass;
use App\SmClassSection;
use App\SmSection;
use App\SmStaff;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AssignClassTeacherResource extends Resource
{
    protected static ?string $model = SmAssignClassTeacher::class;

    protected static ?string $navigationLabel = 'Assign Class Teacher';
    protected static ?string $navigationGroup = 'Academics';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                $table = Select::make('class_id')
                    ->label('Class')
                    ->options(
                        SmClass::query()
                            ->pluck('class_name', 'id')
                            ->toArray()
                    )
                    ->required()
                    ->preload()
                    ->native(false)
                    ->searchable()
                    ->columnSpanFull(),

                Select::make('section_id')
                    ->label('Section')
                    ->options(function () use ($table) {
                        $state = $table->getState();

                        $sections = SmClassSection::query()
                            ->where('class_id', $state)
                            ->pluck('section_id');
                        $section = SmSection::query()
                            ->whereIn('id', $sections)
                            ->pluck('section_name', 'id');
                        return $section->toArray();
                    })
                    ->required()
                    ->preload()
                    ->native(false)
                    ->searchable()
                    ->columnSpanFull(),

                Radio::make('Teacher')
                    ->options(
                        SmStaff::where('role_id', 4)
                            ->pluck('full_name', 'id')
                            ->toArray()
                    )
                    ->label('Assign Staff')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('class.class_name')
                ->label('Class'),
                TextColumn::make('section.section_name')
                ->label('Section'),
                TextColumn::make('classTeachers.teacher.full_name')
                ->label('Teacher'),
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
            'index' => Pages\ListAssignClassTeachers::route('/'),
            'create' => Pages\CreateAssignClassTeacher::route('/create'),
            'edit' => Pages\EditAssignClassTeacher::route('/{record}/edit'),
        ];
    }
    public static function beforeCreate(array $data): array
    {
        $data['school_id'] = Auth::user()->school_id;
        
        return $data;
    }
}

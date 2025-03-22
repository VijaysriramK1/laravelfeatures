<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignSubjectResource\Pages;
use App\Filament\Resources\AssignSubjectResource\RelationManagers;
use App\Models\AssignSubject;
use App\SmAssignSubject;
use App\SmClass;
use App\SmClassSection;
use App\SmSection;
use App\SmStaff;
use App\SmSubject;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssignSubjectResource extends Resource
{
    protected static ?string $model = SmAssignSubject::class;

    protected static ?string $navigationLabel = 'Assign Subject';
    protected static ?string $navigationGroup = 'Academics';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Assign Subject')
                    ->schema([
                        $table = Select::make('class_id')
                            ->label('Class')
                            ->options(
                                SmClass::query()
                                    ->pluck('class_name', 'id')
                                    ->toArray()
                            )
                            ->required()

                            ->reactive(),

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

                            ->disabled(fn(callable $get) => !$get('class_id'))
                            ->reactive(),
                    ])
                    ->columns(2),

                Repeater::make('subject_assignments')
                    ->schema([
                        Select::make('subject_id')
                            ->label('Subject')
                            ->options(
                                SmSubject::query()
                                    ->pluck('subject_name', 'id')
                                    ->toArray()
                            )
                            ->required(),

                        Select::make('teacher_id')
                            ->label('Teacher')
                            ->options(
                                SmStaff::query()
                                    ->where('role_id', 4)
                                    ->pluck('full_name', 'id')
                                    ->toArray()
                            )
                            ->required()
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->disabled(fn(callable $get) => !$get('class_id') || !$get('section_id'))
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject.subject_name'),
                TextColumn::make('teacher.full_name'),
            ])
            ->filters([
                SelectFilter::make('class_id')
                    ->label('Class')
                    ->options(
                        SmClass::query()
                            ->pluck('class_name', 'id')
                            ->toArray()
                    )
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            return $query->where('class_id', $data['value']);
                        }
                    }),
                
                SelectFilter::make('section_id')
                    ->label('Section')
                    ->options(function () use ($table) {
                        $classId = request()->get('tableFilters')['class_id'] ?? null;
                        if (!$classId) {
                            return SmSection::query()
                                ->pluck('section_name', 'id')
                                ->toArray();
                        }
                        return SmClassSection::query()
                            ->where('class_id', $classId)
                            ->join('sm_sections', 'sm_class_sections.section_id', '=', 'sm_sections.id')
                            ->pluck('sm_sections.section_name', 'sm_sections.id')
                            ->toArray();
                    })
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            return $query->where('section_id', $data['value']);
                        }
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(2)

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
            'index' => Pages\ListAssignSubjects::route('/'),
            'create' => Pages\CreateAssignSubject::route('/create'),
            'edit' => Pages\EditAssignSubject::route('/{record}/edit'),
        ];
    }
}

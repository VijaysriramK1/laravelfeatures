<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OptionalSubjectResource\Pages;
use App\Filament\Resources\OptionalSubjectResource\RelationManagers;
use App\Models\OptionalSubject;
use App\Models\StudentRecord;
use App\SmAcademicYear;
use App\SmAssignClassTeacher;
use App\SmAssignSubject;
use App\SmClass;
use App\SmClassSection;
use App\SmOptionalSubjectAssign;
use App\SmSection;
use App\SmStudent;
use App\SmSubject;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Collection;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class OptionalSubjectResource extends Resource
{
    protected static ?string $model = StudentRecord::class;

    protected static ?string $navigationLabel = 'Optional Subject';
    protected static ?string $navigationGroup = 'Academics';




    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Sl')
                    ->rowIndex(),
                TextColumn::make('student.admission_no')->label('Admission No'),
                TextColumn::make('student.full_name')
                    ->label('Name'),
                TextColumn::make('Subjects.subject.subject_name')->label('Subject Name'),
            ])


            ->filters([
                $table = SelectFilter::make('class_id')
                    ->label('Class')
                    ->options(
                        SmClass::query()
                            ->pluck('class_name', 'id')
                            ->toArray()
                    ),

                SelectFilter::make('section_id')
                    ->label('Section')
                    ->options(function () use ($table) {
                        $state = $table->getState();
                        $sections = SmAssignSubject::query()
                            ->where('class_id', $state)
                            ->pluck('section_id');
                        $section = SmSection::query()
                            ->whereIn('id', $sections)
                            ->pluck('section_name', 'id');
                        return $section->toArray();
                    }),


            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(2)


            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('delete')
                    ->requiresConfirmation()
                    ->action(fn(Collection $records) => $records->each->delete())
                    ->color('danger'),
                BulkAction::make('Assign Subject')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-document-text')
                    ->action(function ($records) {

                        $sessionId = SmAcademicYear::where('active_status', true)
                            ->orWhere('id', SmAcademicYear::max('id'))
                            ->first()?->id;


                        if (!$sessionId) {
                            Filament::notify('error', 'No active academic year found.');
                            return;
                        }

                        foreach ($records as $record) {
                            $subjectId = SmAssignSubject::query()
                                ->where('section_id', $record->section_id)
                                ->where('class_id', $record->class_id)
                                ->pluck('subject_id')
                                ->first();

                            if ($subjectId) {
                                SmOptionalSubjectAssign::updateOrCreate(
                                    [
                                        'student_id' => $record->student_id,
                                        'session_id' => $sessionId
                                    ],
                                    [
                                        'subject_id' => $subjectId,
                                    ]
                                );
                            } else {
                                Notification::make()
                                    ->title('Subject Assignment Failed')
                                    ->body('No subject found for section ID: {$record->section_id} and class ID: {$record->class_id}.')
                                    ->danger()
                                    ->send();
                                return;
                            }
                        }
                        Notification::make()
                            ->title('Subjects Assigned')
                            ->body('Subjects have been successfully assigned to selected students.')
                            ->success()
                            ->send();
                    })
            ])
            ->searchable();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOptionalSubjects::route('/'),
            // 'create' => Pages\CreateOptionalSubject::route('/create'),
            // 'edit' => Pages\EditOptionalSubject::route('/{record}/edit'),
        ];
    }
}

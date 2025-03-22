<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GenerateCertificateResource\Pages;
use App\Filament\Resources\GenerateCertificateResource\RelationManagers;
use App\Http\Controllers\Admin\AdminSection\SmStudentCertificateController;
use App\Models\GenerateCertificate;
use App\Models\StudentRecord;
use App\SmClass;
use App\SmClassSection;
use App\SmSection;
use App\SmStudent;
use App\SmStudentCertificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\FrameDecorator\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Collection;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GenerateCertificateResource extends Resource
{
    protected static ?string $model = StudentRecord::class;
    protected static ?string $navigationGroup = 'Admission Section';
    protected static ?string $navigationLabel = 'Generate Certificate';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('student.admission_no')->label('Admission No'),
                TextColumn::make('student.full_name')->label('Student Name'),
                TextColumn::make('class.class_name')
                    ->label('Class(Sec)')
                    ->formatStateUsing(function ($record) {
                        return "{$record->class->class_name} ({$record->section->section_name})";
                    }),

                TextColumn::make('student.parents.fathers_name')->label('Father Name'),
                TextColumn::make('student.date_of_birth')->label('Date of Birth'),
                TextColumn::make('student.gender.base_setup_name')->label('Gender'),
                TextColumn::make('student.mobile')->label('Mobile'),

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
                        $sections = SmClassSection::query()
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('delete')
                    ->requiresConfirmation()
                    ->action(fn(Collection $records) => $records->each->delete()),
                BulkAction::make('Create Certificate')
                    ->requiresConfirmation()
                    ->action(fn(EloquentCollection $records) => $records->each(function ($record) {
                        try {

                            $s_id = $record->student_id;
                            $c_id = $record->class_id;


                            $s_ids = explode('-', $s_id);
                            $students = [];
                            foreach ($s_ids as $sId) {
                                $students[] = StudentRecord::with('student')->find($sId);
                            }


                            $certificate = SmStudentCertificate::find($c_id);


                            if (moduleStatusCheck('University')) {
                                if ($certificate->type == "arabic") {

                                    return view('backEnd.admin.generate_arabic_certificate', compact('students', 'certificate'));
                                }
                            } else {
                                $pdf = Pdf::loadView('backEnd.admin.student_certificate_print', ['students' => $students, 'certificate' => $certificate]);
                                $pdf->setPaper('A4', 'landscape');
                                return $pdf->stream('certificate.pdf');
                            }
                        } catch (\Exception $e) {
                        }
                    }))


            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGenerateCertificates::route('/'),
            'create' => Pages\CreateGenerateCertificate::route('/create'),
            'edit' => Pages\EditGenerateCertificate::route('/{record}/edit'),
        ];
    }
}

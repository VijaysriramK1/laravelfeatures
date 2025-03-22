<?php

namespace App\Filament\Resources\AssignSubjectResource\Pages;

use App\Filament\Resources\AssignSubjectResource;
use App\Models\AssignSubject;
use App\SmAssignSubject;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateAssignSubject extends CreateRecord
{
    protected static string $resource = AssignSubjectResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $classId = $data['class_id'];
        $sectionId = $data['section_id'];


        $uniqueAssignments = collect($data['subject_assignments'])
            ->unique(function ($assignment) {
                return $assignment['subject_id'] . '-' . $assignment['teacher_id'];
            });


        $assignmentsToInsert = $uniqueAssignments->map(function ($assignment) use ($classId, $sectionId) {
            return [
                'class_id' => $classId,
                'section_id' => $sectionId,
                'subject_id' => $assignment['subject_id'],
                'teacher_id' => $assignment['teacher_id'],
               
            ];
        });

            $assignmentsToInsert->each(function ($assignment) {
                SmAssignSubject::create($assignment);
            });
        
       

        return [];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

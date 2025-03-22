<?php

namespace App\Filament\Resources\AssignClassTeacherResource\Pages;

use App\Filament\Resources\AssignClassTeacherResource;
use App\SmAssignClassTeacher;
use App\SmClassTeacher;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateAssignClassTeacher extends CreateRecord
{
    protected static string $resource = AssignClassTeacherResource::class;

    protected function handleRecordCreation(array $data): SmAssignClassTeacher
    {
       return DB::transaction(function () use ($data) {
           $processedData = AssignClassTeacherResource::beforeCreate($data);
    
           $class = SmAssignClassTeacher::create([
               'class_id' => $data['class_id'],
               'section_id' => $data['section_id']
           ]);
    
           SmClassTeacher::create([
               'teacher_id' => $data['Teacher'],
               'assign_class_teacher_id' => $class->id
           ]);
    
           return $class;
       });
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

<?php

namespace App\Filament\Resources\ClassResource\Pages;

use App\Filament\Resources\ClassResource;
use App\Http\Controllers\Admin\Academics\SmClassController;
use App\Models\SmClass;
use App\Models\SmClassSection;
use App\SmClass as AppSmClass;
use App\SmClassSection as AppSmClassSection;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateClass extends CreateRecord
{
    protected static string $resource = ClassResource::class;

    protected function handleRecordCreation(array $data): AppSmClass
    {
        return DB::transaction(function () use ($data) {
            $processedData = ClassResource::beforeCreate($data);

            $class = AppSmClass::create([
                'class_name' => $processedData['class_name'],
                'school_id' => $processedData['school_id'],
                'academic_id' => $processedData['academic_id'] ?? 1, 
            ]);

            AppSmClassSection::create([
                'class_id' => $class->id,
                'section_id' => $processedData['section_id'],
                'school_id' => $processedData['school_id']
            ]);

            return $class;
        });
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

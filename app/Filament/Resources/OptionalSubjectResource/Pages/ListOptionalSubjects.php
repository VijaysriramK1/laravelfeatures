<?php

namespace App\Filament\Resources\OptionalSubjectResource\Pages;

use App\Filament\Resources\OptionalSubjectResource;
use App\Models\StudentRecord;
use App\SmOptionalSubjectAssign;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListOptionalSubjects extends ListRecords
{
    protected static string $resource = OptionalSubjectResource::class;

    protected static ?string $title = 'Optional Subjects';

    public function getTabs(): array 
{
    return [
        'All Students' => Tab::make()
            ->label('All Students')
            ->badge(
                StudentRecord::whereNotIn('id', 
                    SmOptionalSubjectAssign::pluck('student_id')
                )->count()
            )
            ->query(fn ($query) => $query->whereNotIn('id', 
                SmOptionalSubjectAssign::pluck('student_id')
            )), 
        
        'Assigned Students' => Tab::make()
            ->label('Assigned Students')
            ->badge(SmOptionalSubjectAssign::count())
            ->query(fn ($query) => $query
                ->whereIn('id', 
                    SmOptionalSubjectAssign::pluck('student_id')
                )
            ),
    ];
}
}

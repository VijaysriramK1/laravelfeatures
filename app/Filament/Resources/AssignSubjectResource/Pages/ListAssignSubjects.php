<?php

namespace App\Filament\Resources\AssignSubjectResource\Pages;

use App\Filament\Resources\AssignSubjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssignSubjects extends ListRecords
{
    protected static string $resource = AssignSubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Add'),
        ];
    }
}

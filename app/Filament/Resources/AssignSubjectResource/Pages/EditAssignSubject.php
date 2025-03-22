<?php

namespace App\Filament\Resources\AssignSubjectResource\Pages;

use App\Filament\Resources\AssignSubjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssignSubject extends EditRecord
{
    protected static string $resource = AssignSubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

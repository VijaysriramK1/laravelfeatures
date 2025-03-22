<?php

namespace App\Filament\Resources\OptionalSubjectResource\Pages;

use App\Filament\Resources\OptionalSubjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOptionalSubject extends EditRecord
{
    protected static string $resource = OptionalSubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

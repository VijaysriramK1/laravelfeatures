<?php

namespace App\Filament\Resources\VisitorBookResource\Pages;

use App\Filament\Resources\VisitorBookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVisitorBook extends EditRecord
{
    protected static string $resource = VisitorBookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

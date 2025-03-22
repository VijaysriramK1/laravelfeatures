<?php

namespace App\Filament\Resources\GenerateIDCardResource\Pages;

use App\Filament\Resources\GenerateIDCardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGenerateIDCard extends EditRecord
{
    protected static string $resource = GenerateIDCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

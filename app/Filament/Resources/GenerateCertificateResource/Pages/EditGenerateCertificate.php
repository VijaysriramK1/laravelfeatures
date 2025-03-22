<?php

namespace App\Filament\Resources\GenerateCertificateResource\Pages;

use App\Filament\Resources\GenerateCertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGenerateCertificate extends EditRecord
{
    protected static string $resource = GenerateCertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

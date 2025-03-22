<?php

namespace App\Filament\Resources\GenerateCertificateResource\Pages;

use App\Filament\Resources\GenerateCertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGenerateCertificates extends ListRecords
{
    protected static string $resource = GenerateCertificateResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}

<?php

namespace App\Filament\Resources\PhoneCallResource\Pages;

use App\Filament\Resources\PhoneCallResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPhoneCall extends EditRecord
{
    protected static string $resource = PhoneCallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

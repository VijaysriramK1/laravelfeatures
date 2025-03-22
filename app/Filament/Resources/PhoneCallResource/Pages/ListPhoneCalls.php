<?php

namespace App\Filament\Resources\PhoneCallResource\Pages;

use App\Filament\Resources\PhoneCallResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPhoneCalls extends ListRecords
{
    protected static string $resource = PhoneCallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Add'),
        ];
    }
}

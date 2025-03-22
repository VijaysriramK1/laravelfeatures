<?php

namespace App\Filament\Resources\PostalReceiveResource\Pages;

use App\Filament\Resources\PostalReceiveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostalReceive extends EditRecord
{
    protected static string $resource = PostalReceiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

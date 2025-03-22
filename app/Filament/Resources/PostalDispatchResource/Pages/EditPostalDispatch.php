<?php

namespace App\Filament\Resources\PostalDispatchResource\Pages;

use App\Filament\Resources\PostalDispatchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostalDispatch extends EditRecord
{
    protected static string $resource = PostalDispatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

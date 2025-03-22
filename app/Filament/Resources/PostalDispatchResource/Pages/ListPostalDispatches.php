<?php

namespace App\Filament\Resources\PostalDispatchResource\Pages;

use App\Filament\Resources\PostalDispatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostalDispatches extends ListRecords
{
    protected static string $resource = PostalDispatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Add'),
        ];
    }
}

<?php

namespace App\Filament\Resources\PostalReceiveResource\Pages;

use App\Filament\Resources\PostalReceiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostalReceives extends ListRecords
{
    protected static string $resource = PostalReceiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Add'),
        ];
    }
}

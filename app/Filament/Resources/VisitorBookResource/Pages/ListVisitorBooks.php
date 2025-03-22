<?php

namespace App\Filament\Resources\VisitorBookResource\Pages;

use App\Filament\Resources\VisitorBookResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVisitorBooks extends ListRecords
{
    protected static string $resource = VisitorBookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Add'),
        ];
    }
}

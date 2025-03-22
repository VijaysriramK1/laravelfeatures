<?php

namespace App\Filament\Resources\GenerateIDCardResource\Pages;

use App\Filament\Resources\GenerateIDCardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGenerateIDCards extends ListRecords
{
    protected static string $resource = GenerateIDCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Add'),
        ];
    }
}

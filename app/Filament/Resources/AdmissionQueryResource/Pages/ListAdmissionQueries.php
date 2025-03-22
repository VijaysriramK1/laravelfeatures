<?php

namespace App\Filament\Resources\AdmissionQueryResource\Pages;

use App\Filament\Resources\AdmissionQueryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAdmissionQueries extends ListRecords
{
    protected static string $resource = AdmissionQueryResource::class;

    protected static ?string $title = 'Admission Query';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Pending' => Tab::make()
                ->label('Pending')
                ->modifyQueryUsing(function (Builder $query) { 
                    $query->where('active_status', 1); 
                })
                ->badge(fn (): int => $this->getFilteredTableRecordCount('active_status', 1)), 

            'Converted' => Tab::make()
                ->label('Converted')
                ->modifyQueryUsing(function (Builder $query) { 
                    $query->where('active_status', 2); 
                })
                ->badge(fn (): int => $this->getFilteredTableRecordCount('active_status', 2)), 
        ];
    }

    private function getFilteredTableRecordCount(string $column, int $value): int
    {
        return AdmissionQueryResource::getModel()::query()
            ->where($column, $value)
            ->count();
    }
}

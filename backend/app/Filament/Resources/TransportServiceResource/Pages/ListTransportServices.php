<?php

namespace App\Filament\Resources\TransportServiceResource\Pages;

use App\Filament\Resources\TransportServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransportServices extends ListRecords
{
    protected static string $resource = TransportServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

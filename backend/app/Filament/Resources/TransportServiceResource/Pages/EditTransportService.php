<?php

namespace App\Filament\Resources\TransportServiceResource\Pages;

use App\Filament\Resources\TransportServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransportService extends EditRecord
{
    protected static string $resource = TransportServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

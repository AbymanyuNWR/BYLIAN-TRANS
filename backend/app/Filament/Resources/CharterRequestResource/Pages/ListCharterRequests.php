<?php

namespace App\Filament\Resources\CharterRequestResource\Pages;

use App\Filament\Resources\CharterRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCharterRequests extends ListRecords
{
    protected static string $resource = CharterRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

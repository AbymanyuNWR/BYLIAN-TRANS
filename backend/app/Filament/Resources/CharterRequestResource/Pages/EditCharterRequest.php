<?php

namespace App\Filament\Resources\CharterRequestResource\Pages;

use App\Filament\Resources\CharterRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCharterRequest extends EditRecord
{
    protected static string $resource = CharterRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\DataPersonelResource\Pages;

use App\Filament\Resources\DataPersonelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataPersonel extends EditRecord
{
    protected static string $resource = DataPersonelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

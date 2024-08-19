<?php

namespace App\Filament\Resources\DataPersonelResource\Pages;

use App\Filament\Resources\DataPersonelResource;
use App\Imports\DataPersonelImport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataPersonels extends ListRecords
{
    protected static string $resource = DataPersonelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                // ->slideOver()
                ->color("primary")
                ->use(DataPersonelImport::class),
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return DataPersonelResource::getWidgets();
    }
}

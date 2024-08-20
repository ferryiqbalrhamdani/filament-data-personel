<?php

namespace App\Filament\Resources\DataPersonelResource\Pages;

use Filament\Actions;
use App\Imports\DataPersonelImport;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DataPersonelResource;
use App\Models\DataPersonel;
use Filament\Pages\Concerns\ExposesTableToWidgets;

class ListDataPersonels extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = DataPersonelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Download Template')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    return response()->download(
                        public_path('storage/upload_data_personel.csv'),
                        'template_upload_data_personel.csv'
                    );
                }),
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("primary")
                ->use(DataPersonelImport::class),
            // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return DataPersonelResource::getWidgets();
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->badge(fn() => number_format($this->getAllCount(), 0, ',', '.')),

            'selected' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_selected', true))
                ->badge(fn() => number_format($this->getSelectedCount(), 0, ',', '.')),

            'unselected' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_selected', false))
                ->badge(fn() => number_format($this->getUnselectedCount(), 0, ',', '.')),
        ];
    }

    protected function getAllCount(): int
    {
        return DataPersonel::count();
    }

    protected function getSelectedCount(): int
    {
        return DataPersonel::where('is_selected', true)->count();
    }

    protected function getUnselectedCount(): int
    {
        return DataPersonel::where('is_selected', false)->count();
    }
}

<?php

namespace App\Filament\Resources\DataPersonelResource\Widgets;

use App\Filament\Resources\DataPersonelResource\Pages\ListDataPersonels;
use App\Models\DataPersonel;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DataPersonelStats extends BaseWidget
{

    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListDataPersonels::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Personel', number_format($this->getPageTableQuery()->count(), 0, ',', '.')),
            Stat::make('Total Pati', function () {
                return number_format(
                    $this->getPageTableQuery()
                        ->where('kelompok_pangkat', 'Pati')
                        ->count(),
                    0,
                    ',',
                    '.'
                );
            }),
            Stat::make('Total Pamenpama', function () {
                return number_format(
                    $this->getPageTableQuery()
                        ->where('kelompok_pangkat', '<', 'Pamenpama')
                        ->count(),
                    0,
                    ',',
                    '.'
                );
            }),
        ];
    }
}

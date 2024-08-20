<?php

namespace App\Exports;

use App\Models\DataPersonel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DataPersonelExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return DataPersonel::query();
    }

    public function headings(): array
    {
        return [
            'NRP',
            'Nama',
            'Pangkat',
            'Korp',
            'Satker',
            'Baju PDH',
            'Celana PDH',
            'PDH',
            'Baju PDU',
            'Celana PDU',
            'PDU',
            'PDL',
            // Tambahkan kolom lain sesuai kebutuhan
        ];
    }

    public function map($dataPersonel): array
    {
        return [
            "'" . $dataPersonel->nrp, // Menambahkan kutip satu di depan NRP
            $dataPersonel->nama,
            $dataPersonel->pangkat,
            $dataPersonel->korp,
            $dataPersonel->satker,
            $dataPersonel->baju_pdh,
            $dataPersonel->celana_pdh,
            $dataPersonel->pdh,
            $dataPersonel->baju_pdu,
            $dataPersonel->celana_pdu,
            $dataPersonel->pdu,
            $dataPersonel->pdl,
            // Mapping kolom lain sesuai kebutuhan
        ];
    }
}

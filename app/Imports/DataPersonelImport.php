<?php

namespace App\Imports;

use App\Models\DataPersonel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class DataPersonelImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        ini_set('max_execution_time', 0);
        ini_set("memory_limit", -1);

        foreach ($rows as $row) {
            try {
                DataPersonel::create([
                    'nama' => $row['nama'] ?? null,
                    'pangkat' => $row['pangkat'] ?? null,
                    'korp' => $row['korp'] ?? null,
                    'nrp' => $row['nrp'] ?? null,
                    'satker' => $row['satker'] ?? null,
                    'jk' => $row['jk'] ?? null,
                    'baju_pdh' => $row['baju_pdh'] ?? null,
                    'celana_pdh' => $row['celana_pdh'] ?? null,
                    'pdh' => $row['pdh'] ?? null,
                    'baju_pdu' => $row['baju_pdu'] ?? null,
                    'celana_pdu' => $row['celana_pdu'] ?? null,
                    'pdu' => $row['pdu'] ?? null,
                    'pdl' => $row['pdl'] ?? null,
                ]);
            } catch (\Exception $e) {
                Log::error('Error importing row: ' . json_encode($row));
                Log::error($e->getMessage());
                // Anda bisa menambahkan logika tambahan di sini, seperti
                // menyimpan baris yang gagal untuk diproses nanti
            }
        }
    }
}

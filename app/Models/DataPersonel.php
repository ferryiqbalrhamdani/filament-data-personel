<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPersonel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'pangkat',
        'korp',
        'nrp',
        'satker',
        'jk',
        'baju_pdh',
        'celana_pdh',
        'pdh',
        'baju_pdu',
        'celana_pdu',
        'pdu',
        'pdl',
    ];
}

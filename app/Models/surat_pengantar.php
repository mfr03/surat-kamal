<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surat_pengantar extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_surat',
        'nomor_surat',
        'letter_number',
        'name',
        'place_of_birth',
        'date_of_birth',
        'nationality',
        'job',
        'address',
        'id_number',
        'kartu_keluarga',
        'purpose',
        'Tujuan',
        'valid_from',
        'template_remarks',
        'remarks',
        'jabatan',
    ];
}

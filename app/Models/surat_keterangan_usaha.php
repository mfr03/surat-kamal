<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surat_keterangan_usaha extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'id_number',
        'jenis_kelamin',
        'religion',
        'nama_ibu_kandung',
        'nomor_hp',
        'domisili',
        'selama',
        'tujuan_surat',
        'letter_number',
        'kode_surat',
        'nomor_surat',
        'jabatan',
    ];

}

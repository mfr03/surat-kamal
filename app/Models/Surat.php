<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Surat extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date_of_birth',
        'place_of_birth',
        'nationality',
        'religion',
        'job',
        'address',
        'id_number',
        'letter_number',
        'nomor_surat',
        'purpose',
        'valid_from',
        'valid_until',
        'remarks',
        'jenis_id',
        'jenis_kelamin',
        'kartu_keluarga', 
        'nama_ibu_kandung', 
        'nomor_hp', 
        'kode_surat',
        'jabatan',
        'keterangan_usaha', 
        'domisili',
        'selama',
        'tujuan_surat',
    ];
    
    
    public function jenis(): BelongsTo
    {
        return $this->belongsTo(Jenis::class);
    }

}

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
        'purpose',
        'valid_from',
        'valid_until',
        'remarks',
        'jenis_id',
        'kartu_keluarga', // new field
        'nama_ibu_kandung', // new field
        'nomor_hp', // new field
        'keterangan_usaha', // new field
        'kode_surat', // new field
    ];
    
    
    public function jenis(): BelongsTo
    {
        return $this->belongsTo(Jenis::class);
    }

}

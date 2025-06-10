<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tStatusAkreditasi extends Model
{
    use HasFactory;

    protected $table = 't_status_akreditasis';
    protected $primaryKey = 'id_status_akreditasi';
    protected $fillable = [
        'file_akreditasi_id',
        'status_kaprodi',
        'komentar_kaprodi',
        'status_kajur',
        'komentar_kajur',
        'status_kjm',
        'komentar_kjm',
        'status_direktur_utama',
        'komentar_direktur_utama'
    ];

    public function fileAkreditasi()
    {
        return $this->belongsTo(TFileAkreditasi::class, 'file_akreditasi_id');
    }
}

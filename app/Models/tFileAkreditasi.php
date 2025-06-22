<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tFileAkreditasi extends Model
{
    use HasFactory;

    protected $table = 't_file_akreditasis';
    protected $primaryKey = 'id_file_akreditasi';
    protected $fillable = [
        'file_akreditasi',
        'akreditasi_id',
        'status_kaprodi',
        'komentar_kaprodi',
        'kaprodi_id',
        'tanggal_waktu_kaprodi',
        'status_kajur',
        'komentar_kajur',
        'kajur_id',
        'tanggal_waktu_kajur',
        'status_kjm',
        'komentar_kjm',
        'kjm_id',
        'tanggal_waktu_kjm',
        'status_direktur_utama',
        'komentar_direktur_utama',
        'direktur_utama_id',
        'tanggal_waktu_direktur_utama',
        'statusFile',
    ];

    protected $casts = [
        'tanggal_waktu_kaprodi' => 'datetime',
        'tanggal_waktu_kajur' => 'datetime',
        'tanggal_waktu_kjm' => 'datetime',
        'tanggal_waktu_direktur_utama' => 'datetime',
    ];

    public function akreditasi()
    {
        return $this->belongsTo(TAkreditasi::class, 'akreditasi_id');
    }

    // Relationship with Kaprodi (Kaprodi comments and status)
    public function kaprodi()
    {
        return $this->belongsTo(mUser::class, 'kaprodi_id');
    }

    // Relationship with Kajur (Kajur comments and status)
    public function kajur()
    {
        return $this->belongsTo(mUser::class, 'kajur_id');
    }

    // Relationship with KJM (KJM comments and status)
    public function kjm()
    {
        return $this->belongsTo(mUser::class, 'kjm_id');
    }

    // Relationship with Direktur Utama (Direktur Utama comments and status)
    public function direkturUtama()
    {
        return $this->belongsTo(mUser::class, 'direktur_utama_id');
    }
}

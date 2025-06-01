<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tAkreditasi extends Model
{
    use HasFactory;
    protected $table = 't_akreditasis';
    protected $primaryKey = 'id_akreditasi';
    protected $fillable = [
        'kriteria_id',
        'penetapan_id',
        'pelaksanaan_id',
        'evaluasi_id',
        'pengendalian_id',
        'peningkatan_id',
        'koordinator_id',
        'status'
    ];

    public function fileAkreditasi()
    {
        return $this->hasMany(tFileAkreditasi::class, 'akreditasi_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(mKriteria::class, 'kriteria_id');
    }

    public function koordinator()
    {
        return $this->belongsTo(mKoordinator::class, 'koordinator_id');
    }

    public function penetapan()
    {
        return $this->belongsTo(tPenetapan::class, 'penetapan_id');
    }

    public function pelaksanaan()
    {
        return $this->belongsTo(tPelaksanaan::class, 'pelaksanaan_id');
    }

    public function evaluasi()
    {
        return $this->belongsTo(tEvaluasi::class, 'evaluasi_id');
    }

    public function pengendalian()
    {
        return $this->belongsTo(tPengendalian::class, 'pengendalian_id');
    }

    public function peningkatan()
    {
        return $this->belongsTo(tPeningkatan::class, 'peningkatan_id');
    }


}

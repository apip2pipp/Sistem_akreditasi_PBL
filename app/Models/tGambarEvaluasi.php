<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tGambarEvaluasi extends Model
{
    use HasFactory;

    protected $table = 't_gambar_evaluasis';
    protected $primaryKey = 'id_gambar_evaluasi';
    protected $fillable = ['gambar_evaluasi', 'evaluasi_id', 'mime_type'];

    public function evaluasi()
    {
        return $this->belongsTo(TEvaluasi::class, 'evaluasi_id');
    }
}

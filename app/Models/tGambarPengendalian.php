<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tGambarPengendalian extends Model
{
    use HasFactory;

    protected $table = 't_gambar_pengendalians';
    protected $primaryKey = 'id_gambar_pengendalian';
    protected $fillable = ['gambar_pengendalian', 'pengendalian_id', 'mime_type'];

    public function pengendalian()
    {
        return $this->belongsTo(TPengendalian::class, 'pengendalian_id');
    }
}

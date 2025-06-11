<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tGambarPeningkatan extends Model
{
    use HasFactory;

    protected $table = 't_gambar_peningkatans';
    protected $primaryKey = 'id_gambar_peningkatan';
    protected $fillable = ['gambar_peningkatan', 'peningkatan_id', 'mime_type'];

    public function peningkatan()
    {
        return $this->belongsTo(TPeningkatan::class, 'peningkatan_id');
    }
}

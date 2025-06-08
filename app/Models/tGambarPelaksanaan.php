<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tGambarPelaksanaan extends Model
{
    use HasFactory;

    protected $table = 't_gambar_pelaksanaans';
    protected $primaryKey = 'id_gambar_pelaksanaan';
    protected $fillable = ['gambar_pelaksanaan', 'pelaksanaan_id'];

    public function pelaksanaan()
    {
        return $this->belongsTo(TPelaksanaan::class, 'pelaksanaan_id');
    }
}

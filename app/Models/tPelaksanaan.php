<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tPelaksanaan extends Model
{
    use HasFactory;

    protected $table = 't_pelaksanaans';
    protected $primaryKey = 'id_pelaksanaan';
    protected $fillable = ['pelaksanaan'];

    public function gambarPelaksanaan()
    {
        return $this->hasMany(tGambarPelaksanaan::class, 'pelaksanaan_id');
    }

    public function akreditasi()
    {
        return $this->hasMany(tAkreditasi::class, 'penetapan_id', 'id_penetapan');
    }
}

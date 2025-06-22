<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tPeningkatan extends Model
{
    use HasFactory;

    protected $table = 't_peningkatans';
    protected $primaryKey = 'id_peningkatan';
    protected $fillable = ['peningkatan'];

    public function gambarPeningkatan()
    {
        return $this->hasMany(tGambarPeningkatan::class, 'peningkatan_id');
    }

    public function akreditasi()
    {
        return $this->hasMany(tAkreditasi::class, 'penetapan_id', 'id_penetapan');
    }
}

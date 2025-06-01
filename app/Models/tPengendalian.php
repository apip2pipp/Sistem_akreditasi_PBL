<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tPengendalian extends Model
{
    use HasFactory;

    protected $table = 't_pengendalians';
    protected $primaryKey = 'id_pengendalian';
    protected $fillable = ['pengendalian'];


    public function akreditasi()
    {
        return $this->hasMany(tAkreditasi::class, 'penetapan_id', 'id_penetapan');
    }
}

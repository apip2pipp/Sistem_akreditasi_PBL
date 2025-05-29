<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tPenetapan extends Model
{
    use HasFactory;

    protected $table = 't_penetapans';
    protected $primaryKey = 'id_penetapan';
    protected $fillable = ['penetapan'];



    public function akreditasi()
    {
        return $this->hasMany(tAkreditasi::class, 'penetapan_id', 'id_penetapan');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tEvaluasi extends Model
{
    use HasFactory;

    protected $table = 't_evaluasis';
    protected $primaryKey = 'id_evaluasi';
    protected $fillable = ['evaluasi'];


    public function akreditasi()
    {
        return $this->hasMany(tAkreditasi::class, 'penetapan_id', 'id_penetapan');
    }
}

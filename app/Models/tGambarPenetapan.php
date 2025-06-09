<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tGambarPenetapan extends Model
{
    use HasFactory;

    protected $table = 't_gambar_penetapans';
    protected $primaryKey = 'id_gambar_penetapan';
    protected $fillable = ['gambar_penetapan', 'penetapan_id'];

    public function penetapan()
    {
        return $this->belongsTo(TPenetapan::class, 'penetapan_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tFileAkreditasi extends Model
{
    use HasFactory;

    protected $table = 't_file_akreditasis';
    protected $primaryKey = 'id_file_akreditasi';
    protected $fillable = ['file_akreditasi', 'akreditasi_id', 'judul_ppepp'];

    public function akreditasi()
    {
        return $this->belongsTo(TAkreditasi::class, 'akreditasi_id');
    }
}

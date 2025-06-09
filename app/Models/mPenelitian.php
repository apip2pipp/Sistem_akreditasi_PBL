<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mPenelitian extends Model
{
    use HasFactory;

    protected $table = 'm_penelitian_dosens';

    protected $primaryKey = 'id_penelitian';

    protected $fillable = [
        'no_surat_tugas',
        'judul_penelitian',
        'pendanaan_internal',
        'pendanaan_eksternal',
        'link_penelitian',
    ];

    public function penelitian_dosens()
    {
        return $this->hasMany(tPenelitianDosen::class, 'penelitian_id');
    }
}

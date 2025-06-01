<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tPenelitianDosen extends Model
{
    use HasFactory;

    protected $table = 't_penelitian_dosens';
    protected $primaryKey = 'id_penelitian_dosen';

    protected $fillable = [
        'dosen_id',
        'penelitian_id',
        'status',
    ];

    public function dosen()
    {
        return $this->belongsTo(mDosen::class, 'dosen_id');
    }


}

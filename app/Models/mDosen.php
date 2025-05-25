<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mDosen extends Model
{
    use HasFactory;

    protected $table = 'm_dosens';
    protected $primaryKey = 'dosen_id';

    protected $fillable = [
        'dosen_id',
        'dosen_nip',
        'dosen_nama',
        'dosen_nidn',
        'dosen_email',
        'dosen_gender',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(mUser::class, 'user_id');
    }

    public function penelitian_dosens()
    {
        return $this->hasMany(tPenelitianDosen::class, 'dosen_id');
    }
}

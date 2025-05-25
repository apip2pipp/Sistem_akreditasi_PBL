<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mKajur extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'm_kajurs';

    // Primary key
    protected $primaryKey = 'kajur_id';

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'user_id',
        'kajur_nama',
        'kajur_nidn',
        'kajur_nip',
        'kajur_email',
        'kajur_gender',
        'kajur_jurusan',
    ];

    // Relasi dengan mUser
    public function user()
    {
        return $this->belongsTo(mUser::class, 'user_id', 'user_id');
    }
}

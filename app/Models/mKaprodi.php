<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mKaprodi extends Model
{
    use HasFactory;

    protected $table = 'm_kaprodis';
    protected $primaryKey = 'kaprodi_id';

    protected $fillable = [
        'user_id',
        'kaprodi_nama',
        'kaprodi_prodi',
        'kaprodi_nidn',
        'kaprodi_nip',
        'kaprodi_email',
        'kaprodi_gender',
    ];

    public function user()
    {
        return $this->belongsTo(mUser::class, 'user_id');
    }
}

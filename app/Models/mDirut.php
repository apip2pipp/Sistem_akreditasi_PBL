<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mDirut extends Model
{
    use HasFactory;

    protected $table = 'm_diruts';
    protected $primaryKey = 'dirut_id';

    protected $fillable = [
        'user_id',
        'dirut_nama',
        'dirut_nip',
        'dirut_email',
    ];

    public function user()
    {
        return $this->belongsTo(mUser::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mKoordinator extends Model
{
    use HasFactory;

    protected $table = 'm_koordinators';
    protected $primaryKey = 'koordinator_id';

    protected $fillable = [
        'user_id',
        'koordinator_nama',
        'koordinator_kode_tugas',
        'koordinator_email',
    ];

    public function user()
    {
        return $this->belongsTo(mUser::class, 'user_id');
    }

    public function permissions()
    {
        return $this->hasMany(tPermissionKriteriaUser::class, 'koordinator_id');
    }
}

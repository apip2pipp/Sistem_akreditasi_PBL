<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tPermissionKriteriaUser extends Model
{
    use HasFactory;

    protected $table = 't_permission_kriteria_users';

    protected $primaryKey = 'id_permission_kriteria_user';

    protected $fillable = [
        'koordinator_id',
        'kriteria_id',
        'status',
    ];

    public function koordinator()
    {
        return $this->belongsTo(mKoordinator::class, 'koordinator_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(mKriteria::class, 'kriteria_id');
    }
}

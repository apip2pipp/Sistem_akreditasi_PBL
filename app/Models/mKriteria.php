<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mKriteria extends Model
{
    use HasFactory;

    protected $table = 'm_kriterias';

    protected $primaryKey = 'kriteria_id';

    protected $fillable = [
        'nama_kriteria',
        'route',
    ];

    // App\Models\tPermissionKriteriaUser.php
    public function kriteria()
    {
        return $this->belongsTo(mKriteria::class, 'kriteria_id');
    }
}

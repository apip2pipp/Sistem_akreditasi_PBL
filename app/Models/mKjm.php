<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mKjm extends Model
{
    use HasFactory;

    protected $table = "m_kjms";
    protected $primaryKey = "kjm_id";

    protected $fillable = [
        'user_id',
        'no_pegawai',
        'kjm_nama',
        'kjm_email',
    ];

    public function user()
    {
        return $this->belongsTo(mUser::class, 'user_id');
    }
}

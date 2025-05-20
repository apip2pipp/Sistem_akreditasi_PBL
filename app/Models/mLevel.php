<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mLevel extends Model
{
    use HasFactory;

    protected $table = 'm_levels';
    protected $primaryKey = 'level_id';

    protected $fillable = [
        'level_kode',
        'level_nama',
    ];
}

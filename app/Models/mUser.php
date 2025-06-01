<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class mUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'm_users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username',
        'email',
        'name',
        'password',
        'level_id'
    ];

    protected $hidden = ['password'];

    public function getAuthIdentifierName()
    {
        return 'username'; // Agar Auth tahu login pakai kolom username
    }

    public function level()
    {
        return $this->belongsTo(mLevel::class, 'level_id');
    }

    public function dosen()
    {
        return $this->hasOne(mDosen::class, 'user_id', 'user_id');
    }

    // Relasi ke kajur
    public function kajur()
    {
        return $this->hasOne(mKajur::class, 'user_id', 'user_id');
    }

    // Relasi ke kjm
    public function kjm()
    {
        return $this->hasOne(mKjm::class, 'user_id', 'user_id');
    }

    // Relasi ke dirut
    public function dirut()
    {
        return $this->hasOne(mDirut::class, 'user_id', 'user_id');
    }

    // Relasi ke koordinator
    public function koordinator()
    {
        return $this->hasOne(mKoordinator::class, 'user_id', 'user_id');
    }

}

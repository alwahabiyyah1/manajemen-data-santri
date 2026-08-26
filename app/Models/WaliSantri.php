<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class WaliSantri extends Authenticatable
{
    protected $table = 'wali_santri';
    protected $primaryKey = 'id_wali';
    public $timestamps = true;

    protected $fillable = [
        'nama_wali',
        'no_hp',
        'alamat',
        'email',
        'username',
        'password',
        'plain_password',
    ];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function santri()
    {
        return $this->hasMany(Santri::class, 'id_wali', 'id_wali');
    }
}

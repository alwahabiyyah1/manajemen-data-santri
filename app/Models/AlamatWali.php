<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatWali extends Model
{
    use HasFactory;

    protected $table = 'alamat_wali';
    protected $primaryKey = 'id_alamat';
    protected $guarded = [];

    public function dataWali()
    {
        return $this->belongsTo(DataWali::class, 'id_wali', 'id_wali');
    }
}

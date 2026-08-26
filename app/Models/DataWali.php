<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataWali extends Model
{
    use HasFactory;

    protected $table = 'data_wali';
    protected $primaryKey = 'id_wali';
    protected $guarded = [];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }

    public function alamat()
    {
        return $this->hasOne(AlamatWali::class, 'id_wali', 'id_wali');
    }
}

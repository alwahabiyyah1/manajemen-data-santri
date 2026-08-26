<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatIbu extends Model
{
    protected $table = 'alamatibu';
    protected $primaryKey = 'id_alamatibu';

    protected $fillable = [
        'id_ibu', 'status_kepemilikan', 'provinsi', 'kabupaten',
        'kecamatan', 'desa', 'rw', 'rt', 'alamat', 'kode_pos',
    ];

    public function dataIbu()
    {
        return $this->belongsTo(DataIbu::class, 'id_ibu', 'id_ibu');
    }
}

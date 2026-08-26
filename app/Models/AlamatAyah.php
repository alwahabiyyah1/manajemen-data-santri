<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatAyah extends Model
{
    protected $table = 'alamatayah';
    protected $primaryKey = 'id_alamatayah';

    protected $fillable = [
        'id_ayah', 'status_kepemilikan', 'provinsi', 'kabupaten',
        'kecamatan', 'desa', 'rw', 'rt', 'alamat', 'kode_pos',
    ];

    public function dataAyah()
    {
        return $this->belongsTo(DataAyah::class, 'id_ayah', 'id_ayah');
    }
}

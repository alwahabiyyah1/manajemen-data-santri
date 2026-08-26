<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatSantri extends Model
{
    protected $table = 'alamatsantri';
    protected $primaryKey = 'id_alamatsantri';

    protected $fillable = [
        'id_santri', 'status_mukim', 'status_tempat_tinggal', 'provinsi',
        'kabupaten', 'kecamatan', 'desa', 'rw', 'rt', 'alamat', 'kode_pos',
        'jarak_ke_lembaga', 'transportasi', 'waktu_tempuh', 'koordinat',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri', 'id');
    }
}

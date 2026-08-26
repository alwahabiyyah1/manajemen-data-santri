<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataIbu extends Model
{
    protected $table = 'dataibu';
    protected $primaryKey = 'id_ibu';

    protected $fillable = [
        'id_santri', 'nama_lengkap', 'status', 'kewarganegaraan', 'nik',
        'tempat_lahir', 'tanggal_lahir', 'pendidikan_terakhir',
        'pekerjaan_utama', 'penghasilan_perbulan', 'no_hp',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri', 'id');
    }

    public function alamat()
    {
        return $this->hasOne(AlamatIbu::class, 'id_ibu', 'id_ibu');
    }
}

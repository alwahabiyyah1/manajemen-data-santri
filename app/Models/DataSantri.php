<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSantri extends Model
{
    protected $table = 'datasantri';
    protected $primaryKey = 'id_santri';
    public $incrementing = false;

    protected $fillable = [
        'id_santri', 'nama_lengkap', 'no_kk', 'nik', 'kewarganegaraan',
        'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'jumlah_saudara',
        'anak_ke', 'cita_cita', 'agama', 'no_hp', 'email', 'hobi',
        'pembiaya_sekolah', 'kebutuhan_khusus', 'kebutuhan_disabilitas',
        'nama_kapala_keluarga', 'tahun_masuk', 'tahun_keluar',
        'foto_3x4', 'foto_kk',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri', 'id');
    }
}

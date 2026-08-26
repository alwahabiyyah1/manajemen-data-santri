<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    protected $table = 'santri';
    protected $primaryKey = 'id';
    public $timestamps = false;

    const CREATED_AT = 'tanggal_input';
    const UPDATED_AT = 'tanggal_update';

    protected $fillable = [
        'id_wali',
        'status_data',
        'is_verified',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_input' => 'datetime',
            'tanggal_update' => 'datetime',
        ];
    }

    public function wali()
    {
        return $this->belongsTo(WaliSantri::class, 'id_wali', 'id_wali');
    }

    public function dataSantri()
    {
        return $this->hasOne(DataSantri::class, 'id_santri', 'id');
    }

    public function dataAyah()
    {
        return $this->hasOne(DataAyah::class, 'id_santri', 'id');
    }

    public function dataIbu()
    {
        return $this->hasOne(DataIbu::class, 'id_santri', 'id');
    }

    public function alamatSantri()
    {
        return $this->hasOne(AlamatSantri::class, 'id_santri', 'id');
    }

    public function dataWali()
    {
        return $this->hasOne(DataWali::class, 'id_santri', 'id');
    }

    public function getIsLengkapAttribute()
    {
        return $this->dataSantri && $this->dataAyah && $this->dataIbu && $this->alamatSantri && $this->dataWali;
    }
}

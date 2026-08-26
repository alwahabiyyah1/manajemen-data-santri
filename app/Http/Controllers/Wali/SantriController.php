<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\DataSantri;
use App\Models\DataAyah;
use App\Models\DataIbu;
use App\Models\DataWali;
use App\Models\AlamatWali;
use App\Models\AlamatSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SantriController extends Controller
{
    /**
     * Ambil santri milik wali yang sedang login (keamanan: wali hanya bisa akses anaknya sendiri)
     */
    private function getSantriMilikWali($id)
    {
        $wali = Auth::guard('wali')->user();
        return Santri::with([
            'dataSantri', 'dataAyah.alamat', 'dataIbu.alamat', 'alamatSantri', 'dataWali.alamat'
        ])->where('id', $id)->where('id_wali', $wali->id_wali)->firstOrFail();
    }

    /** Daftar semua santri milik wali */
    public function index()
    {
        $wali   = Auth::guard('wali')->user();
        $santri = $wali->santri()->with('dataSantri')->paginate(10);
        return view('wali.santri.index', compact('santri', 'wali'));
    }

    /** Detail profil santri */
    public function show($id)
    {
        $santri = $this->getSantriMilikWali($id);
        return view('wali.santri.show', compact('santri'));
    }

    /** Form edit data santri */
    public function edit($id)
    {
        $santri = $this->getSantriMilikWali($id);
        return view('wali.santri.edit', compact('santri'));
    }

    /** Simpan perubahan data santri */
    public function update(Request $request, $id)
    {
        $santri = $this->getSantriMilikWali($id);

        $request->validate([
            // Data Santri
            'nama_lengkap'         => 'required|string|max:255',
            'nik'                  => 'required|string|max:20',
            'no_kk'                => 'required|string|max:20',
            'kewarganegaraan'      => 'required|string|max:50',
            'nama_kapala_keluarga' => 'required|string|max:255',
            'tempat_lahir'         => 'required|string|max:100',
            'tanggal_lahir'        => 'required|date',
            'jenis_kelamin'        => 'required|in:Laki-laki,Perempuan',
            'agama'                => 'required|string|max:50',
            'anak_ke'              => 'required|integer|min:1',
            'jumlah_saudara'       => 'required|integer|min:0',
            'no_hp'                => 'required|string|max:20',
            'email'                => 'nullable|email|max:255',
            'cita_cita'            => 'nullable|string|max:100',
            'hobi'                 => 'nullable|string|max:100',
            'pembiaya_sekolah'     => 'required|string|max:100',
            'tahun_masuk'          => 'required|integer|min:2000',
            'tahun_keluar'         => 'nullable|integer|min:2000',
            'kebutuhan_khusus'     => 'nullable|string|max:255',
            'kebutuhan_disabilitas'=> 'nullable|string|max:255',
            'foto_3x4'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_kk'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // Data Ayah
            'ayah_nama_lengkap'    => 'required|string|max:255',
            'ayah_status'          => 'required|string|max:50',
            'ayah_nik'             => 'required|string|max:20',
            'ayah_kewarganegaraan' => 'required|string|max:50',
            'ayah_tempat_lahir'    => 'required|string|max:100',
            'ayah_tanggal_lahir'   => 'required|date',
            'ayah_pendidikan_terakhir' => 'required|string|max:100',
            'ayah_no_hp'           => 'required|string|max:20',
            'ayah_pekerjaan_utama' => 'required|string|max:100',
            'ayah_penghasilan_perbulan' => 'required|string|max:50',

            // Data Ibu
            'ibu_nama_lengkap'     => 'required|string|max:255',
            'ibu_status'           => 'required|string|max:50',
            'ibu_nik'              => 'required|string|max:20',
            'ibu_kewarganegaraan'  => 'required|string|max:50',
            'ibu_tempat_lahir'     => 'required|string|max:100',
            'ibu_tanggal_lahir'    => 'required|date',
            'ibu_pendidikan_terakhir'  => 'required|string|max:100',
            'ibu_no_hp'            => 'required|string|max:20',
            'ibu_pekerjaan_utama'  => 'required|string|max:100',
            'ibu_penghasilan_perbulan' => 'required|string|max:50',

            // Data Wali
            'wali_nama_lengkap'    => 'required|string|max:255',
            'wali_status'          => 'required|string|max:50',
            'wali_nik'             => 'required|string|max:20',
            'wali_kewarganegaraan' => 'required|string|max:50',
            'wali_tempat_lahir'    => 'required|string|max:100',
            'wali_tanggal_lahir'   => 'required|date',
            'wali_pendidikan_terakhir' => 'required|string|max:100',
            'wali_no_hp'           => 'required|string|max:20',
            'wali_pekerjaan_utama' => 'required|string|max:100',
            'wali_penghasilan_perbulan' => 'required|string|max:50',

            // Alamat Ayah
            'alamat_ayah'          => 'required|string|max:500',
            'rt_ayah'              => 'required|string|max:5',
            'rw_ayah'              => 'required|string|max:5',
            'desa_ayah'            => 'required|string|max:100',
            'kecamatan_ayah'       => 'required|string|max:100',
            'kabupaten_ayah'       => 'required|string|max:100',
            'provinsi_ayah'        => 'required|string|max:100',
            'kode_pos_ayah'        => 'required|string|max:10',
            'status_kepemilikan_ayah'=> 'required|string|max:100',

            // Alamat Ibu
            'alamat_ibu'           => 'required|string|max:500',
            'rt_ibu'               => 'required|string|max:5',
            'rw_ibu'               => 'required|string|max:5',
            'desa_ibu'             => 'required|string|max:100',
            'kecamatan_ibu'        => 'required|string|max:100',
            'kabupaten_ibu'        => 'required|string|max:100',
            'provinsi_ibu'         => 'required|string|max:100',
            'kode_pos_ibu'         => 'required|string|max:10',
            'status_kepemilikan_ibu'=> 'required|string|max:100',

            // Alamat Wali
            'alamat_wali'          => 'required|string|max:500',
            'rt_wali'              => 'required|string|max:5',
            'rw_wali'              => 'required|string|max:5',
            'desa_wali'            => 'required|string|max:100',
            'kecamatan_wali'       => 'required|string|max:100',
            'kabupaten_wali'       => 'required|string|max:100',
            'provinsi_wali'        => 'required|string|max:100',
            'kode_pos_wali'        => 'required|string|max:10',
            'status_kepemilikan_wali'=> 'required|string|max:100',

            // Alamat Santri (Di form wali ini dikunci / disabled, jadi tidak boleh required)
            'alamat'               => 'nullable|string|max:500',
            'rt'                   => 'nullable|string|max:5',
            'rw'                   => 'nullable|string|max:5',
            'desa'                 => 'nullable|string|max:100',
            'kecamatan'            => 'nullable|string|max:100',
            'kabupaten'            => 'nullable|string|max:100',
            'provinsi'             => 'nullable|string|max:100',
            'kode_pos'             => 'nullable|string|max:10',
            'koordinat'            => 'nullable|string|max:100',
            'status_mukim'         => 'nullable|string|max:50',
            'status_tempat_tinggal'=> 'nullable|string|max:100',
            'transportasi'         => 'nullable|string|max:50',
            'jarak_ke_lembaga'     => 'nullable|numeric|min:0',
            'waktu_tempuh'         => 'nullable|integer|min:0',
        ], [
            'required' => 'Kolom :attribute wajib diisi agar data menjadi lengkap.',
            'nama_lengkap.required' => 'Nama lengkap santri wajib diisi.',
            'foto_3x4.image'        => 'File harus berupa gambar.',
            'foto_3x4.max'          => 'Ukuran foto maksimal 2MB.',
            'foto_kk.image'         => 'File harus berupa gambar.',
            'foto_kk.max'           => 'Ukuran foto KK maksimal 2MB.',
        ]);

        // ── Update DataSantri ──────────────────────────────────────────────
        $ds = $santri->dataSantri;
        if ($ds) {
            $dsData = $request->only([
                'nama_lengkap', 'nik', 'no_kk', 'kewarganegaraan', 'nama_kapala_keluarga',
                'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'anak_ke',
                'jumlah_saudara', 'no_hp', 'email', 'cita_cita', 'hobi', 'pembiaya_sekolah',
                'tahun_masuk', 'tahun_keluar', 'kebutuhan_khusus', 'kebutuhan_disabilitas',
            ]);

            // Upload foto 3x4
            if ($request->hasFile('foto_3x4')) {
                if ($ds->foto_3x4) Storage::disk('public')->delete($ds->foto_3x4);
                $file = $request->file('foto_3x4');
                $filename = 'foto3x4_' . $santri->id . '_' . time() . '_' . \Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('berkas', $filename, 'public');
                $dsData['foto_3x4'] = $filename;
            }

            // Upload foto KK
            if ($request->hasFile('foto_kk')) {
                if ($ds->foto_kk) Storage::disk('public')->delete($ds->foto_kk);
                $file = $request->file('foto_kk');
                $filename = 'fotokk_' . $santri->id . '_' . time() . '_' . \Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('berkas', $filename, 'public');
                $dsData['foto_kk'] = $filename;
            }

            $ds->update($dsData);
        }

        // ── Update DataAyah ────────────────────────────────────────────────
        $da = $santri->dataAyah;
        if ($da) {
            $da->update([
                'nama_lengkap'        => $request->ayah_nama_lengkap,
                'status'              => $request->ayah_status,
                'nik'                 => $request->ayah_nik,
                'kewarganegaraan'     => $request->ayah_kewarganegaraan,
                'tempat_lahir'        => $request->ayah_tempat_lahir,
                'tanggal_lahir'       => $request->ayah_tanggal_lahir,
                'pendidikan_terakhir' => $request->ayah_pendidikan_terakhir,
                'no_hp'               => $request->ayah_no_hp,
                'pekerjaan_utama'     => $request->ayah_pekerjaan_utama,
                'penghasilan_perbulan'=> $request->ayah_penghasilan_perbulan,
            ]);
            
            // Alamat Ayah
            $aa = $da->alamat;
            if ($aa) {
                $aa->update([
                    'alamat' => $request->alamat_ayah, 'rt' => $request->rt_ayah, 'rw' => $request->rw_ayah,
                    'desa' => $request->desa_ayah, 'kecamatan' => $request->kecamatan_ayah,
                    'kabupaten' => $request->kabupaten_ayah, 'provinsi' => $request->provinsi_ayah,
                    'kode_pos' => $request->kode_pos_ayah, 'status_kepemilikan' => $request->status_kepemilikan_ayah,
                ]);
            } else {
                $da->alamat()->create([
                    'alamat' => $request->alamat_ayah, 'rt' => $request->rt_ayah, 'rw' => $request->rw_ayah,
                    'desa' => $request->desa_ayah, 'kecamatan' => $request->kecamatan_ayah,
                    'kabupaten' => $request->kabupaten_ayah, 'provinsi' => $request->provinsi_ayah,
                    'kode_pos' => $request->kode_pos_ayah, 'status_kepemilikan' => $request->status_kepemilikan_ayah,
                ]);
            }
        } else if ($request->filled('ayah_nama_lengkap')) {
            $da = $santri->dataAyah()->create([
                'nama_lengkap'        => $request->ayah_nama_lengkap,
                'status'              => $request->ayah_status,
                'nik'                 => $request->ayah_nik,
                'kewarganegaraan'     => $request->ayah_kewarganegaraan,
                'tempat_lahir'        => $request->ayah_tempat_lahir,
                'tanggal_lahir'       => $request->ayah_tanggal_lahir,
                'pendidikan_terakhir' => $request->ayah_pendidikan_terakhir,
                'no_hp'               => $request->ayah_no_hp,
                'pekerjaan_utama'     => $request->ayah_pekerjaan_utama,
                'penghasilan_perbulan'=> $request->ayah_penghasilan_perbulan,
            ]);
            $da->alamat()->create([
                'alamat' => $request->alamat_ayah, 'rt' => $request->rt_ayah, 'rw' => $request->rw_ayah,
                'desa' => $request->desa_ayah, 'kecamatan' => $request->kecamatan_ayah,
                'kabupaten' => $request->kabupaten_ayah, 'provinsi' => $request->provinsi_ayah,
                'kode_pos' => $request->kode_pos_ayah, 'status_kepemilikan' => $request->status_kepemilikan_ayah,
            ]);
        }

        // ── Update DataIbu ─────────────────────────────────────────────────
        $di = $santri->dataIbu;
        if ($di) {
            $di->update([
                'nama_lengkap'        => $request->ibu_nama_lengkap,
                'status'              => $request->ibu_status,
                'nik'                 => $request->ibu_nik,
                'kewarganegaraan'     => $request->ibu_kewarganegaraan,
                'tempat_lahir'        => $request->ibu_tempat_lahir,
                'tanggal_lahir'       => $request->ibu_tanggal_lahir,
                'pendidikan_terakhir' => $request->ibu_pendidikan_terakhir,
                'no_hp'               => $request->ibu_no_hp,
                'pekerjaan_utama'     => $request->ibu_pekerjaan_utama,
                'penghasilan_perbulan'=> $request->ibu_penghasilan_perbulan,
            ]);
            
            // Alamat Ibu
            $ai = $di->alamat;
            if ($ai) {
                $ai->update([
                    'alamat' => $request->alamat_ibu, 'rt' => $request->rt_ibu, 'rw' => $request->rw_ibu,
                    'desa' => $request->desa_ibu, 'kecamatan' => $request->kecamatan_ibu,
                    'kabupaten' => $request->kabupaten_ibu, 'provinsi' => $request->provinsi_ibu,
                    'kode_pos' => $request->kode_pos_ibu, 'status_kepemilikan' => $request->status_kepemilikan_ibu,
                ]);
            } else {
                $di->alamat()->create([
                    'alamat' => $request->alamat_ibu, 'rt' => $request->rt_ibu, 'rw' => $request->rw_ibu,
                    'desa' => $request->desa_ibu, 'kecamatan' => $request->kecamatan_ibu,
                    'kabupaten' => $request->kabupaten_ibu, 'provinsi' => $request->provinsi_ibu,
                    'kode_pos' => $request->kode_pos_ibu, 'status_kepemilikan' => $request->status_kepemilikan_ibu,
                ]);
            }
        } else if ($request->filled('ibu_nama_lengkap')) {
            $di = $santri->dataIbu()->create([
                'nama_lengkap'        => $request->ibu_nama_lengkap,
                'status'              => $request->ibu_status,
                'nik'                 => $request->ibu_nik,
                'kewarganegaraan'     => $request->ibu_kewarganegaraan,
                'tempat_lahir'        => $request->ibu_tempat_lahir,
                'tanggal_lahir'       => $request->ibu_tanggal_lahir,
                'pendidikan_terakhir' => $request->ibu_pendidikan_terakhir,
                'no_hp'               => $request->ibu_no_hp,
                'pekerjaan_utama'     => $request->ibu_pekerjaan_utama,
                'penghasilan_perbulan'=> $request->ibu_penghasilan_perbulan,
            ]);
            $di->alamat()->create([
                'alamat' => $request->alamat_ibu, 'rt' => $request->rt_ibu, 'rw' => $request->rw_ibu,
                'desa' => $request->desa_ibu, 'kecamatan' => $request->kecamatan_ibu,
                'kabupaten' => $request->kabupaten_ibu, 'provinsi' => $request->provinsi_ibu,
                'kode_pos' => $request->kode_pos_ibu, 'status_kepemilikan' => $request->status_kepemilikan_ibu,
            ]);
        }

        // ── Update DataWali ────────────────────────────────────────────────
        $dw = $santri->dataWali;
        if ($dw) {
            $dw->update([
                'nama_lengkap'         => $request->wali_nama_lengkap,
                'status'               => $request->wali_status,
                'nik'                  => $request->wali_nik,
                'kewarganegaraan'      => $request->wali_kewarganegaraan,
                'tempat_lahir'         => $request->wali_tempat_lahir,
                'tanggal_lahir'        => $request->wali_tanggal_lahir,
                'pendidikan_terakhir'  => $request->wali_pendidikan_terakhir,
                'no_hp'                => $request->wali_no_hp,
                'pekerjaan_utama'      => $request->wali_pekerjaan_utama,
                'penghasilan_perbulan' => $request->wali_penghasilan_perbulan,
            ]);
            $aw = $dw->alamat;
            if ($aw) {
                $aw->update([
                    'alamat' => $request->alamat_wali, 'rt' => $request->rt_wali, 'rw' => $request->rw_wali,
                    'desa' => $request->desa_wali, 'kecamatan' => $request->kecamatan_wali,
                    'kabupaten' => $request->kabupaten_wali, 'provinsi' => $request->provinsi_wali,
                    'kode_pos' => $request->kode_pos_wali, 'status_kepemilikan' => $request->status_kepemilikan_wali,
                ]);
            } elseif ($request->filled('alamat_wali')) {
                $dw->alamat()->create([
                    'id_wali' => $dw->id_wali,
                    'alamat' => $request->alamat_wali, 'rt' => $request->rt_wali, 'rw' => $request->rw_wali,
                    'desa' => $request->desa_wali, 'kecamatan' => $request->kecamatan_wali,
                    'kabupaten' => $request->kabupaten_wali, 'provinsi' => $request->provinsi_wali,
                    'kode_pos' => $request->kode_pos_wali, 'status_kepemilikan' => $request->status_kepemilikan_wali,
                ]);
            }
        } elseif ($request->filled('wali_nama_lengkap')) {
            $dw = $santri->dataWali()->create([
                'nama_lengkap'         => $request->wali_nama_lengkap,
                'status'               => $request->wali_status,
                'nik'                  => $request->wali_nik,
                'kewarganegaraan'      => $request->wali_kewarganegaraan,
                'tempat_lahir'         => $request->wali_tempat_lahir,
                'tanggal_lahir'        => $request->wali_tanggal_lahir,
                'pendidikan_terakhir'  => $request->wali_pendidikan_terakhir,
                'no_hp'                => $request->wali_no_hp,
                'pekerjaan_utama'      => $request->wali_pekerjaan_utama,
                'penghasilan_perbulan' => $request->wali_penghasilan_perbulan,
            ]);
            if ($request->filled('alamat_wali')) {
                AlamatWali::create([
                    'id_wali' => $dw->id_wali,
                    'alamat' => $request->alamat_wali, 'rt' => $request->rt_wali, 'rw' => $request->rw_wali,
                    'desa' => $request->desa_wali, 'kecamatan' => $request->kecamatan_wali,
                    'kabupaten' => $request->kabupaten_wali, 'provinsi' => $request->provinsi_wali,
                    'kode_pos' => $request->kode_pos_wali, 'status_kepemilikan' => $request->status_kepemilikan_wali,
                ]);
            }
        }

        // ── Update AlamatSantri ────────────────────────────────────────────
        $as = $santri->alamatSantri;
        if ($as) {
            $as->update($request->only([
                'alamat', 'rt', 'rw', 'desa', 'kecamatan',
                'kabupaten', 'provinsi', 'kode_pos', 'koordinat',
                'status_mukim', 'status_tempat_tinggal',
                'transportasi', 'jarak_ke_lembaga', 'waktu_tempuh',
            ]));
        } else {
            $santri->alamatSantri()->create($request->only([
                'alamat', 'rt', 'rw', 'desa', 'kecamatan',
                'kabupaten', 'provinsi', 'kode_pos', 'koordinat',
                'status_mukim', 'status_tempat_tinggal',
                'transportasi', 'jarak_ke_lembaga', 'waktu_tempuh',
            ]));
        }

        // ── Sync Profil Wali (Akun WaliSantri) ─────────────────────────────
        $waliUser = Auth::guard('wali')->user();
        if ($waliUser) {
            $syncData = [];
            // Jika nama wali cocok dengan ayah, sinkronkan no_hp ayah ke wali
            if ($da && strtolower(trim($waliUser->nama_wali)) === strtolower(trim($da->nama_lengkap))) {
                if ($request->filled('ayah_no_hp') && $waliUser->no_hp !== $request->ayah_no_hp) {
                    $syncData['no_hp'] = $request->ayah_no_hp;
                    $syncData['password'] = \Illuminate\Support\Facades\Hash::make($request->ayah_no_hp);
                    $syncData['plain_password'] = $request->ayah_no_hp;
                }
            } 
            // Jika nama wali cocok dengan ibu, sinkronkan no_hp ibu ke wali
            elseif ($di && strtolower(trim($waliUser->nama_wali)) === strtolower(trim($di->nama_lengkap))) {
                if ($request->filled('ibu_no_hp') && $waliUser->no_hp !== $request->ibu_no_hp) {
                    $syncData['no_hp'] = $request->ibu_no_hp;
                    $syncData['password'] = \Illuminate\Support\Facades\Hash::make($request->ibu_no_hp);
                    $syncData['plain_password'] = $request->ibu_no_hp;
                }
            }
            // Jika nama wali cocok dengan wali, sinkronkan no_hp wali ke wali
            elseif ($dw && strtolower(trim($waliUser->nama_wali)) === strtolower(trim($dw->nama_lengkap))) {
                if ($request->filled('wali_no_hp') && $waliUser->no_hp !== $request->wali_no_hp) {
                    $syncData['no_hp'] = $request->wali_no_hp;
                    $syncData['password'] = \Illuminate\Support\Facades\Hash::make($request->wali_no_hp);
                    $syncData['plain_password'] = $request->wali_no_hp;
                }
            }
            
            // Sinkronkan email wali dengan email santri jika wali tidak punya email (opsional)
            if ($request->filled('email') && empty($waliUser->email)) {
                $syncData['email'] = $request->email;
            }

            if (!empty($syncData)) {
                $waliUser->update($syncData);
            }
        }

        return redirect()
            ->route('wali.santri.show', $id)
            ->with('success', 'Data santri berhasil diperbarui.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\DataSantri;
use App\Models\DataAyah;
use App\Models\DataIbu;
use App\Models\DataWali;
use App\Models\AlamatSantri;
use App\Models\AlamatAyah;
use App\Models\AlamatIbu;
use App\Models\AlamatWali;
use App\Exports\SantriExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\WaliSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::with('dataSantri', 'wali');
        if ($request->search) {
            $query->whereHas('dataSantri', function($q) use($request) {
                $q->where('nama_lengkap', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->status) {
            $query->where('status_data', $request->status);
        }
        if ($request->tahun_masuk) {
            $query->whereHas('dataSantri', function($q) use($request) {
                $q->where('tahun_masuk', $request->tahun_masuk);
            });
        }
        if ($request->jenis_kelamin) {
            $query->whereHas('dataSantri', function($q) use($request) {
                $q->where('jenis_kelamin', $request->jenis_kelamin);
            });
        }
        $santri = $query->latest('tanggal_input')->paginate(10)->withQueryString();

        // Ambil list tahun masuk unik untuk filter dropdown
        $tahunList = DataSantri::select('tahun_masuk')
            ->whereNotNull('tahun_masuk')
            ->distinct()
            ->orderBy('tahun_masuk', 'desc')
            ->pluck('tahun_masuk');

        return view('admin.santri.index', compact('santri', 'tahunList'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new SantriExport(
            $request->search,
            $request->status,
            $request->tahun_masuk,
            $request->jenis_kelamin
        ), 'data_santri_' . date('YmdHis') . '.xlsx');
    }

    public function create()
    {
        $waliList = WaliSantri::orderBy('nama_wali')->get();
        return view('admin.santri.create', compact('waliList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'id_wali'      => 'nullable|exists:wali_santri,id_wali',
            'status_data'  => 'required|in:aktif,tidak aktif,lulus,keluar',
        ]);

        DB::transaction(function () use ($request) {
            $santri = Santri::create([
                'id_wali'     => $request->id_wali,
                'status_data' => $request->status_data,
            ]);

            DataSantri::create(array_merge(
                $request->only(['nama_lengkap','no_kk','nik','kewarganegaraan','tempat_lahir',
                    'tanggal_lahir','jenis_kelamin','jumlah_saudara','anak_ke','cita_cita',
                    'agama','no_hp','email','hobi','pembiaya_sekolah','kebutuhan_khusus',
                    'kebutuhan_disabilitas','nama_kapala_keluarga','tahun_masuk','tahun_keluar']),
                ['id_santri' => $santri->id]
            ));

            // Data Ayah
            if ($request->filled('nama_lengkap_ayah')) {
                $ayah = DataAyah::create([
                    'id_santri'           => $santri->id,
                    'nama_lengkap'        => $request->nama_lengkap_ayah,
                    'status'              => $request->status_ayah,
                    'kewarganegaraan'     => $request->kewarganegaraan_ayah,
                    'nik'                 => $request->nik_ayah,
                    'tempat_lahir'        => $request->tempat_lahir_ayah,
                    'tanggal_lahir'       => $request->tanggal_lahir_ayah,
                    'pendidikan_terakhir' => $request->pendidikan_terakhir_ayah,
                    'pekerjaan_utama'     => $request->pekerjaan_utama_ayah,
                    'penghasilan_perbulan'=> $request->penghasilan_perbulan_ayah,
                    'no_hp'               => $request->no_hp_ayah,
                ]);

                if ($request->filled('alamat_ayah')) {
                    AlamatAyah::create([
                        'id_ayah'           => $ayah->id_ayah,
                        'status_kepemilikan'=> $request->status_kepemilikan_ayah,
                        'provinsi'          => $request->provinsi_ayah,
                        'kabupaten'         => $request->kabupaten_ayah,
                        'kecamatan'         => $request->kecamatan_ayah,
                        'desa'              => $request->desa_ayah,
                        'rw'                => $request->rw_ayah,
                        'rt'                => $request->rt_ayah,
                        'alamat'            => $request->alamat_ayah,
                        'kode_pos'          => $request->kode_pos_ayah,
                    ]);
                }
            }

            // Data Ibu
            if ($request->filled('nama_lengkap_ibu')) {
                $ibu = DataIbu::create([
                    'id_santri'           => $santri->id,
                    'nama_lengkap'        => $request->nama_lengkap_ibu,
                    'status'              => $request->status_ibu,
                    'kewarganegaraan'     => $request->kewarganegaraan_ibu,
                    'nik'                 => $request->nik_ibu,
                    'tempat_lahir'        => $request->tempat_lahir_ibu,
                    'tanggal_lahir'       => $request->tanggal_lahir_ibu,
                    'pendidikan_terakhir' => $request->pendidikan_terakhir_ibu,
                    'pekerjaan_utama'     => $request->pekerjaan_utama_ibu,
                    'penghasilan_perbulan'=> $request->penghasilan_perbulan_ibu,
                    'no_hp'               => $request->no_hp_ibu,
                ]);

                if ($request->filled('alamat_ibu')) {
                    AlamatIbu::create([
                        'id_ibu'            => $ibu->id_ibu,
                        'status_kepemilikan'=> $request->status_kepemilikan_ibu,
                        'provinsi'          => $request->provinsi_ibu,
                        'kabupaten'         => $request->kabupaten_ibu,
                        'kecamatan'         => $request->kecamatan_ibu,
                        'desa'              => $request->desa_ibu,
                        'rw'                => $request->rw_ibu,
                        'rt'                => $request->rt_ibu,
                        'alamat'            => $request->alamat_ibu,
                        'kode_pos'          => $request->kode_pos_ibu,
                    ]);
                }
            }

            // Alamat Santri
            if ($request->filled('alamat_santri')) {
                AlamatSantri::create([
                    'id_santri'           => $santri->id,
                    'status_mukim'        => $request->status_mukim,
                    'status_tempat_tinggal'=> $request->status_tempat_tinggal,
                    'provinsi'            => $request->provinsi_santri,
                    'kabupaten'           => $request->kabupaten_santri,
                    'kecamatan'           => $request->kecamatan_santri,
                    'desa'                => $request->desa_santri,
                    'rw'                  => $request->rw_santri,
                    'rt'                  => $request->rt_santri,
                    'alamat'              => $request->alamat_santri,
                    'kode_pos'            => $request->kode_pos_santri,
                    'jarak_ke_lembaga'    => $request->jarak_ke_lembaga,
                    'transportasi'        => $request->transportasi,
                    'waktu_tempuh'        => $request->waktu_tempuh,
                    'koordinat'           => $request->koordinat,
                ]);
            }
        });

        return redirect()->route('admin.santri.index')
            ->with('success', 'Data santri berhasil ditambahkan!');
    }

    public function show($id)
    {
        $santri = Santri::with([
            'dataSantri', 'dataAyah.alamat', 'dataIbu.alamat',
            'alamatSantri', 'wali', 'dataWali.alamat'
        ])->findOrFail($id);
        return view('admin.santri.show', compact('santri'));
    }

    public function edit($id)
    {
        $santri = Santri::with([
            'dataSantri', 'dataAyah.alamat', 'dataIbu.alamat',
            'alamatSantri', 'wali', 'dataWali.alamat'
        ])->findOrFail($id);
        $waliList = WaliSantri::orderBy('nama_wali')->get();
        return view('admin.santri.edit', compact('santri', 'waliList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'status_data'  => 'required|in:aktif,tidak aktif,lulus,keluar',
            'foto_3x4'     => 'nullable|image|max:2048',
            'foto_kk'      => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request, $id) {
            $santri = Santri::findOrFail($id);
            $santri->update([
                'id_wali'     => $request->id_wali,
                'status_data' => $request->status_data,
            ]);

            $dataSantri = DataSantri::firstOrNew(['id_santri' => $santri->id]);
            $dataSantri->fill($request->only([
                'nama_lengkap','no_kk','nik','kewarganegaraan','tempat_lahir',
                'tanggal_lahir','jenis_kelamin','jumlah_saudara','anak_ke','cita_cita',
                'agama','no_hp','email','hobi','pembiaya_sekolah','kebutuhan_khusus',
                'kebutuhan_disabilitas','nama_kapala_keluarga','tahun_masuk','tahun_keluar'
            ]));
            $dataSantri->id_santri = $santri->id;

            // Update Foto 3x4
            if ($request->hasFile('foto_3x4')) {
                if ($dataSantri->foto_3x4) @unlink(storage_path('app/public/berkas/' . $dataSantri->foto_3x4));
                $file = $request->file('foto_3x4');
                $filename = 'foto3x4_' . $santri->id . '_' . time() . '_' . \Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('berkas', $filename, 'public');
                $dataSantri->foto_3x4 = $filename;
            }

            // Update Foto KK
            if ($request->hasFile('foto_kk')) {
                if ($dataSantri->foto_kk) @unlink(storage_path('app/public/berkas/' . $dataSantri->foto_kk));
                $file = $request->file('foto_kk');
                $filename = 'fotokk_' . $santri->id . '_' . time() . '_' . \Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('berkas', $filename, 'public');
                $dataSantri->foto_kk = $filename;
            }

            $dataSantri->save();

            // Update Data Ayah
            if ($request->filled('nama_lengkap_ayah')) {
                $ayah = DataAyah::firstOrNew(['id_santri' => $santri->id]);
                $ayah->fill([
                    'id_santri' => $santri->id,
                    'nama_lengkap' => $request->nama_lengkap_ayah,
                    'status' => $request->status_ayah,
                    'kewarganegaraan' => $request->kewarganegaraan_ayah,
                    'nik' => $request->nik_ayah,
                    'tempat_lahir' => $request->tempat_lahir_ayah,
                    'tanggal_lahir' => $request->tanggal_lahir_ayah,
                    'pendidikan_terakhir' => $request->pendidikan_terakhir_ayah,
                    'pekerjaan_utama' => $request->pekerjaan_utama_ayah,
                    'penghasilan_perbulan' => $request->penghasilan_perbulan_ayah,
                    'no_hp' => $request->no_hp_ayah,
                ])->save();

                if ($request->filled('alamat_ayah')) {
                    $alamatAyah = AlamatAyah::firstOrNew(['id_ayah' => $ayah->id_ayah]);
                    $alamatAyah->fill([
                        'id_ayah' => $ayah->id_ayah,
                        'status_kepemilikan' => $request->status_kepemilikan_ayah,
                        'provinsi' => $request->provinsi_ayah,
                        'kabupaten' => $request->kabupaten_ayah,
                        'kecamatan' => $request->kecamatan_ayah,
                        'desa' => $request->desa_ayah,
                        'rw' => $request->rw_ayah,
                        'rt' => $request->rt_ayah,
                        'alamat' => $request->alamat_ayah,
                        'kode_pos' => $request->kode_pos_ayah,
                    ])->save();
                }
            }

            // Update Data Ibu
            if ($request->filled('nama_lengkap_ibu')) {
                $ibu = DataIbu::firstOrNew(['id_santri' => $santri->id]);
                $ibu->fill([
                    'id_santri' => $santri->id,
                    'nama_lengkap' => $request->nama_lengkap_ibu,
                    'status' => $request->status_ibu,
                    'kewarganegaraan' => $request->kewarganegaraan_ibu,
                    'nik' => $request->nik_ibu,
                    'tempat_lahir' => $request->tempat_lahir_ibu,
                    'tanggal_lahir' => $request->tanggal_lahir_ibu,
                    'pendidikan_terakhir' => $request->pendidikan_terakhir_ibu,
                    'pekerjaan_utama' => $request->pekerjaan_utama_ibu,
                    'penghasilan_perbulan' => $request->penghasilan_perbulan_ibu,
                    'no_hp' => $request->no_hp_ibu,
                ])->save();

                if ($request->filled('alamat_ibu')) {
                    $alamatIbu = AlamatIbu::firstOrNew(['id_ibu' => $ibu->id_ibu]);
                    $alamatIbu->fill([
                        'id_ibu' => $ibu->id_ibu,
                        'status_kepemilikan' => $request->status_kepemilikan_ibu,
                        'provinsi' => $request->provinsi_ibu,
                        'kabupaten' => $request->kabupaten_ibu,
                        'kecamatan' => $request->kecamatan_ibu,
                        'desa' => $request->desa_ibu,
                        'rw' => $request->rw_ibu,
                        'rt' => $request->rt_ibu,
                        'alamat' => $request->alamat_ibu,
                        'kode_pos' => $request->kode_pos_ibu,
                    ])->save();
                }
            }

            // Update Data Wali
            if ($request->filled('nama_lengkap_wali')) {
                $dataWali = DataWali::firstOrNew(['id_santri' => $santri->id]);
                $dataWali->fill([
                    'id_santri'            => $santri->id,
                    'nama_lengkap'         => $request->nama_lengkap_wali,
                    'status'               => $request->status_wali,
                    'kewarganegaraan'      => $request->kewarganegaraan_wali,
                    'nik'                  => $request->nik_wali,
                    'tempat_lahir'         => $request->tempat_lahir_wali,
                    'tanggal_lahir'        => $request->tanggal_lahir_wali,
                    'pendidikan_terakhir'  => $request->pendidikan_terakhir_wali,
                    'pekerjaan_utama'      => $request->pekerjaan_utama_wali,
                    'penghasilan_perbulan' => $request->penghasilan_perbulan_wali,
                    'no_hp'                => $request->no_hp_wali,
                ])->save();

                if ($request->filled('alamat_wali')) {
                    $alamatWali = AlamatWali::firstOrNew(['id_wali' => $dataWali->id_wali]);
                    $alamatWali->fill([
                        'id_wali'            => $dataWali->id_wali,
                        'status_kepemilikan' => $request->status_kepemilikan_wali,
                        'provinsi'           => $request->provinsi_wali,
                        'kabupaten'          => $request->kabupaten_wali,
                        'kecamatan'          => $request->kecamatan_wali,
                        'desa'               => $request->desa_wali,
                        'rw'                 => $request->rw_wali,
                        'rt'                 => $request->rt_wali,
                        'alamat'             => $request->alamat_wali,
                        'kode_pos'           => $request->kode_pos_wali,
                    ])->save();
                }
            }

            // Update Alamat Santri
            if ($request->filled('alamat_santri')) {
                $alamatSantri = AlamatSantri::firstOrNew(['id_santri' => $santri->id]);
                $alamatSantri->fill([
                    'id_santri' => $santri->id,
                    'status_mukim' => $request->status_mukim,
                    'status_tempat_tinggal' => $request->status_tempat_tinggal,
                    'provinsi' => $request->provinsi_santri,
                    'kabupaten' => $request->kabupaten_santri,
                    'kecamatan' => $request->kecamatan_santri,
                    'desa' => $request->desa_santri,
                    'rw' => $request->rw_santri,
                    'rt' => $request->rt_santri,
                    'alamat' => $request->alamat_santri,
                    'kode_pos' => $request->kode_pos_santri,
                    'jarak_ke_lembaga' => $request->jarak_ke_lembaga,
                    'transportasi' => $request->transportasi,
                    'waktu_tempuh' => $request->waktu_tempuh,
                    'koordinat' => $request->koordinat,
                ])->save();
            }

            // Sync WaliSantri jika ada
            if ($santri->id_wali) {
                $waliUser = \App\Models\WaliSantri::find($santri->id_wali);
                if ($waliUser) {
                    $syncData = [];
                    if ($request->filled('nama_lengkap_ayah') && strtolower(trim($waliUser->nama_wali)) === strtolower(trim($request->nama_lengkap_ayah))) {
                        if ($request->filled('no_hp_ayah') && $waliUser->no_hp !== $request->no_hp_ayah) {
                            $syncData['no_hp'] = $request->no_hp_ayah;
                            $syncData['password'] = \Illuminate\Support\Facades\Hash::make($request->no_hp_ayah);
                            $syncData['plain_password'] = $request->no_hp_ayah;
                        }
                    } elseif ($request->filled('nama_lengkap_ibu') && strtolower(trim($waliUser->nama_wali)) === strtolower(trim($request->nama_lengkap_ibu))) {
                        if ($request->filled('no_hp_ibu') && $waliUser->no_hp !== $request->no_hp_ibu) {
                            $syncData['no_hp'] = $request->no_hp_ibu;
                            $syncData['password'] = \Illuminate\Support\Facades\Hash::make($request->no_hp_ibu);
                            $syncData['plain_password'] = $request->no_hp_ibu;
                        }
                    } elseif ($request->filled('nama_lengkap_wali') && strtolower(trim($waliUser->nama_wali)) === strtolower(trim($request->nama_lengkap_wali))) {
                        if ($request->filled('no_hp_wali') && $waliUser->no_hp !== $request->no_hp_wali) {
                            $syncData['no_hp'] = $request->no_hp_wali;
                            $syncData['password'] = \Illuminate\Support\Facades\Hash::make($request->no_hp_wali);
                            $syncData['plain_password'] = $request->no_hp_wali;
                        }
                    }
                    if (!empty($syncData)) {
                        $waliUser->update($syncData);
                    }
                }
            }
        });

        return redirect()->route('admin.santri.show', $id)
            ->with('success', 'Data santri berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $santri = Santri::findOrFail($id);
            if ($santri->dataAyah) {
                $santri->dataAyah->alamat()->delete();
                $santri->dataAyah()->delete();
            }
            if ($santri->dataIbu) {
                $santri->dataIbu->alamat()->delete();
                $santri->dataIbu()->delete();
            }
            $santri->dataSantri()->delete();
            $santri->alamatSantri()->delete();
            $santri->delete();
        });
        return redirect()->route('admin.santri.index')
            ->with('success', 'Data santri berhasil dihapus!');
    }

    // ─── MULTI-STEP FORM (Session Draft) ─────────────────────────────────────

    /**
     * Simpan data satu tab ke session (AJAX).
     * File foto disimpan sementara di storage/app/public/tmp/
     */
    public function saveStep(Request $request)
    {
        $step = $request->input('step');
        $draft = session('santri_draft', []);

        if ($step === 'foto') {
            // Validasi dan simpan file foto
            $request->validate([
                'foto_3x4' => 'nullable|image|max:2048',
                'foto_kk'  => 'nullable|image|max:2048',
            ], [
                'foto_3x4.image' => 'File harus berupa gambar.',
                'foto_3x4.max'   => 'Foto 3x4 maksimal 2 MB.',
                'foto_kk.image'  => 'File harus berupa gambar.',
                'foto_kk.max'    => 'Foto KK maksimal 2 MB.',
            ]);

            if ($request->hasFile('foto_3x4')) {
                // Hapus file lama jika ada
                if (!empty($draft['foto']['foto_3x4_tmp'])) {
                    @unlink(storage_path('app/public/tmp/' . $draft['foto']['foto_3x4_tmp']));
                }
                $file = $request->file('foto_3x4');
                $filename = 'foto3x4_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('tmp', $filename, 'public');
                $draft['foto']['foto_3x4_tmp']          = $filename;
                $draft['foto']['foto_3x4_original_name'] = $file->getClientOriginalName();
            }

            if ($request->hasFile('foto_kk')) {
                if (!empty($draft['foto']['foto_kk_tmp'])) {
                    @unlink(storage_path('app/public/tmp/' . $draft['foto']['foto_kk_tmp']));
                }
                $file = $request->file('foto_kk');
                $filename = 'fotokk_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('tmp', $filename, 'public');
                $draft['foto']['foto_kk_tmp']          = $filename;
                $draft['foto']['foto_kk_original_name'] = $file->getClientOriginalName();
            }
        } else {
            // Simpan field teks biasa sesuai step
            $allowedKeys = [
                'utama'   => ['status_data','id_wali'],
                'pribadi' => ['nama_lengkap','nik','no_kk','kewarganegaraan','nama_kapala_keluarga',
                              'tempat_lahir','tanggal_lahir','jenis_kelamin','agama','anak_ke',
                              'jumlah_saudara','no_hp','email','cita_cita','hobi','pembiaya_sekolah',
                              'tahun_masuk','tahun_keluar','kebutuhan_disabilitas','kebutuhan_khusus'],
                'ayah'    => ['nama_lengkap_ayah','status_ayah','no_hp_ayah','nik_ayah',
                              'kewarganegaraan_ayah','tempat_lahir_ayah','tanggal_lahir_ayah',
                              'pendidikan_terakhir_ayah','pekerjaan_utama_ayah','penghasilan_perbulan_ayah'],
                'ibu'     => ['nama_lengkap_ibu','status_ibu','no_hp_ibu','nik_ibu',
                              'kewarganegaraan_ibu','tempat_lahir_ibu','tanggal_lahir_ibu',
                              'pendidikan_terakhir_ibu','pekerjaan_utama_ibu','penghasilan_perbulan_ibu'],
                'wali'    => ['nama_lengkap_wali','status_wali','no_hp_wali','nik_wali',
                              'kewarganegaraan_wali','tempat_lahir_wali','tanggal_lahir_wali',
                              'pendidikan_terakhir_wali','pekerjaan_utama_wali','penghasilan_perbulan_wali',
                              'alamat_wali','rt_wali','rw_wali','desa_wali','kecamatan_wali',
                              'kabupaten_wali','provinsi_wali','kode_pos_wali','status_kepemilikan_wali'],
                'alamat'  => ['alamat_ayah','rt_ayah','rw_ayah','desa_ayah','kecamatan_ayah',
                              'kabupaten_ayah','provinsi_ayah','kode_pos_ayah','status_kepemilikan_ayah',
                              'alamat_ibu','rt_ibu','rw_ibu','desa_ibu','kecamatan_ibu',
                              'kabupaten_ibu','provinsi_ibu','kode_pos_ibu','status_kepemilikan_ibu',
                              'alamat_santri','rt_santri','rw_santri','desa_santri','kecamatan_santri',
                              'kabupaten_santri','provinsi_santri','kode_pos_santri','koordinat',
                              'status_mukim','status_tempat_tinggal',
                              'transportasi','jarak_ke_lembaga','waktu_tempuh'],
            ];

            $keys = $allowedKeys[$step] ?? [];
            foreach ($keys as $key) {
                if ($request->has($key)) {
                    $draft[$step][$key] = $request->input($key);
                }
            }
        }

        session(['santri_draft' => $draft]);

        return response()->json(['success' => true, 'step' => $step]);
    }

    /**
     * Tampilkan halaman preview (baca dari session).
     */
    public function preview()
    {
        $draft = session('santri_draft', []);
        $waliList = WaliSantri::orderBy('nama_wali')->get();
        return view('admin.santri.preview', compact('draft', 'waliList'));
    }

    /**
     * Simpan akhir ke database, buat akun WaliSantri secara otomatis,
     * lalu bersihkan session.
     */
    public function storeFinal(Request $request)
    {
        $draft = session('santri_draft', []);

        if (empty($draft)) {
            return redirect()->route('admin.santri.create')
                ->with('error', 'Session data kosong. Silakan isi form kembali.');
        }

        // ── Validasi data penting sebelum simpan ──────────────────────────
        $errors = [];
        $pribadi = $draft['pribadi'] ?? [];
        $waliD   = $draft['wali']    ?? [];

        if (empty($pribadi['nama_lengkap'])) {
            $errors[] = 'Nama Lengkap Santri wajib diisi.';
        }

        // Jika data wali diisi tapi hubungan kosong, beri peringatan
        if (!empty($waliD['nama_lengkap_wali']) && empty($waliD['status_wali'])) {
            $errors[] = 'Hubungan Wali dengan Santri wajib dipilih (Paman/Bibi, Kakek/Nenek, dll) di tab Data Wali.';
        }

        if (!empty($errors)) {
            return redirect()->route('admin.santri.create')
                ->withErrors($errors)
                ->with('error', 'Terdapat data yang belum lengkap. Silakan periksa kembali.');
        }

        DB::transaction(function () use ($draft) {
            $utama   = $draft['utama']   ?? [];
            $pribadi = $draft['pribadi'] ?? [];
            $ayahD   = $draft['ayah']    ?? [];
            $ibuD    = $draft['ibu']     ?? [];
            $waliD   = $draft['wali']    ?? [];
            $alamat  = $draft['alamat']  ?? [];
            $foto    = $draft['foto']    ?? [];

            // ── Buat akun WaliSantri otomatis ────────────────────────────
            $namaWali  = $waliD['nama_lengkap_wali'] ?? ($pribadi['nama_lengkap'] ?? 'Wali');
            $noHpWali  = $waliD['no_hp_wali']        ?? '';
            $emailWali = null; // bisa ditambah di masa depan

            // Username: slug nama + random 4 digit
            $baseUsername = Str::slug($namaWali, '') . rand(1000, 9999);
            $username = strtolower($baseUsername);
            // Pastikan unik
            $suffix = 1;
            while (WaliSantri::where('username', $username)->exists()) {
                $username = strtolower($baseUsername) . $suffix++;
            }

            // Password default = no HP wali, atau random jika kosong
            $defaultPassword = !empty($noHpWali) ? $noHpWali : Str::random(10);

            $wali = WaliSantri::create([
                'nama_wali'      => $namaWali,
                'no_hp'          => $noHpWali,
                'alamat'         => $waliD['alamat_wali']    ?? ($alamat['alamat_santri'] ?? null),
                'email'          => $emailWali,
                'username'       => $username,
                'password'       => Hash::make($defaultPassword),
                'plain_password' => $defaultPassword,
            ]);

            // ── Simpan record Santri ──────────────────────────────────────
            $santri = Santri::create([
                'id_wali'     => $wali->id_wali,
                'status_data' => $utama['status_data'] ?? 'aktif',
            ]);

            // Pindahkan file foto dari tmp ke permanen
            $foto3x4Path = null;
            $fotoKkPath  = null;
            if (!empty($foto['foto_3x4_tmp'])) {
                $newName = 'foto3x4_' . $santri->id . '_' . $foto['foto_3x4_tmp'];
                \Storage::disk('public')->move('tmp/' . $foto['foto_3x4_tmp'], 'berkas/' . $newName);
                $foto3x4Path = $newName;
            }
            if (!empty($foto['foto_kk_tmp'])) {
                $newName = 'fotokk_' . $santri->id . '_' . $foto['foto_kk_tmp'];
                \Storage::disk('public')->move('tmp/' . $foto['foto_kk_tmp'], 'berkas/' . $newName);
                $fotoKkPath = $newName;
            }

            // ── DataSantri ────────────────────────────────────────────────
            DataSantri::create([
                'id_santri'            => $santri->id,
                'nama_lengkap'         => $pribadi['nama_lengkap']          ?? null,
                'nik'                  => $pribadi['nik']                   ?? null,
                'no_kk'                => $pribadi['no_kk']                 ?? null,
                'kewarganegaraan'      => $pribadi['kewarganegaraan']       ?? 'WNI',
                'nama_kapala_keluarga' => $pribadi['nama_kapala_keluarga']  ?? null,
                'tempat_lahir'         => $pribadi['tempat_lahir']          ?? null,
                'tanggal_lahir'        => $pribadi['tanggal_lahir']         ?? null,
                'jenis_kelamin'        => $pribadi['jenis_kelamin']         ?? null,
                'agama'                => $pribadi['agama']                 ?? 'Islam',
                'anak_ke'              => $pribadi['anak_ke']               ?? null,
                'jumlah_saudara'       => $pribadi['jumlah_saudara']        ?? null,
                'no_hp'                => $pribadi['no_hp']                 ?? null,
                'email'                => $pribadi['email']                 ?? null,
                'cita_cita'            => $pribadi['cita_cita']             ?? null,
                'hobi'                 => $pribadi['hobi']                  ?? null,
                'pembiaya_sekolah'     => $pribadi['pembiaya_sekolah']      ?? null,
                'tahun_masuk'          => $pribadi['tahun_masuk']           ?? null,
                'tahun_keluar'         => $pribadi['tahun_keluar']          ?? null,
                'kebutuhan_disabilitas'=> $pribadi['kebutuhan_disabilitas'] ?? null,
                'kebutuhan_khusus'     => $pribadi['kebutuhan_khusus']      ?? null,
                'foto_3x4'             => $foto3x4Path,
                'foto_kk'              => $fotoKkPath,
            ]);

            // ── Data Ayah ─────────────────────────────────────────────────
            if (!empty($ayahD['nama_lengkap_ayah'])) {
                $ayah = DataAyah::create([
                    'id_santri'            => $santri->id,
                    'nama_lengkap'         => $ayahD['nama_lengkap_ayah'],
                    'status'               => $ayahD['status_ayah']               ?? null,
                    'kewarganegaraan'      => $ayahD['kewarganegaraan_ayah']      ?? 'WNI',
                    'nik'                  => $ayahD['nik_ayah']                  ?? null,
                    'tempat_lahir'         => $ayahD['tempat_lahir_ayah']         ?? null,
                    'tanggal_lahir'        => $ayahD['tanggal_lahir_ayah']        ?? null,
                    'pendidikan_terakhir'  => $ayahD['pendidikan_terakhir_ayah']  ?? null,
                    'pekerjaan_utama'      => $ayahD['pekerjaan_utama_ayah']      ?? null,
                    'penghasilan_perbulan' => $ayahD['penghasilan_perbulan_ayah'] ?? null,
                    'no_hp'                => $ayahD['no_hp_ayah']                ?? null,
                ]);

                if (!empty($alamat['alamat_ayah'])) {
                    AlamatAyah::create([
                        'id_ayah'            => $ayah->id_ayah,
                        'alamat'             => $alamat['alamat_ayah'],
                        'rt'                 => $alamat['rt_ayah']                 ?? null,
                        'rw'                 => $alamat['rw_ayah']                 ?? null,
                        'desa'               => $alamat['desa_ayah']               ?? null,
                        'kecamatan'          => $alamat['kecamatan_ayah']          ?? null,
                        'kabupaten'          => $alamat['kabupaten_ayah']          ?? null,
                        'provinsi'           => $alamat['provinsi_ayah']           ?? null,
                        'kode_pos'           => $alamat['kode_pos_ayah']           ?? null,
                        'status_kepemilikan' => $alamat['status_kepemilikan_ayah'] ?? null,
                    ]);
                }
            }

            // ── Data Ibu ──────────────────────────────────────────────────
            if (!empty($ibuD['nama_lengkap_ibu'])) {
                $ibu = DataIbu::create([
                    'id_santri'            => $santri->id,
                    'nama_lengkap'         => $ibuD['nama_lengkap_ibu'],
                    'status'               => $ibuD['status_ibu']               ?? null,
                    'kewarganegaraan'      => $ibuD['kewarganegaraan_ibu']      ?? 'WNI',
                    'nik'                  => $ibuD['nik_ibu']                  ?? null,
                    'tempat_lahir'         => $ibuD['tempat_lahir_ibu']         ?? null,
                    'tanggal_lahir'        => $ibuD['tanggal_lahir_ibu']        ?? null,
                    'pendidikan_terakhir'  => $ibuD['pendidikan_terakhir_ibu']  ?? null,
                    'pekerjaan_utama'      => $ibuD['pekerjaan_utama_ibu']      ?? null,
                    'penghasilan_perbulan' => $ibuD['penghasilan_perbulan_ibu'] ?? null,
                    'no_hp'                => $ibuD['no_hp_ibu']                ?? null,
                ]);

                if (!empty($alamat['alamat_ibu'])) {
                    AlamatIbu::create([
                        'id_ibu'             => $ibu->id_ibu,
                        'alamat'             => $alamat['alamat_ibu'],
                        'rt'                 => $alamat['rt_ibu']                 ?? null,
                        'rw'                 => $alamat['rw_ibu']                 ?? null,
                        'desa'               => $alamat['desa_ibu']               ?? null,
                        'kecamatan'          => $alamat['kecamatan_ibu']          ?? null,
                        'kabupaten'          => $alamat['kabupaten_ibu']          ?? null,
                        'provinsi'           => $alamat['provinsi_ibu']           ?? null,
                        'kode_pos'           => $alamat['kode_pos_ibu']           ?? null,
                        'status_kepemilikan' => $alamat['status_kepemilikan_ibu'] ?? null,
                    ]);
                }
            }

            // ── Data Wali ─────────────────────────────────────────────────
            if (!empty($waliD['nama_lengkap_wali'])) {
                $dataWali = DataWali::create([
                    'id_santri'            => $santri->id,
                    'nama_lengkap'         => $waliD['nama_lengkap_wali'],
                    'status'               => $waliD['status_wali']               ?? null,
                    'kewarganegaraan'      => $waliD['kewarganegaraan_wali']      ?? 'WNI',
                    'nik'                  => $waliD['nik_wali']                  ?? null,
                    'tempat_lahir'         => $waliD['tempat_lahir_wali']         ?? null,
                    'tanggal_lahir'        => $waliD['tanggal_lahir_wali']        ?? null,
                    'pendidikan_terakhir'  => $waliD['pendidikan_terakhir_wali']  ?? null,
                    'pekerjaan_utama'      => $waliD['pekerjaan_utama_wali']      ?? null,
                    'penghasilan_perbulan' => $waliD['penghasilan_perbulan_wali'] ?? null,
                    'no_hp'                => $waliD['no_hp_wali']                ?? null,
                ]);

                if (!empty($waliD['alamat_wali'])) {
                    AlamatWali::create([
                        'id_wali'            => $dataWali->id_wali,
                        'alamat'             => $waliD['alamat_wali'],
                        'rt'                 => $waliD['rt_wali']                 ?? null,
                        'rw'                 => $waliD['rw_wali']                 ?? null,
                        'desa'               => $waliD['desa_wali']               ?? null,
                        'kecamatan'          => $waliD['kecamatan_wali']          ?? null,
                        'kabupaten'          => $waliD['kabupaten_wali']          ?? null,
                        'provinsi'           => $waliD['provinsi_wali']           ?? null,
                        'kode_pos'           => $waliD['kode_pos_wali']           ?? null,
                        'status_kepemilikan' => $waliD['status_kepemilikan_wali'] ?? null,
                    ]);
                }
            }

            // ── Alamat Santri ─────────────────────────────────────────────
            if (!empty($alamat['alamat_santri'])) {
                AlamatSantri::create([
                    'id_santri'            => $santri->id,
                    'alamat'               => $alamat['alamat_santri'],
                    'rt'                   => $alamat['rt_santri']                ?? null,
                    'rw'                   => $alamat['rw_santri']                ?? null,
                    'desa'                 => $alamat['desa_santri']              ?? null,
                    'kecamatan'            => $alamat['kecamatan_santri']         ?? null,
                    'kabupaten'            => $alamat['kabupaten_santri']         ?? null,
                    'provinsi'             => $alamat['provinsi_santri']          ?? null,
                    'kode_pos'             => $alamat['kode_pos_santri']          ?? null,
                    'koordinat'            => $alamat['koordinat']                ?? null,
                    'status_mukim'         => $alamat['status_mukim']             ?? null,
                    'status_tempat_tinggal'=> $alamat['status_tempat_tinggal']    ?? null,
                    'transportasi'         => $alamat['transportasi']             ?? null,
                    'jarak_ke_lembaga'     => $alamat['jarak_ke_lembaga']         ?? null,
                    'waktu_tempuh'         => $alamat['waktu_tempuh']             ?? null,
                ]);
            }

            // Simpan info akun wali ke session sementara agar bisa ditampilkan di flash
            session(['new_wali_account' => [
                'nama'     => $wali->nama_wali,
                'username' => $wali->username,
                'password' => $defaultPassword,
            ]]);
        });

        // Bersihkan draft session
        session()->forget('santri_draft');

        return redirect()->route('admin.santri.index')
            ->with('success', 'Data santri berhasil disimpan!')
            ->with('wali_account_created', true);
    }
}


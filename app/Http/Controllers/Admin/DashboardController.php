<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\WaliSantri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Cek apakah data santri sudah lengkap sesuai standar wali.
     * Field yang DIKECUALIKAN (tidak wajib):
     *   - DataSantri : email, cita_cita, hobi, kebutuhan_khusus, kebutuhan_disabilitas, tahun_keluar
     *   - AlamatSantri: koordinat
     */
    private function isSantriLengkap(Santri $santri): bool
    {
        // ── 1. DataSantri ──────────────────────────────────────────────
        $ds = $santri->dataSantri;
        if (!$ds) return false;

        $wajibSantri = [
            'nama_lengkap', 'nik', 'no_kk', 'kewarganegaraan',
            'nama_kapala_keluarga', 'tempat_lahir', 'tanggal_lahir',
            'jenis_kelamin', 'agama', 'anak_ke', 'jumlah_saudara',
            'no_hp', 'pembiaya_sekolah', 'tahun_masuk',
            'foto_3x4', 'foto_kk',
        ];
        foreach ($wajibSantri as $field) {
            if (empty($ds->$field) && $ds->$field !== '0' && $ds->$field !== 0) return false;
        }

        // ── 2. DataAyah ────────────────────────────────────────────────
        $da = $santri->dataAyah;
        if (!$da) return false;

        $wajibAyah = [
            'nama_lengkap', 'status', 'nik', 'kewarganegaraan',
            'tempat_lahir', 'tanggal_lahir', 'pendidikan_terakhir',
            'no_hp', 'pekerjaan_utama', 'penghasilan_perbulan',
        ];
        foreach ($wajibAyah as $field) {
            if (empty($da->$field) && $da->$field !== '0' && $da->$field !== 0) return false;
        }

        // AlamatAyah
        $aa = $da->alamat;
        if (!$aa) return false;
        $wajibAlamatAyah = ['alamat', 'rt', 'rw', 'desa', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'status_kepemilikan'];
        foreach ($wajibAlamatAyah as $field) {
            if (empty($aa->$field) && $aa->$field !== '0' && $aa->$field !== 0) return false;
        }

        // ── 3. DataIbu ─────────────────────────────────────────────────
        $di = $santri->dataIbu;
        if (!$di) return false;

        $wajibIbu = [
            'nama_lengkap', 'status', 'nik', 'kewarganegaraan',
            'tempat_lahir', 'tanggal_lahir', 'pendidikan_terakhir',
            'no_hp', 'pekerjaan_utama', 'penghasilan_perbulan',
        ];
        foreach ($wajibIbu as $field) {
            if (empty($di->$field) && $di->$field !== '0' && $di->$field !== 0) return false;
        }

        // AlamatIbu
        $ai = $di->alamat;
        if (!$ai) return false;
        $wajibAlamatIbu = ['alamat', 'rt', 'rw', 'desa', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'status_kepemilikan'];
        foreach ($wajibAlamatIbu as $field) {
            if (empty($ai->$field) && $ai->$field !== '0' && $ai->$field !== 0) return false;
        }

        // ── 4. DataWali ────────────────────────────────────────────────
        $dw = $santri->dataWali;
        if (!$dw) return false;

        $wajibWali = [
            'nama_lengkap', 'status', 'nik', 'kewarganegaraan',
            'tempat_lahir', 'tanggal_lahir', 'pendidikan_terakhir',
            'no_hp', 'pekerjaan_utama', 'penghasilan_perbulan',
        ];
        foreach ($wajibWali as $field) {
            if (empty($dw->$field) && $dw->$field !== '0' && $dw->$field !== 0) return false;
        }

        // AlamatWali
        $aw = $dw->alamat;
        if (!$aw) return false;
        $wajibAlamatWali = ['alamat', 'rt', 'rw', 'desa', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'status_kepemilikan'];
        foreach ($wajibAlamatWali as $field) {
            if (empty($aw->$field) && $aw->$field !== '0' && $aw->$field !== 0) return false;
        }

        // ── 5. AlamatSantri (DIISI ADMIN, TIDAK WAJIB UNTUK WALI) ───────────────────
        // (Dihapus dari syarat kelengkapan agar tidak menghalangi status Lengkap)

        return true;
    }

    public function index()
    {
        // Load semua santri dengan seluruh relasi yang diperlukan untuk cek
        $allSantri = Santri::with([
            'dataSantri',
            'dataAyah.alamat',
            'dataIbu.alamat',
            'dataWali.alamat',
            'alamatSantri',
            'wali',
        ])->get();

        // Filter santri yang keluar/tidak aktif agar tidak masuk dalam daftar kelengkapan
        $trackedSantri = $allSantri->filter(function ($s) {
            $status = strtolower(trim($s->status_data ?? ''));
            return !in_array($status, ['keluar', 'tidak aktif']);
        });

        // Filter mana yang belum lengkap (kriteria ketat berdasarkan standar wali)
        $santriBelumLengkapCollection = $trackedSantri->filter(function ($s) {
            return !$this->isSantriLengkap($s);
        });

        $totalBelumLengkap  = $santriBelumLengkapCollection->count();
        // Kirim semua data ke view, pagination ditangani JS
        $santriBelumLengkap = $santriBelumLengkapCollection->values();

        $santriLengkapCollection = $trackedSantri->filter(function ($s) {
            return $this->isSantriLengkap($s);
        })->map(function ($s) {
            $dates = collect([
                $s->updated_at,
                $s->dataSantri ? $s->dataSantri->updated_at : null,
                $s->dataAyah ? $s->dataAyah->updated_at : null,
                $s->dataIbu ? $s->dataIbu->updated_at : null,
                $s->dataWali ? $s->dataWali->updated_at : null,
                $s->alamatSantri ? $s->alamatSantri->updated_at : null,
            ])->filter();
            $s->completed_at = $dates->max();
            return $s;
        })->sortByDesc('completed_at');
        $santriLengkap = $santriLengkapCollection->values();

        $stats = [
            'total'         => $allSantri->count(),
            'aktif'         => $allSantri->where('status_data', 'aktif')->count(),
            'lulus'         => $allSantri->where('status_data', 'lulus')->count(),
            'keluar'        => $allSantri->where('status_data', 'keluar')->count(),
            'tidak_aktif'   => $allSantri->where('status_data', 'tidak aktif')->count(),
            'wali'          => WaliSantri::count(),
            'belum_lengkap' => $totalBelumLengkap,
        ];

        $stats['lengkap'] = $santriLengkapCollection->count();

        $admin = Auth::guard('admin')->user();
        return view('admin.dashboard', compact('stats', 'admin', 'santriBelumLengkap', 'santriLengkap'));
    }

    public function verifySantri(Request $request)
    {
        $verifiedIds = $request->input('verified_santri', []);
        
        // Set is_verified = 1 untuk yang dicentang
        if (count($verifiedIds) > 0) {
            \App\Models\Santri::whereIn('id', $verifiedIds)->update(['is_verified' => 1]);
        }
        
        // Set is_verified = 0 untuk semua yang tidak dicentang
        \App\Models\Santri::whereNotIn('id', $verifiedIds)->update(['is_verified' => 0]);

        return redirect()->back()->with('success', 'Status pengecekan data santri berhasil disimpan!');
    }
}

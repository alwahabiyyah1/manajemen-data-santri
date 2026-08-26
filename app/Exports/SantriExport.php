<?php

namespace App\Exports;

use App\Models\Santri;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SantriExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $search;
    protected $status;
    protected $tahun_masuk;
    protected $jenis_kelamin;
    protected $rowNumber = 0;

    public function __construct($search, $status, $tahun_masuk, $jenis_kelamin)
    {
        $this->search = $search;
        $this->status = $status;
        $this->tahun_masuk = $tahun_masuk;
        $this->jenis_kelamin = $jenis_kelamin;
    }

    public function title(): string
    {
        return 'Data Santri Lengkap';
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Santri::with([
            'dataSantri',
            'dataAyah.alamat',
            'dataIbu.alamat',
            'dataWali.alamat',
            'alamatSantri',
            'wali',
        ]);

        if ($this->search) {
            $query->whereHas('dataSantri', function($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
            });
        }
        if ($this->status) {
            $query->where('status_data', $this->status);
        }
        if ($this->tahun_masuk) {
            $query->whereHas('dataSantri', function($q) {
                $q->where('tahun_masuk', $this->tahun_masuk);
            });
        }
        if ($this->jenis_kelamin) {
            $query->whereHas('dataSantri', function($q) {
                $q->where('jenis_kelamin', $this->jenis_kelamin);
            });
        }

        return $query->orderBy('id', 'desc')->get();
    }

    /**
     * Helper: buat URL foto yang benar (dengan prefix berkas/)
     */
    private function fotoUrl($filename)
    {
        if (empty($filename)) return '-';
        return url('storage/berkas/' . $filename);
    }

    /**
    * @var Santri $santri
    */
    public function map($santri): array
    {
        $this->rowNumber++;

        $ds = $santri->dataSantri;
        $ayah = $santri->dataAyah;
        $ibu = $santri->dataIbu;
        $wali = $santri->dataWali;
        $alamatSantri = $santri->alamatSantri;
        $alamatAyah = $ayah?->alamat;
        $alamatIbu = $ibu?->alamat;
        $alamatWali = $wali?->alamat;
        $waliAkun = $santri->wali;

        return [
            // No
            $this->rowNumber,

            // ─── IDENTITAS SANTRI ─────────────────────────
            $ds->nama_lengkap ?? '-',
            $ds->nik ?? '-',
            $ds->no_kk ?? '-',
            $ds->nama_kapala_keluarga ?? '-',
            $ds->kewarganegaraan ?? '-',
            $ds->jenis_kelamin ?? '-',
            $ds->tempat_lahir ?? '-',
            $ds->tanggal_lahir ?? '-',
            $ds->agama ?? '-',
            $ds->anak_ke ?? '-',
            $ds->jumlah_saudara ?? '-',
            $ds->no_hp ?? '-',
            $ds->email ?? '-',
            $ds->cita_cita ?? '-',
            $ds->hobi ?? '-',
            $ds->pembiaya_sekolah ?? '-',
            $ds->kebutuhan_khusus ?? '-',
            $ds->kebutuhan_disabilitas ?? '-',
            $ds->tahun_masuk ?? '-',
            $ds->tahun_keluar ?? '-',
            ucfirst($santri->status_data),

            // ─── AKUN PERWALIAN ───────────────────────────
            $waliAkun->nama_wali ?? '-',
            $waliAkun->no_hp ?? '-',
            $waliAkun->username ?? '-',

            // ─── DATA AYAH ───────────────────────────────
            $ayah->nama_lengkap ?? '-',
            $ayah->status ?? '-',
            $ayah->nik ?? '-',
            $ayah->kewarganegaraan ?? '-',
            $ayah->tempat_lahir ?? '-',
            $ayah->tanggal_lahir ?? '-',
            $ayah->pendidikan_terakhir ?? '-',
            $ayah->pekerjaan_utama ?? '-',
            $ayah->penghasilan_perbulan ?? '-',
            $ayah->no_hp ?? '-',

            // ─── ALAMAT AYAH ─────────────────────────────
            $alamatAyah->alamat ?? '-',
            $alamatAyah->rt ?? '-',
            $alamatAyah->rw ?? '-',
            $alamatAyah->desa ?? '-',
            $alamatAyah->kecamatan ?? '-',
            $alamatAyah->kabupaten ?? '-',
            $alamatAyah->provinsi ?? '-',
            $alamatAyah->kode_pos ?? '-',
            $alamatAyah->status_kepemilikan ?? '-',

            // ─── DATA IBU ────────────────────────────────
            $ibu->nama_lengkap ?? '-',
            $ibu->status ?? '-',
            $ibu->nik ?? '-',
            $ibu->kewarganegaraan ?? '-',
            $ibu->tempat_lahir ?? '-',
            $ibu->tanggal_lahir ?? '-',
            $ibu->pendidikan_terakhir ?? '-',
            $ibu->pekerjaan_utama ?? '-',
            $ibu->penghasilan_perbulan ?? '-',
            $ibu->no_hp ?? '-',

            // ─── ALAMAT IBU ──────────────────────────────
            $alamatIbu->alamat ?? '-',
            $alamatIbu->rt ?? '-',
            $alamatIbu->rw ?? '-',
            $alamatIbu->desa ?? '-',
            $alamatIbu->kecamatan ?? '-',
            $alamatIbu->kabupaten ?? '-',
            $alamatIbu->provinsi ?? '-',
            $alamatIbu->kode_pos ?? '-',
            $alamatIbu->status_kepemilikan ?? '-',

            // ─── DATA WALI ───────────────────────────────
            $wali->nama_lengkap ?? '-',
            $wali->status ?? '-',
            $wali->nik ?? '-',
            $wali->kewarganegaraan ?? '-',
            $wali->tempat_lahir ?? '-',
            $wali->tanggal_lahir ?? '-',
            $wali->pendidikan_terakhir ?? '-',
            $wali->pekerjaan_utama ?? '-',
            $wali->penghasilan_perbulan ?? '-',
            $wali->no_hp ?? '-',

            // ─── ALAMAT WALI ─────────────────────────────
            $alamatWali->alamat ?? '-',
            $alamatWali->rt ?? '-',
            $alamatWali->rw ?? '-',
            $alamatWali->desa ?? '-',
            $alamatWali->kecamatan ?? '-',
            $alamatWali->kabupaten ?? '-',
            $alamatWali->provinsi ?? '-',
            $alamatWali->kode_pos ?? '-',
            $alamatWali->status_kepemilikan ?? '-',

            // ─── ALAMAT SANTRI ───────────────────────────
            $alamatSantri->alamat ?? '-',
            $alamatSantri->rt ?? '-',
            $alamatSantri->rw ?? '-',
            $alamatSantri->desa ?? '-',
            $alamatSantri->kecamatan ?? '-',
            $alamatSantri->kabupaten ?? '-',
            $alamatSantri->provinsi ?? '-',
            $alamatSantri->kode_pos ?? '-',
            $alamatSantri->status_mukim ?? '-',
            $alamatSantri->status_tempat_tinggal ?? '-',
            $alamatSantri->jarak_ke_lembaga ?? '-',
            $alamatSantri->transportasi ?? '-',
            $alamatSantri->waktu_tempuh ?? '-',
            $alamatSantri->koordinat ?? '-',

            // ─── FOTO (LINK) ─────────────────────────────
            $this->fotoUrl($ds->foto_3x4 ?? null),
            $this->fotoUrl($ds->foto_kk ?? null),
        ];
    }

    public function headings(): array
    {
        return [
            'No',

            // Identitas Santri
            'Nama Lengkap Santri',
            'NIK Santri',
            'No. KK',
            'Nama Kepala Keluarga',
            'Kewarganegaraan',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Agama',
            'Anak Ke',
            'Jumlah Saudara',
            'No. HP Santri',
            'Email',
            'Cita-cita',
            'Hobi',
            'Pembiaya Sekolah',
            'Kebutuhan Khusus',
            'Kebutuhan Disabilitas',
            'Tahun Masuk',
            'Tahun Keluar',
            'Status Aktif',

            // Akun Perwalian
            'Nama Akun Perwalian',
            'No. HP Perwalian',
            'Username Perwalian',

            // Data Ayah
            'Nama Lengkap Ayah',
            'Status Ayah',
            'NIK Ayah',
            'Kewarganegaraan Ayah',
            'Tempat Lahir Ayah',
            'Tanggal Lahir Ayah',
            'Pendidikan Terakhir Ayah',
            'Pekerjaan Utama Ayah',
            'Penghasilan Ayah',
            'No. HP Ayah',

            // Alamat Ayah
            'Alamat Ayah',
            'RT Ayah',
            'RW Ayah',
            'Desa/Kel Ayah',
            'Kecamatan Ayah',
            'Kabupaten/Kota Ayah',
            'Provinsi Ayah',
            'Kode Pos Ayah',
            'Status Kepemilikan Rumah Ayah',

            // Data Ibu
            'Nama Lengkap Ibu',
            'Status Ibu',
            'NIK Ibu',
            'Kewarganegaraan Ibu',
            'Tempat Lahir Ibu',
            'Tanggal Lahir Ibu',
            'Pendidikan Terakhir Ibu',
            'Pekerjaan Utama Ibu',
            'Penghasilan Ibu',
            'No. HP Ibu',

            // Alamat Ibu
            'Alamat Ibu',
            'RT Ibu',
            'RW Ibu',
            'Desa/Kel Ibu',
            'Kecamatan Ibu',
            'Kabupaten/Kota Ibu',
            'Provinsi Ibu',
            'Kode Pos Ibu',
            'Status Kepemilikan Rumah Ibu',

            // Data Wali
            'Nama Lengkap Wali',
            'Hubungan Wali',
            'NIK Wali',
            'Kewarganegaraan Wali',
            'Tempat Lahir Wali',
            'Tanggal Lahir Wali',
            'Pendidikan Terakhir Wali',
            'Pekerjaan Utama Wali',
            'Penghasilan Wali',
            'No. HP Wali',

            // Alamat Wali
            'Alamat Wali',
            'RT Wali',
            'RW Wali',
            'Desa/Kel Wali',
            'Kecamatan Wali',
            'Kabupaten/Kota Wali',
            'Provinsi Wali',
            'Kode Pos Wali',
            'Status Kepemilikan Rumah Wali',

            // Alamat Santri
            'Alamat Santri',
            'RT Santri',
            'RW Santri',
            'Desa/Kel Santri',
            'Kecamatan Santri',
            'Kabupaten/Kota Santri',
            'Provinsi Santri',
            'Kode Pos Santri',
            'Status Mukim',
            'Status Tempat Tinggal',
            'Jarak ke Lembaga',
            'Transportasi',
            'Waktu Tempuh (menit)',
            'Koordinat',

            // Foto
            'Link Foto 3x4',
            'Link Foto KK',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastCol = $sheet->getHighestColumn();

        // Style header row
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1B4332'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Row height for header
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Freeze panes: freeze first row + first 2 columns (No + Nama)
        $sheet->freezePane('C2');

        // Auto-filter
        $sheet->setAutoFilter("A1:{$lastCol}1");

        // Style data rows with borders
        $lastRow = $sheet->getHighestRow();
        if ($lastRow > 1) {
            $sheet->getStyle("A2:{$lastCol}{$lastRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFD0D0D0'],
                    ],
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ],
            ]);

            // Alternate row coloring for readability
            for ($row = 2; $row <= $lastRow; $row++) {
                if ($row % 2 === 0) {
                    $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFF0F7F4'],
                        ],
                    ]);
                }
            }
        }

        return [];
    }
}

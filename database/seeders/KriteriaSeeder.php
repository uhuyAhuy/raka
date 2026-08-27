<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Kriteria;
use App\Models\Alternatif;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kode = ["K00001", "K00002", "K00003", "K00004", "K00005", "K00006", "K00007", "K00008"];
        $namaKriteria = [
            "Tingkat Kedisiplinan",
            "Kualitas Kerja",
            "Kerjasama Team",
            "Loyalitas",
            "Tanggung Jawab",
            "Kreativitas",
            "Sikap Kerja",
            "Kuantitas Kerja",
        ];
        $nilaiKriteria = [
            1, 0.5, 3, 4, 0.33, 6, 2, 5,
            2, 1, 4, 5, 0.5, 7, 3, 6,
            0.33, 0.25, 1, 2, 0.2, 4, 0.5, 3,
            0.25, 0.2, 0.5, 1, 0.17, 3, 0.33, 2,
            3, 2, 5, 6, 1, 8, 4, 7,
            0.17, 0.14, 0.25, 0.33, 0.13, 1, 0.2, 0.5,
            0.5, 0.33, 2, 3, 0.25, 5, 1, 4,
            0.2, 0.17, 0.33, 0.5, 0.14, 2, 0.25, 1,
        ];

        for ($i = 0; $i < 8; $i++) {
            Kriteria::create([
                "kode" => $kode[$i],
                "nama" => $namaKriteria[$i],
            ]);
        }

        $kriteria = Kriteria::orderBy('id', 'asc')->get();
        $j = 0;
        foreach ($kriteria as $krit) {
            foreach ($kriteria as $kritBanding) {
                DB::table('matriks_perbandingan_utama')->insert([
                    'nilai' => $nilaiKriteria[$j],
                    'kriteria_id' => $krit->id,
                    'kriteria_id_banding' => $kritBanding->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $j++;
            }
        }

        $this->matriks_nilai_utama();
        $this->matriks_penjumlahan_utama();
    }

    public function matriks_nilai_utama()
    {
        $matriksPerbandingan = DB::table('matriks_perbandingan_utama as mpu')
            ->join('kriteria as k', 'k.id', '=', 'mpu.kriteria_id')
            ->select('mpu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->orderBy('mpu.kriteria_id', 'asc')
            ->orderBy('mpu.kriteria_id_banding', 'asc')
            ->get();

        $kriteria = Kriteria::orderBy('id', 'asc')->get();

        DB::table('matriks_nilai_utama')->truncate();
        DB::table('matriks_nilai_prioritas_utama')->truncate();
        foreach ($matriksPerbandingan as $item) {
            $jumlahNilai = $matriksPerbandingan->where('kriteria_id_banding', $item->kriteria_id_banding)->sum('nilai');

            DB::table('matriks_nilai_utama')->insert([
                'nilai' => $item->nilai / $jumlahNilai,
                'kriteria_id' => $item->kriteria_id,
                'kriteria_id_banding' => $item->kriteria_id_banding,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $matriksNilai = DB::table('matriks_nilai_utama as mnu')
            ->join('kriteria as k', 'k.id', '=', 'mnu.kriteria_id')
            ->select('mnu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->get();

        foreach ($kriteria as $item) {
            $nilai = $matriksNilai->where('kriteria_id', $item->id)->sum('nilai');
            $jumlahKriteria = $kriteria->count();

            DB::table('matriks_nilai_prioritas_utama')->insert([
                'prioritas' => $nilai / $jumlahKriteria,
                'kriteria_id' => $item->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public function matriks_penjumlahan_utama()
    {
        $matriksPerbandingan = DB::table('matriks_perbandingan_utama as mpu')
            ->join('kriteria as k', 'k.id', '=', 'mpu.kriteria_id')
            ->select('mpu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->orderBy('mpu.kriteria_id', 'asc')
            ->orderBy('mpu.kriteria_id_banding', 'asc')
            ->get();

        $matriksNilaiPrioritas = DB::table('matriks_nilai_prioritas_utama as mnpu')
            ->join('kriteria as k', 'k.id', '=', 'mnpu.kriteria_id')
            ->select('mnpu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->get();

        $kriteria = Kriteria::orderBy('id', 'asc')->get();

        DB::table('matriks_penjumlahan_utama')->truncate();
        DB::table('matriks_penjumlahan_prioritas_utama')->truncate();
        foreach ($matriksPerbandingan as $item) {
            $prioritas = $matriksNilaiPrioritas->where('kriteria_id', $item->kriteria_id_banding)->first()->prioritas;

            DB::table('matriks_penjumlahan_utama')->insert([
                'nilai' => $item->nilai * $prioritas,
                'kriteria_id' => $item->kriteria_id,
                'kriteria_id_banding' => $item->kriteria_id_banding,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $matriksPenjumlahan = DB::table('matriks_penjumlahan_utama as mpu')
            ->join('kriteria as k', 'k.id', '=', 'mpu.kriteria_id')
            ->select('mpu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->orderBy('mpu.kriteria_id', 'asc')
            ->orderBy('mpu.kriteria_id_banding', 'asc')
            ->get();

        foreach ($kriteria as $item) {
            $nilai = $matriksPenjumlahan->where('kriteria_id', $item->id)->sum('nilai');
            $prioritas = $matriksNilaiPrioritas->where('kriteria_id', $item->id)->first()->prioritas;

            DB::table('matriks_penjumlahan_prioritas_utama')->insert([
                'prioritas' => $nilai / $prioritas,
                'kriteria_id' => $item->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alternatif>
 */
class AlternatifFactory extends Factory
{
    /**
     * Daftar nama karyawan bergaya Indonesia (statis, tidak bergantung locale Faker)
     */
    protected static array $namaIndonesia = [
            "Julia Hidayat",
            "Agus Iskandar",
            "Panji Purnama",
            "Ihsan Firmansyah",
            "Yeni Wibowo",
            "Okta Iskandar",
            "Tri Setiawan",
            "Diah Anggara",
            "Andi Wijaya",
            "Rudi Rahmawati",
            "Iwan Nasution",
            "Farida Wijaya",
            "Widya Kurniawan",
            "Umi Putra",
            "Salsa Hutagalung",
            "Wulan Handayani",
            "Dian Tampubolon",
            "Panji Widodo",
            "Ahmad Effendi",
            "Adi Salim",
            "Yuli Anggraini",
            "Panji Nugroho",
            "Hadi Effendi",
            "Fitri Wibowo",
            "Rudi Puspita",
            "Slamet Astuti",
            "Indah Napitupulu",
            "Nanda Widodo",
            "Dedi Sudrajat",
            "Fatimah Hutagalung",
            "Bayu Sanusi",
            "Putri Setiawan",
            "Wati Suryadi",
            "Ika Manurung",
            "Maya Sihombing",
            "Dian Kusnadi",
            "Hendra Kusuma",
            "Mira Handayani",
            "Doni Suryadi",
            "Joko Mahendra",
            "Iwan Setiadi",
            "Slamet Puspita",
            "Panji Maulana",
            "Julia Perkasa",
            "Maya Susanto",
            "Nurul Astuti",
            "Gunawan Putri",
            "Oki Salim",
            "Prita Putra",
            "Irfan Napitupulu",
            "Julia Susanto",
            "Sinta Sudrajat",
            "Lukman Susanto",
            "Hesti Puspita",
            "Oki Sanusi",
            "Julia Salim",
            "Widya Handayani",
            "Prita Permana",
            "Doni Rusdi",
            "Fajar Handayani",
            "Andi Widodo",
            "Siti Utami",
            "Oki Pratama",
            "Hadi Kuswanto",
            "Yulia Junaedi",
            "Umi Permana",
            "Hadi Putra",
            "Mega Utami",
            "Kirana Maulana",
            "Taufik Ramadhan",
            "Rian Purnama",
            "Asep Panjaitan",
            "Sinta Ramadhan",
            "Asep Tampubolon",
            "Yuli Priyanto",
            "Anisa Utami",
            "Maya Handayani",
            "Rian Nasution",
            "Mega Setiawan",
            "Bagus Saputra",
            "Yusuf Nugroho",
            "Ika Susanto",
            "Prita Anggara",
            "Eka Pratama",
            "Ratna Puspita",
            "Eka Maulana",
            "Rahayu Ramadhan",
            "Wati Setiadi",
            "Muhammad Halim",
            "Vina Hidayat",
            "Prita Junaedi",
            "Sinta Effendi",
            "Oki Rusdi",
            "Kirana Anggraini",
            "Yusuf Suryadi",
            "Yanti Susanto",
            "Fatimah Santoso",
            "Vina Junaedi",
            "Vina Ramadhan",
            "Nadia Effendi"
    ];

    protected static int $index = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $nama = self::$namaIndonesia[self::$index % count(self::$namaIndonesia)];
        self::$index++;

        return [
            'nama' => $nama,
        ];
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\surat_keterangan_kelahiran;
use Faker\Factory as Faker;
use Carbon\Carbon;

class SuratKeteranganKelahiranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 10; $i++) { // Seed 10 records, adjust as needed
            surat_keterangan_kelahiran::create([
                'nama_kepala_keluarga' => $faker->name,
                'nomor_kepala_keluarga' => $faker->unique()->numerify('##########'),
                'nama_bayi' => $faker->name,
                'jenis_kelamin_bayi' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'tempat_dilahirkan' => $faker->randomElement(['Rumah Sakit', 'Puskesmas', 'Polindes', 'Rumah', 'Lainnya']),
                'tempat_kelahiran' => $faker->city,
                'tanggal_lahir_bayi' => Carbon::now()->subDays(rand(1, 365)),
                'pukul_lahir' => Carbon::now()->format('H:i'),
                'jenis_kelahiran' => $faker->randomElement(['Tunggal', 'Kembar 2', 'Kembar 3', 'Kembar 4', 'Lainnya']),
                'penolong_kelahiran' => $faker->randomElement(['Dokter', 'Bidan/Perawat', 'Dukun', 'Lainnya']),
                'berat_bayi' => $faker->randomFloat(2, 2.5, 4.0), // 2.5 to 4 kg
                'panjang_bayi' => $faker->randomFloat(1, 45, 55), // 45 to 55 cm
                'nik_ayah' => $faker->unique()->numerify('##########'),
                'nama_ayah' => $faker->name,
                'tanggal_lahir_ayah' => Carbon::now()->subYears(rand(20, 60)),
                'umur_ayah' => $faker->numberBetween(20, 60),
                'pekerjaan_ayah' => $faker->jobTitle,
                'alamat_ayah' => $faker->address,
                'nik_ibu' => $faker->unique()->numerify('##########'),
                'nama_ibu' => $faker->name,
                'tanggal_lahir_ibu' => Carbon::now()->subYears(rand(20, 60)),
                'umur_ibu' => $faker->numberBetween(20, 60),
                'pekerjaan_ibu' => $faker->jobTitle,
                'alamat_ibu' => $faker->address,
                'nik_pelapor' => $faker->unique()->numerify('##########'),
                'nama_pelapor' => $faker->name,
                'umur_pelapor' => $faker->numberBetween(18, 70),
                'jenis_kelamin_pelapor' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'pekerjaan_pelapor' => $faker->jobTitle,
                'alamat_pelapor' => $faker->address,
                'nik_saksi1' => $faker->unique()->numerify('##########'),
                'nama_saksi1' => $faker->name,
                'umur_saksi1' => $faker->numberBetween(18, 70),
                'pekerjaan_saksi1' => $faker->jobTitle,
                'alamat_saksi1' => $faker->address,
                'nik_saksi2' => $faker->unique()->numerify('##########'),
                'nama_saksi2' => $faker->name,
                'umur_saksi2' => $faker->numberBetween(18, 70),
                'pekerjaan_saksi2' => $faker->jobTitle,
                'alamat_saksi2' => $faker->address,
                'kewarganegaraan_ayah' => $faker->randomElement(['WNI', 'WNA']),
                'kewarganegaraan_ibu' => $faker->randomElement(['WNI', 'WNA']),
                'kebangsaan_ayah' => 'Indonesia',
                'kebangsaan_ibu' => 'Indonesia',
                'tgl_kawin' => Carbon::now()->subYears(rand(1, 30)),
                'kelahiran_ke' => $faker->numberBetween(1, 5),
                'desa_kelurahan_ibu' => $faker->streetName,
                'kabupaten_kota_ibu' => $faker->city,
                'kecamatan_ibu' => $faker->citySuffix,
                'provinsi_ibu' => $faker->state,
                'desa_kelurahan_ayah' => $faker->streetName,
                'kabupaten_kota_ayah' => $faker->city,
                'kecamatan_ayah' => $faker->citySuffix,
                'provinsi_ayah' => $faker->state,
                'desa_kelurahan_pelapor' => $faker->streetName,
                'kabupaten_kota_pelapor' => $faker->city,
                'kecamatan_pelapor' => $faker->citySuffix,
                'provinsi_pelapor' => $faker->state,
                'desa_kelurahan_saksi1' => $faker->streetName,
                'kabupaten_kota_saksi1' => $faker->city,
                'kecamatan_saksi1' => $faker->citySuffix,
                'provinsi_saksi1' => $faker->state,
                'desa_kelurahan_saksi2' => $faker->streetName,
                'kabupaten_kota_saksi2' => $faker->city,
                'kecamatan_saksi2' => $faker->citySuffix,
                'provinsi_saksi2' => $faker->state,

                'jabatan' => $faker->randomElement(['kepala_desa', 'sekdes', 'kaur_tu']),
                'kode_wilayah' => '3311020002',
                'nomor_surat' => '474.1/' . str_pad($i + 1, 3, '0', STR_PAD_LEFT) . '/' . date('m') . '/' . date('Y'),
            ]);
        }
    }
}

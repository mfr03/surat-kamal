<?php

namespace Database\Seeders;

use App\Models\surat_keterangan_kematian;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class SuratKematianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 10; $i++) { // Seed 10 records, adjust as needed
            surat_keterangan_kematian::create([
                'nama_kepala_keluarga' => $faker->name,
                'nomor_kepala_keluarga' => $faker->unique()->numerify('##########'),
                'NIK' => $faker->unique()->numerify('################'),
                'nama_jenazah' => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'tanggal_lahir_jenazah' => Carbon::parse($faker->date),
                'umur_jenazah' => Carbon::now()->year - Carbon::parse($faker->date)->year,
                'tempat_kelahiran' => $faker->city,
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu']),
                'pekerjaan' => $faker->jobTitle,
                'alamat_jenazah' => $faker->address,
                'desa_kelurahan_jenazah' => $faker->streetName,
                'kecamatan_jenazah' => $faker->citySuffix,
                'kabupaten_kota_jenazah' => $faker->city,
                'provinsi_jenazah' => $faker->state,
                'anak_ke' => $faker->numberBetween(1, 10),
                'tanggal_kematian_jenazah' => Carbon::now()->subDays(rand(1, 365)),
                'pukul' => Carbon::now()->format('H:i'),
                'sebab_kematian' => $faker->randomElement(['Sakit biasa / tua', 'Wabah Penyakit', 'Kecelakaan', 'Kriminalitas', 'Bunuh Diri', 'Lainnya']),
                'tempat_kematian' => $faker->city,
                'yang_menerangkan' => $faker->randomElement(['Dokter', 'Tenaga Kesehatan', 'Kepolisian', 'Lainnya']),
                'nik_ayah' => $faker->unique()->numerify('################'),
                'nama_ayah' => $faker->name,
                'tanggal_lahir_ayah' => Carbon::parse($faker->date),
                'umur_ayah' => Carbon::now()->year - Carbon::parse($faker->date)->year,
                'pekerjaan_ayah' => $faker->jobTitle,
                'alamat_ayah' => $faker->address,
                'desa_kelurahan_ayah' => $faker->streetName,
                'kabupaten_kota_ayah' => $faker->city,
                'kecamatan_ayah' => $faker->citySuffix,
                'provinsi_ayah' => $faker->state,
                'nik_ibu' => $faker->unique()->numerify('################'),
                'nama_ibu' => $faker->name,
                'tanggal_lahir_ibu' => Carbon::parse($faker->date),
                'umur_ibu' => Carbon::now()->year - Carbon::parse($faker->date)->year,
                'pekerjaan_ibu' => $faker->jobTitle,
                'alamat_ibu' => $faker->address,
                'desa_kelurahan_ibu' => $faker->streetName,
                'kabupaten_kota_ibu' => $faker->city,
                'kecamatan_ibu' => $faker->citySuffix,
                'provinsi_ibu' => $faker->state,
                'nik_pelapor' => $faker->unique()->numerify('################'),
                'nama_pelapor' => $faker->name,
                'umur_pelapor' => $faker->numberBetween(18, 70),
                'jenis_kelamin_pelapor' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'pekerjaan_pelapor' => $faker->jobTitle,
                'alamat_pelapor' => $faker->address,
                'desa_kelurahan_pelapor' => $faker->streetName,
                'kabupaten_kota_pelapor' => $faker->city,
                'kecamatan_pelapor' => $faker->citySuffix,
                'provinsi_pelapor' => $faker->state,
                'nik_saksi1' => $faker->unique()->numerify('################'),
                'nama_saksi1' => $faker->name,
                'umur_saksi1' => $faker->numberBetween(18, 70),
                'pekerjaan_saksi1' => $faker->jobTitle,
                'alamat_saksi1' => $faker->address,
                'desa_kelurahan_saksi1' => $faker->streetName,
                'kabupaten_kota_saksi1' => $faker->city,
                'kecamatan_saksi1' => $faker->citySuffix,
                'provinsi_saksi1' => $faker->state,
                'nik_saksi2' => $faker->unique()->numerify('################'),
                'nama_saksi2' => $faker->name,
                'umur_saksi2' => $faker->numberBetween(18, 70),
                'pekerjaan_saksi2' => $faker->jobTitle,
                'alamat_saksi2' => $faker->address,
                'desa_kelurahan_saksi2' => $faker->streetName,
                'kabupaten_kota_saksi2' => $faker->city,
                'kecamatan_saksi2' => $faker->citySuffix,
                'provinsi_saksi2' => $faker->state,
                'nomor_surat' => '474.1/' . str_pad($i + 1, 3, '0', STR_PAD_LEFT) . '/' . date('m') . '/' . date('Y'),
                'jabatan' => $faker->randomElement(['kepala_desa', 'sekdes', 'kaur_tu']),
            ]);
        }
    }
}

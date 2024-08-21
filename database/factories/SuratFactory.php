<?php

namespace Database\Factories;

use App\Models\Surat;
use App\Models\Jenis;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuratFactory extends Factory
{
    protected $model = Surat::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
        'name' => $this->faker->name,
        'date_of_birth' => $this->faker->date(),
        'place_of_birth' => $this->faker->city,
        'nationality' => 'Indonesia',
        'religion' => $this->faker->randomElement(['Islam', 'Kristen', 'Hindu', 'Buddha']),
        'job' => $this->faker->jobTitle,
        'address' => $this->faker->address,
        'id_number' => $this->faker->numerify('############'),
        'letter_number' => $this->faker->unique()->numerify('430-######'),
        'purpose' => $this->faker->sentence,
        'valid_from' => $this->faker->date(),
        'valid_until' => $this->faker->date(),
        'remarks' => $this->faker->paragraph,
        'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
        'kartu_keluarga' => $this->faker->numerify('########'),
        'nama_ibu_kandung' => $this->faker->name('female'),
        'nomor_hp' => $this->faker->phoneNumber,
        'keterangan_usaha' => $this->faker->sentence,
        'tanda_tangan' => $this->faker->name,
        'domisili' => $this->faker->city,
        'selama' => $this->faker->numberBetween(1, 10) . ' tahun',
        'kode_surat' => $this->faker->randomElement(['430', '300']), // Corrected 'kode_surat' field
        'hashed_id' => $this->faker->unique()->sha256,
        'jenis_id' => Jenis::inRandomOrder()->first()->id,
        'jabatan' => $this->faker->randomElement(['kepala_desa', 'sekdes']), // Added the 'jabatan' field here
        'tujuan_surat' => $this->faker->sentence, // Added the 'tujuan_surat' field here
        'created_at' => now(),
        'updated_at' => now(),
    ];

}

}

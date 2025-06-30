<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_keterangan_kelahirans', function (Blueprint $table) {
                $table->id();
                $table->string('nama_kepala_keluarga')->nullable();
                $table->string('nomor_kepala_keluarga')->nullable();
                
                // Baby/Anak details
                $table->string('nama_bayi')->nullable();
                $table->string('jenis_kelamin_bayi')->nullable();
                $table->string('tempat_dilahirkan')->nullable();
                $table->string('tempat_kelahiran')->nullable();
                $table->date('tanggal_lahir_bayi')->nullable();
                $table->time('pukul_lahir')->nullable();
                $table->string('jenis_kelahiran')->nullable();
                $table->string('kelahiran_ke')->nullable();
                $table->string('penolong_kelahiran')->nullable();
                $table->decimal('berat_bayi', 5, 2)->nullable();
                $table->decimal('panjang_bayi', 5, 2)->nullable();

                // Ayah details
                $table->string('nik_ayah')->nullable();
                $table->string('nama_ayah')->nullable();
                $table->date('tanggal_lahir_ayah')->nullable();
                $table->integer('umur_ayah')->nullable();
                $table->string('pekerjaan_ayah')->nullable();
                $table->string('alamat_ayah')->nullable();
                $table->string('kewarganegaraan_ayah')->nullable();
                $table->string('kebangsaan_ayah')->nullable();

                // Ibu details
                $table->string('nik_ibu')->nullable();
                $table->string('nama_ibu')->nullable();
                $table->date('tanggal_lahir_ibu')->nullable();
                $table->integer('umur_ibu')->nullable();
                $table->string('pekerjaan_ibu')->nullable();
                $table->string('alamat_ibu')->nullable();
                 $table->string('kewarganegaraan_ibu')->nullable();
                $table->string('kebangsaan_ibu')->nullable();
                $table->string('tgl_kawin')->nullable();


                // Pelapor details
                $table->string('nik_pelapor')->nullable();
                $table->string('nama_pelapor')->nullable();
                $table->integer('umur_pelapor')->nullable();
                $table->string('jenis_kelamin_pelapor')->nullable();
                $table->string('pekerjaan_pelapor')->nullable();
                $table->string('alamat_pelapor')->nullable();

                // Saksi I details
                $table->string('nik_saksi1')->nullable();
                $table->string('nama_saksi1')->nullable();
                $table->integer('umur_saksi1')->nullable();
                $table->string('pekerjaan_saksi1')->nullable();
                $table->string('alamat_saksi1')->nullable();

                // Saksi II details
                $table->string('nik_saksi2')->nullable();
                $table->string('nama_saksi2')->nullable();
                $table->integer('umur_saksi2')->nullable();
                $table->string('pekerjaan_saksi2')->nullable();
                $table->string('alamat_saksi2')->nullable();
                
                // Adding columns for IBU
                $table->string('desa_kelurahan_ibu')->nullable();
                $table->string('kabupaten_kota_ibu')->nullable();
                $table->string('kecamatan_ibu')->nullable();
                $table->string('provinsi_ibu')->nullable();

                // Adding columns for AYAH
                $table->string('desa_kelurahan_ayah')->nullable();
                $table->string('kabupaten_kota_ayah')->nullable();
                $table->string('kecamatan_ayah')->nullable();
                $table->string('provinsi_ayah')->nullable();

                // Adding columns for PELAPOR
                $table->string('desa_kelurahan_pelapor')->nullable();
                $table->string('kabupaten_kota_pelapor')->nullable();
                $table->string('kecamatan_pelapor')->nullable();
                $table->string('provinsi_pelapor')->nullable();

                // Adding columns for SAKSI I
                $table->string('desa_kelurahan_saksi1')->nullable();
                $table->string('kabupaten_kota_saksi1')->nullable();
                $table->string('kecamatan_saksi1')->nullable();
                $table->string('provinsi_saksi1')->nullable();

                // Adding columns for SAKSI II
                $table->string('desa_kelurahan_saksi2')->nullable();
                $table->string('kabupaten_kota_saksi2')->nullable();
                $table->string('kecamatan_saksi2')->nullable();
                $table->string('provinsi_saksi2')->nullable();
            
                // Other details
                $table->string('kode_wilayah')->nullable();
                $table->string('jabatan')->nullable();
                $table->string('nomor_surat')->nullable();

                // Timestamps
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keterangan_kelahirans');
    }
};

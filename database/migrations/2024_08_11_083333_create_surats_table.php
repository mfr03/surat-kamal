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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('job')->nullable();
            $table->string('address')->nullable();
            $table->string('id_number')->nullable();
            $table->string('letter_number')->unique();
            $table->string('nomor_surat')->nullable();
            $table->string('purpose')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->string('remarks')->nullable();
            $table->string('kartu_keluarga')->nullable(); 
            $table->string('nama_ibu_kandung')->nullable(); 
            $table->string('nomor_hp')->nullable(); 
            $table->string('keterangan_usaha')->nullable(); 
            $table->string('tanda_tangan')->nullable(); 
            $table->string('domisili')->nullable(); 
            $table->string('selama')->nullable(); 
            $table->string('tujuan_surat')->nullable(); 
            $table->string('kode_surat')->nullable();
            $table->string('hashed_id')->unique()->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('jabatan')->nullable();
            $table->foreignId('jenis_id')->constrained('jenis')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};

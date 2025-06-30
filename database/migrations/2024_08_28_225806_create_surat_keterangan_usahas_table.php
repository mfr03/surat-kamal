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
        Schema::create('surat_keterangan_usahas', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('id_number');
            $table->string('jenis_kelamin')->nullable(); 
            $table->string('religion')->nullable(); 
            $table->string('nama_ibu_kandung')->nullable(); 
            $table->string('nomor_hp')->nullable();
            $table->text('domisili')->nullable(); 
            $table->text('selama')->nullable(); 
            $table->text('tujuan_surat')->nullable(); 
            $table->string('letter_number')->nullable(); 
            $table->string('kode_surat')->nullable(); 
            $table->string('nomor_surat')->nullable();
            $table->string('jabatan')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keterangan_usahas');
    }
};

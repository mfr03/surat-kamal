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
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('nationality');
            $table->string('religion');
            $table->string('job');
            $table->string('address');
            $table->string('id_number');
            $table->string('letter_number')->unique();
            $table->string('purpose');
            $table->date('valid_from');
            $table->date('valid_until');
            $table->string('remarks')->nullable();
            $table->string('kartu_keluarga')->nullable(); // New field
            $table->string('nama_ibu_kandung')->nullable(); // New field
            $table->string('nomor_hp')->nullable(); // New field
            $table->string('keterangan_usaha')->nullable(); // New field
            $table->string('tanda_tangan')->nullable(); // New field
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

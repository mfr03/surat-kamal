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
        Schema::create('surat_pengantars', function (Blueprint $table) {
            $table->id();
            $table->string('kode_surat')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->string('letter_number')->nullable();
            $table->string('name');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->string('nationality');
            $table->string('job');
            $table->string('address');
            $table->string('id_number');
            $table->string('kartu_keluarga');
            $table->string('purpose');
            $table->string('Tujuan');
            $table->date('valid_from');
            $table->text('template_remarks')->nullable();
            $table->text('remarks')->nullable();
            $table->string('jabatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pengantars');
    }
};

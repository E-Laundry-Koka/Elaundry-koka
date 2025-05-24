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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemesan');
            $table->string('no_hp');
            $table->string('alamat');
            $table->foreignId('id_layanan')->constrained('layanan')->onDelete('cascade');
            $table->date('tanggal_pemesanan');
            $table->decimal('berat');
            $table->integer('diskon');
            $table->string('catatan');
            $table->string('status')->default('Proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};

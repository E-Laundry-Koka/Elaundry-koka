<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_order', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemesan');
            $table->string('no_hp', 20);
            $table->text('alamat');
            $table->foreignId('id_layanan')->constrained('layanan')->onDelete('cascade');
            $table->date('tanggal_pemesanan');
            $table->decimal('berat'); // hingga 999999.99 kg
            $table->decimal('diskon')->default(0); // maksimal 999.99%
            $table->text('catatan')->nullable();
            $table->string('status')->default('Proses');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_order');
    }
};

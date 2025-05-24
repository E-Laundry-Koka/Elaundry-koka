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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_pesanan")->constrained("pesanan")->onDelete('cascade');
            $table->enum("metode_pembayaran", ['Tunai', 'Transfer']);   
            $table->integer("jumlah_pembayaran");
            $table->date("tanggal_pembayaran");
            $table->enum("status_pembayaran", ['Belum Bayar', 'Lunas'])->default('Belum Bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};

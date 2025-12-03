<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->string('id_transaksi')->primary();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')
                ->references('id_barang')
                ->on('barangs')
                ->onDelete('set null');
            $table->string('metode_transaksi', 50);
            $table->decimal('total_biaya', 20, 2);
            $table->integer('qty')->default(1);
            $table->decimal('jumlah_bayar', 20, 2)->nullable();
            $table->decimal('jumlah_kembalian', 20, 2)->nullable();
            $table->datetime('tanggal_transaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};

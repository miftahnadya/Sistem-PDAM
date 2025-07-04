<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->string('id_tagihan', 20)->primary();
            $table->string('id_pel', 10)->index(); // Tambahkan index terlebih dahulu
            $table->string('periode', 6); // YYYYMM
            $table->integer('bulan');
            $table->integer('tahun');
            $table->decimal('meter_awal', 10, 2);
            $table->decimal('meter_akhir', 10, 2);
            $table->decimal('pemakaian', 10, 2);
            $table->decimal('tarif_per_m3', 10, 2);
            $table->decimal('biaya_admin', 10, 2)->default(0);
            $table->decimal('total_tagihan', 12, 2);
            $table->enum('status_bayar', ['BELUM_LUNAS', 'LUNAS'])->default('BELUM_LUNAS');
            $table->date('tgl_tagihan');
            $table->date('tgl_batas_bayar');
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            // Index untuk performa
            $table->index(['id_pel', 'periode']);
            $table->index('status_bayar');
        });
        
        // Tambahkan foreign key constraint setelah tabel dibuat
        Schema::table('tagihan', function (Blueprint $table) {
            // Pastikan tabel pelanggan sudah ada dan memiliki struktur yang benar
            if (Schema::hasTable('pelanggan') && Schema::hasColumn('pelanggan', 'id_pel')) {
                $table->foreign('id_pel')
                      ->references('id_pel')
                      ->on('pelanggan')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihan');
    }
};
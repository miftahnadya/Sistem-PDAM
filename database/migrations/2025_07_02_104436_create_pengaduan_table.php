<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->string('nama_pelanggan');
            $table->string('id_pelanggan');
            $table->text('alamat');
            $table->string('no_hp');
            $table->enum('kategori', ['kualitas_air', 'ketersediaan_air', 'tagihan', 'pelayanan', 'perbaikan', 'lainnya']);
            $table->string('judul');
            $table->text('detail_pengaduan');
            $table->json('files')->nullable();
            $table->enum('status', ['pending', 'diproses', 'selesai', 'ditutup'])->default('pending');
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->text('response_admin')->nullable();
            $table->timestamp('tanggal_response')->nullable();
            $table->string('admin_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaduan');
    }
};
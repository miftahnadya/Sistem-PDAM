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
            $table->json('files')->nullable(); // Pastikan menggunakan JSON
            $table->enum('status', ['pending', 'diproses', 'selesai', 'ditutup'])->default('pending');
            $table->timestamp('tanggal_pengaduan')->useCurrent();
            $table->text('response_admin')->nullable();
            $table->timestamp('tanggal_response')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaduan');
    }
};
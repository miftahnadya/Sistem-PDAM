<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('id_pel')->nullable();
            $table->string('id_meter')->nullable();
            $table->string('nama_pelanggan');
            $table->string('password');
            $table->string('role')->default('user');
            $table->string('goltar')->nullable();
            $table->text('alamat')->nullable();
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('rute')->nullable();
            $table->string('merek_meter')->nullable();
            $table->string('status_pelanggan')->nullable();
            $table->string('status_meter')->nullable();
            $table->string('angka_meter_kini')->nullable();
            $table->string('periode_terakhir')->nullable();
            $table->integer('jumlah_bulan_rekening')->nullable();
            $table->integer('total_pemakaian_m3')->nullable();
            $table->decimal('harga_air', 12, 2)->nullable();
            $table->decimal('biaya_admin', 12, 2)->nullable();
            $table->decimal('denda', 12, 2)->nullable();
            $table->decimal('total_tagihan', 12, 2)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
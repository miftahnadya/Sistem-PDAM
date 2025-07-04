<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->string('id_pel', 10)->primary();
            $table->string('nama_pelanggan', 100);
            $table->text('alamat');
            $table->string('no_telepon', 20)->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->enum('status_pelanggan', ['AKTIF', 'TIDAK_AKTIF'])->default('AKTIF');
            $table->string('role', 20)->default('pelanggan');
            $table->date('tgl_daftar')->nullable();
            $table->unsignedBigInteger('tarif_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index('nama_pelanggan');
            $table->index('status_pelanggan');
            $table->index('tarif_id');
            $table->index('created_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelanggan');
    }
};
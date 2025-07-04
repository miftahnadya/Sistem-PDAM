<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tarif', function (Blueprint $table) {
            $table->id('id_tarif');
            $table->string('kategori', 50);
            $table->decimal('tarif_per_m3', 10, 2);
            $table->decimal('biaya_admin', 10, 2)->default(0);
            $table->decimal('biaya_beban', 10, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->enum('status', ['AKTIF', 'TIDAK_AKTIF'])->default('AKTIF');
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index('kategori');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tarif');
    }
};
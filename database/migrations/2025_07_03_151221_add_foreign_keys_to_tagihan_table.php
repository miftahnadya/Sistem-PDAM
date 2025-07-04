<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->foreign('tarif_id')
                  ->references('id_tarif')
                  ->on('tarif')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
                  
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
                  
            $table->foreign('updated_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropForeign(['tarif_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
    }
};
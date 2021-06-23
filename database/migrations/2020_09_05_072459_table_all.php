<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableAll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('satuan');
            $table->double('limit');
            $table->string('keterangan');
            $table->timestamps();
            $table->tinyInteger('flag');
        });

        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang', 10);
            $table->foreignId('id_user', 10);
            $table->foreignId('id_supplier', 10);
            $table->double('stok');
            $table->double('stok_akhir');
            $table->dateTime('expired');
            $table->tinyInteger('flag');
            $table->timestamps();
           
        });

        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang', 10);
            $table->foreignId('id_user', 10);
            $table->double('stok');
            $table->tinyInteger('flag');
            $table->timestamps();
            
        });

        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->string('no', 20);
            $table->boolean('status');
            $table->tinyInteger('flag');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');

        Schema::dropIfExists('pembelian');

        Schema::dropIfExists('penjualan');

        Schema::dropIfExists('supplier');
    }
}

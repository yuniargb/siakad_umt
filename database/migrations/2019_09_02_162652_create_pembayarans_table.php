<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bukti');
            $table->string('atm');
            $table->string('no_rek');
            $table->bigInteger('siswa_id');
            $table->bigInteger('jumlah');
            $table->date('tgl_transfer');
            $table->boolean('status')->default(null);
            $table->string('pesan',100)->nullable()->default(null);
            $table->unsignedBigInteger('tagihan_id');
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
        Schema::dropIfExists('pembayarans');
    }
}

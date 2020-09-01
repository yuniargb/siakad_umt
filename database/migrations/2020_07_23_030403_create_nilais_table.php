<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('nilais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('nilai')->length(10)->unsigned();
            $table->string('semester', 50);
            $table->string('tahun_ajaran', 50);
            $table->string('tipe', 50);
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('jadwal_id');
            // $table->unsignedBigInteger('mata_pelajaran_id');
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
        Schema::dropIfExists('nilais');
    }
}

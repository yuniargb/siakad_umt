<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSilabusDanRppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('silabus_dan_rpps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('kompetensi_dasar');
            $table->longText('indikator_pencapaian_kompetensi');
            $table->longText('materi_pembelajaran');
            $table->longText('kegiatan_pembelajaran');
            $table->longText('ppr');
            $table->longText('media');
            $table->string('alokasi_waktu', 50);
            $table->string('semester', 50);
            $table->string('kelas', 50);
            $table->string('tahun_ajaran', 50);
            $table->unsignedBigInteger('mata_pelajaran_id');
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
        Schema::dropIfExists('silabus_dan_rpps');
    }
}

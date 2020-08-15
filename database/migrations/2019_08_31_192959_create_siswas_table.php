<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nis', 20);
            $table->string('nama', 50);
            $table->string('nama_panggilan', 50); //
            $table->string('nama_ayah', 50); //
            $table->string('agama_ayah', 50); //
            $table->string('nama_ibu', 50); //
            $table->string('agama_ibu', 50); //
            $table->string('pekerjaan_ayah', 50); //
            $table->string('pekerjaan_ibu', 50); //
            $table->string('penghasilan_ayah', 50); //
            $table->string('penghasilan_ibu', 50); //
            $table->string('no_telp', 50); //
            $table->string('no_telp_ayah', 50); //
            $table->string('no_telp_ibu', 50); //
            $table->string('anak_ke', 50); // 1
            $table->string('tempat_lahir', 50); 
            $table->date('tgl_lahir'); 
            $table->string('jk', 1);
            $table->string('agama', 20);
            $table->string('alamat'); 
            $table->string('alamat_wali'); //
            $table->unsignedBigInteger('angkatan_id');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('siswas');
    }
}

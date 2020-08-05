<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGurusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nip', 20);
            $table->string('nama', 50);
            $table->string('tempat_lahir', 50);
            $table->date('tgl_lahir');
            $table->string('jk', 1);
            $table->string('agama', 20);
            $table->string('alamat');
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
        Schema::dropIfExists('gurus');
    }
}

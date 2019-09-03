<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class);
    }
    public function pembayaran()
    {
        return $this->belongsTo('App\Pembayaran');
    }
}

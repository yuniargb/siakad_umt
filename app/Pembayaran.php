<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    public function siswa()
    {
        return $this->hasOne('App\Siswa','foreign_key','siswa_id');
    }
}

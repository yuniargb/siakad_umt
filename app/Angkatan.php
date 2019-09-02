<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}

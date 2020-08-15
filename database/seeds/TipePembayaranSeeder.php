<?php

use Illuminate\Database\Seeder;

class TipePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\TipePembayaran::create([
            'id'  => '1',
            'namatipe' => 'SPP',
            'biaya' => 0,
        ]);
    }
}

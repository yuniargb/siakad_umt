<?php

namespace App\Http\Controllers;

use App\Nilai;
use App\Siswa;
use App\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mail;
class NilaiController extends Controller
{
    public function harian()
    {
        // dd(auth()->user());
        if(auth()->user()->role == 7 || auth()->user()->role == 2){
            $mapel = DB::table('jadwals')
                ->select('jadwals.id','mata_pelajarans.namamapel','gurus.nama','kelas.namaKelas')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->where('users.id',auth()->user()->id)
                ->get();

            $siswa = DB::table('jadwals')
                ->select('siswas.id','siswas.nis','siswas.nama')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('siswas', 'siswas.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->where('users.id',auth()->user()->id)
                ->groupBy('siswas.id','siswas.nis','siswas.nama')
                ->get();

            
            if(auth()->user()->role == 2){
                $nilai = DB::table('nilais')
                ->select('*', 'nilais.id as id','nilais.semester','nilais.tahun_ajaran')
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->join('users', 'users.username', '=', 'siswas.nis')
                ->where('nilais.tipe', 'harian')
                ->where('users.id',auth()->user()->id)
                ->get();
            }else{
                $nilai = DB::table('nilais')
                ->select('*', 'nilais.id as id','nilais.semester','nilais.tahun_ajaran')
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->where('nilais.tipe', 'harian')
                ->where('users.id',auth()->user()->id)
                ->get();
            }
         
        }else{
            $mapel = DB::table('jadwals')
                ->select('jadwals.id','mata_pelajarans.namamapel','gurus.nama','kelas.namaKelas')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->get();

            $siswa = Siswa::all();

            
            $nilai = DB::table('nilais')
                ->select('*', 'nilais.id as id','nilais.semester','nilais.tahun_ajaran')
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->where('nilais.tipe', 'harian')
                ->get();
        }
      
        return view('nilai.nilaiharian', compact('nilai', 'siswa','mapel'));
    }
    public function ujian()
    {
        if(auth()->user()->role == 7 || auth()->user()->role == 2){
            $mapel = DB::table('jadwals')
                ->select('jadwals.id','mata_pelajarans.namamapel','gurus.nama','kelas.namaKelas')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->where('users.id',auth()->user()->id)
                ->get();

            $siswa = DB::table('jadwals')
                ->select('siswas.id','siswas.nis','siswas.nama')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('siswas', 'siswas.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->where('users.id',auth()->user()->id)
                ->groupBy('siswas.id','siswas.nis','siswas.nama')
                ->get();

            
            if(auth()->user()->role == 2){
                $nilai = DB::table('nilais')
                ->select('*', 'nilais.id as id','nilais.semester','nilais.tahun_ajaran')
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->join('users', 'users.username', '=', 'siswas.nis')
                ->where('nilais.tipe', 'ujian')
                ->where('users.id',auth()->user()->id)
                ->get();
            }else{
                $nilai = DB::table('nilais')
                ->select('*', 'nilais.id as id','nilais.semester','nilais.tahun_ajaran')
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->where('nilais.tipe', 'ujian')
                ->where('users.id',auth()->user()->id)
                ->get();
            }
        }else{
            $mapel = DB::table('jadwals')
                ->select('jadwals.id','mata_pelajarans.namamapel','gurus.nama','kelas.namaKelas')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->get();
            $siswa = Siswa::all();
            $nilai = DB::table('nilais')
                ->select('*', 'nilais.id as id','nilais.semester','nilais.tahun_ajaran')
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->where('nilais.tipe', 'ujian')
                ->get();
        }
        
        return view('nilai.nilaiujian', compact('nilai', 'siswa','mapel'));
    }
    public function uts()
    {
        if(auth()->user()->role == 7 || auth()->user()->role == 2){
            $mapel = DB::table('jadwals')
                ->select('jadwals.id','mata_pelajarans.namamapel','gurus.nama','kelas.namaKelas')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->where('users.id',auth()->user()->id)
                ->get();

            $siswa = DB::table('jadwals')
                ->select('siswas.id','siswas.nis','siswas.nama')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('siswas', 'siswas.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->where('users.id',auth()->user()->id)
                ->groupBy('siswas.id','siswas.nis','siswas.nama')
                ->get();

            
            if(auth()->user()->role == 2){
                $nilai = DB::table('nilais')
                ->select('*', 'nilais.id as id','nilais.semester','nilais.tahun_ajaran')
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->join('users', 'users.username', '=', 'siswas.nis')
                ->where('nilais.tipe', 'uts')
                ->where('users.id',auth()->user()->id)
                ->get();
            }else{
                $nilai = DB::table('nilais')
                ->select('*', 'nilais.id as id','nilais.semester','nilais.tahun_ajaran')
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->where('nilais.tipe', 'uts')
                ->where('users.id',auth()->user()->id)
                ->get();
            }
        }else{
            $mapel = DB::table('jadwals')
                ->select('jadwals.id','mata_pelajarans.namamapel','gurus.nama','kelas.namaKelas')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->get();
            $siswa = Siswa::all();
            $nilai = DB::table('nilais')
                ->select('*', 'nilais.id as id','nilais.semester','nilais.tahun_ajaran')
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->where('nilais.tipe', 'uts')
                ->get();
        }
        
        return view('nilai.nilaiuts', compact('nilai', 'siswa','mapel'));
    }
    public function uas()
    {
        if(auth()->user()->role == 7 || auth()->user()->role == 2){
            $mapel = DB::table('jadwals')
                ->select('jadwals.id','mata_pelajarans.namamapel','gurus.nama','kelas.namaKelas')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->where('users.id',auth()->user()->id)
                ->get();

            $siswa = DB::table('jadwals')
                ->select('siswas.id','siswas.nis','siswas.nama')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('siswas', 'siswas.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->where('users.id',auth()->user()->id)
                ->groupBy('siswas.id','siswas.nis','siswas.nama')
                ->get();

            
            if(auth()->user()->role == 2){
                $nilai = DB::table('nilais')
                ->select('*', 'nilais.id as id','nilais.semester','nilais.tahun_ajaran')
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->join('users', 'users.username', '=', 'siswas.nis')
                ->where('nilais.tipe', 'uas')
                ->where('users.id',auth()->user()->id)
                ->get();
            }else{
                $nilai = DB::table('nilais')
                ->select('*', 'nilais.id as id','nilais.semester','nilais.tahun_ajaran')
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->where('nilais.tipe', 'uas')
                ->where('users.id',auth()->user()->id)
                ->get();
            }
        }else{
            $mapel = DB::table('jadwals')
                ->select('jadwals.id','mata_pelajarans.namamapel','gurus.nama','kelas.namaKelas')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->get();
            $siswa = Siswa::all();
            $nilai = DB::table('nilais')
                ->select('*', 'nilais.id as id','nilais.semester','nilais.tahun_ajaran')
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->where('nilais.tipe', 'uas')
                ->get();
        }
        
        return view('nilai.nilaiuas', compact('nilai', 'siswa','mapel'));
    }
    public function raport()
    {
       if(auth()->user()->role == 7 || auth()->user()->role == 2){
            $mapel = DB::table('jadwals')
                ->select('jadwals.id','mata_pelajarans.namamapel','gurus.nama','kelas.namaKelas')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->where('users.id',auth()->user()->id)
                ->get();
            // dd(auth()->user());
            // dd($mapel);
            $siswa = DB::table('jadwals')
                ->select('siswas.id','siswas.nis','siswas.nama')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('siswas', 'siswas.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->where('users.id',auth()->user()->id)
                ->groupBy('siswas.id','siswas.nis','siswas.nama')
                ->get();
            if(auth()->user()->role == 2){
                $nilai = DB::table('nilais')
                ->select('siswas.nama','mata_pelajarans.namamapel','nilais.semester','nilais.tahun_ajaran',
                DB::raw('
                        ROUND(
                            NVL(
                                (
                                    SELECT (nilai) 
                                    FROM nilais n 
                                    WHERE n.siswa_id=siswas.id 
                                    AND n.jadwal_id=jadwals.id 
                                    AND n.semester=nilais.semester 
                                    AND n.tahun_ajaran=nilais.tahun_ajaran 
                                    AND n.tipe = "harian"
                                ),
                                0
                            ) * (10/100) +
                            NVL(
                                (
                                    SELECT (nilai) 
                                    FROM nilais n 
                                    WHERE n.siswa_id=siswas.id 
                                    AND n.jadwal_id=jadwals.id 
                                    AND n.semester=nilais.semester 
                                    AND n.tahun_ajaran=nilais.tahun_ajaran 
                                    AND n.tipe = "uts"
                                ),
                                0
                            ) * (30/100) +
                            NVL(
                                (
                                    SELECT (nilai) 
                                    FROM nilais n 
                                    WHERE n.siswa_id=siswas.id 
                                    AND n.jadwal_id=jadwals.id 
                                    AND n.semester=nilais.semester 
                                    AND n.tahun_ajaran=nilais.tahun_ajaran 
                                    AND n.tipe = "uas"
                                ),
                                0
                            ) * (60/100)
							,2
                        ) AS nilai'))
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')								   
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->join('users', 'users.username', '=', 'siswas.nis')
                ->where('users.id',auth()->user()->id)
                ->whereIn('tipe',array('harian','uts','uas'))
                ->groupBy('siswas.id','siswas.nama','mata_pelajarans.namamapel','nilais.semester','nilais.tahun_ajaran','jadwals.id')
                ->get();
            }else{
                $waliKelas = DB::table('gurus')
                        ->select('kelas.*','gurus.id as idg')
                        ->join('kelas', 'gurus.id', '=', 'kelas.guru_id')
                        ->where('gurus.nip',auth()->user()->username)
                        ->first();
                        
                $nilai = DB::table('nilais')
                 ->select('siswas.nama','mata_pelajarans.namamapel','nilais.semester','nilais.tahun_ajaran',
                DB::raw('
                        ROUND(
                            NVL(
                                (
                                    SELECT (nilai) 
                                    FROM nilais n 
                                    WHERE n.siswa_id=siswas.id 
                                    AND n.jadwal_id=jadwals.id 
                                    AND n.semester=nilais.semester 
                                    AND n.tahun_ajaran=nilais.tahun_ajaran 
                                    AND n.tipe = "harian"
                                ),
                                0
                            ) * (10/100) +
                            NVL(
                                (
                                    SELECT (nilai) 
                                    FROM nilais n 
                                    WHERE n.siswa_id=siswas.id 
                                    AND n.jadwal_id=jadwals.id 
                                    AND n.semester=nilais.semester 
                                    AND n.tahun_ajaran=nilais.tahun_ajaran 
                                    AND n.tipe = "uts"
                                ),
                                0
                            ) * (30/100) +
                            NVL(
                                (
                                    SELECT (nilai) 
                                    FROM nilais n 
                                    WHERE n.siswa_id=siswas.id 
                                    AND n.jadwal_id=jadwals.id 
                                    AND n.semester=nilais.semester 
                                    AND n.tahun_ajaran=nilais.tahun_ajaran 
                                    AND n.tipe = "uas"
                                ),
                                0
                            ) * (60/100),
                            2
                        ) AS nilai'))
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->where('users.id',auth()->user()->id)
                ->where('siswas.kelas_id',$waliKelas->id)
                ->whereIn('tipe',array('harian','uts','uas'))
                ->groupBy('siswas.id','siswas.nama','mata_pelajarans.namamapel','nilais.semester','nilais.tahun_ajaran','jadwals.id')
                ->get();
            }
        }else{
            $mapel = DB::table('jadwals')
                ->select('jadwals.id','mata_pelajarans.namamapel','gurus.nama','kelas.namaKelas')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->get();
            $siswa = Siswa::all();
            $nilai = DB::table('nilais')
                ->select('siswas.nama','mata_pelajarans.namamapel','nilais.semester','nilais.tahun_ajaran',
                DB::raw('
                        ROUND(
                            NVL(
                                (
                                    SELECT (nilai) 
                                    FROM nilais n 
                                    WHERE n.siswa_id=siswas.id 
                                    AND n.jadwal_id=jadwals.id 
                                    AND n.semester=nilais.semester 
                                    AND n.tahun_ajaran=nilais.tahun_ajaran 
                                    AND n.tipe = "harian"
                                ),
                                0
                            ) * (10/100) +
                            NVL(
                                (
                                    SELECT (nilai) 
                                    FROM nilais n 
                                    WHERE n.siswa_id=siswas.id 
                                    AND n.jadwal_id=jadwals.id 
                                    AND n.semester=nilais.semester 
                                    AND n.tahun_ajaran=nilais.tahun_ajaran 
                                    AND n.tipe = "uts"
                                ),
                                0
                            ) * (30/100) +
                            NVL(
                                (
                                    SELECT (nilai) 
                                    FROM nilais n 
                                    WHERE n.siswa_id=siswas.id 
                                    AND n.jadwal_id=jadwals.id 
                                    AND n.semester=nilais.semester 
                                    AND n.tahun_ajaran=nilais.tahun_ajaran 
                                    AND n.tipe = "uas"
                                ),
                                0
                            ) * (60/100)
                            , 2
                        ) AS nilai'))
                ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
                ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
                ->join('users', 'users.username', '=', 'gurus.nip')
                ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
                ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
                ->whereIn('tipe',array('harian','uts','uas'))
                ->groupBy('siswas.id','siswas.nama','mata_pelajarans.namamapel','nilais.semester','nilais.tahun_ajaran','jadwals.id')
                ->get();
        } 

        return view('nilai.nilairaport', compact('nilai', 'siswa','mapel'));
    }

    public function store(Request $request)
    {
        $cek = Nilai::where('semester',$request->semester)
        ->where('tahun_ajaran',$request->tahun_ajaran)
        ->where('siswa_id',$request->siswa_id)
        ->where('tipe',$request->type)
        ->where('jadwal_id',$request->mata_pelajaran_id)
        ->first()
        ;
        // dd($cek);
        if($cek == null){
            $nilai = new Nilai;
            $nilai->nilai = $request->nilai;
            $nilai->semester = $request->semester;
            $nilai->tahun_ajaran = $request->tahun_ajaran;
            $nilai->siswa_id = $request->siswa_id;
            $nilai->tipe = $request->type;
            $nilai->jadwal_id = $request->mata_pelajaran_id;
            $nilai->save();
            Session::flash('success', 'Nilai berhasil ditambahkan');
        }else{
            $cek->nilai = $request->nilai;
            $cek->semester = $request->semester;
            $cek->tahun_ajaran = $request->tahun_ajaran;
            $cek->siswa_id = $request->siswa_id;
            $cek->tipe = $request->type;
            $cek->jadwal_id = $request->mata_pelajaran_id;
            $cek->update();
            Session::flash('success', 'Nilai sudah ada, nilai lama diperbaharui');
        }

        $siswa = DB::table('siswas')
            ->select('*')
            ->join('users', 'siswas.nis', '=', 'users.username')
            ->where('siswas.id',$request->siswa_id)
            ->first();

        $massg = 'Nilai anda telah ditambahkan';
        Mail::send('email.pembayaranNotif', ['nama' => $siswa->nama, 'pesan' => $massg], function ($message) use ($siswa)
        {
            $message->subject('Penilaian');
            $message->from('donotreply@ashiup.com', 'SMP MUHAMADIYAH 4 KOTA TANGERANG');
            $message->to($siswa->email);
        });
        
        return Redirect::back();
    }

  
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $decrypt = Crypt::decrypt($id);
        $nilai = Nilai::find($decrypt);
        return $nilai;
    }

    public function update(Request $request, $id)
    {
        $cek = Nilai::where('semester',$request->semester)
        ->where('tahun_ajaran',$request->tahun_ajaran)
        ->where('siswa_id',$request->siswa_id)
        ->where('tipe',$request->type)
        ->where('jadwal_id',$request->mata_pelajaran_id)
        ->first()
        ;
        // dd($cek);
        if($cek == null){
            $nilai = new Nilai;
            $nilai->nilai = $request->nilai;
            $nilai->semester = $request->semester;
            $nilai->tahun_ajaran = $request->tahun_ajaran;
            $nilai->siswa_id = $request->siswa_id;
            $nilai->tipe = $request->type;
            $nilai->jadwal_id = $request->mata_pelajaran_id;
            $nilai->save();
            Session::flash('success', 'Nilai gagal diubah, system menambahkan nilai otomatis');
            return Redirect::back();
        }else{
            $cek->nilai = $request->nilai;
            $cek->semester = $request->semester;
            $cek->tahun_ajaran = $request->tahun_ajaran;
            $cek->siswa_id = $request->siswa_id;
            $cek->tipe = $request->type;
            $cek->jadwal_id = $request->mata_pelajaran_id;
            $cek->update();
            Session::flash('success', 'Nilai berhasil diubah');
            return Redirect::back();
        }
        
    }

    public function destroy($id)
    {
        $decrypt = Crypt::decrypt($id);
        $nilai = Nilai::find($decrypt);
        $nilai->delete();

        Session::flash('success', 'Nilai berhasil dihapus');
        return url()->previous();
    }
}

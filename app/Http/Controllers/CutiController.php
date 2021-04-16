<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Pegawai;
use App\Models\Cuti;

class CutiController extends Controller
{
    public function index(Request $request) {
        // mengambil data cuti pegawai dengan eloquent ORM
        $cutipegawai    = Cuti::with('Pegawai')->orderBy('tanggal_cuti')->get();
        $laman      = 'pages/indexCuti';
        // mengubah ke array
        $data       = $cutipegawai->toArray();
        // mengubah ke objek
        $object     = json_decode(json_encode($data),FALSE);
        // passing data
        $collection = collect($object)->map(function ($values) {
            return [
                'nomor_induk'   => $values->nomor_induk,
                'nama'          => ucwords(collect($values->pegawai[0])->get('nama')),
                'param1'        => \Carbon\Carbon::createFromFormat('Y-m-d', $values->tanggal_cuti)->format('d-M-Y'),
                'param2'        => ucwords($values->keterangan),
            ];
        });
        //mengirim data pegawai ke view index
    	return view($laman,['cuti' => json_decode(json_encode($collection),FALSE)]);
    }

    public function total(Request $request) {
        // mengambil data cuti pegawai dengan eloquent ORM
        $cutipegawai    = Cuti::select(DB::raw('nomor_induk,count(nomor_induk) as total_cuti,sum(lama_cuti) as total_hari'))->withCount('Pegawai:nama')->groupby('nomor_induk')->get();
        $laman      = 'pages/indexCuti';
        // mengubah ke array
        $data       = $cutipegawai->toArray();
        // mengubah ke objek
        $object     = json_decode(json_encode($data),FALSE);
        // passing data
        $collection = collect($object)->map(function ($values) {
            return [
                'nomor_induk'   => $values->nomor_induk,
                'nama'          => ucwords($values->pegawai_count),
                'param1'        => $values->total_cuti,
                'param2'        => $values->total_hari,
            ];
        });
        //mengirim data pegawai ke view index
    	return view($laman,['cuti' => json_decode(json_encode($collection),FALSE)]);
    }
    
    public function sisa(Request $request) {
        // mengambil data cuti pegawai dengan eloquent ORM
        $cutipegawai    = Cuti::select(DB::raw('nomor_induk,sum(lama_cuti) as total_hari,(12-sum(lama_cuti)) as sisa_hari'))->withCount('Pegawai:nama')->groupby('nomor_induk')->get();
        $laman      = 'pages/indexCuti';
        // mengubah ke array
        $data       = $cutipegawai->toArray();
        // mengubah ke objek
        $object     = json_decode(json_encode($data),FALSE);
        // passing data
        $collection = collect($object)->map(function ($values) {
            return [
                'nomor_induk'   => $values->nomor_induk,
                'nama'          => ucwords($values->pegawai_count),
                'param1'        => $values->total_hari,
                'param2'        => $values->sisa_hari,
            ];
        });
        //mengirim data pegawai ke view index
        return view($laman,['cuti' => json_decode(json_encode($collection),FALSE)]);
    }    
}
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
        $cutipegawai    = Cuti::with('Pegawai')->orderBy('tanggal_gabung')->get();
        $laman      = 'pages/indexCuti';
        // mengubah ke array
        $data       = $cutipegawai->toArray();
        // mengubah ke objek
        $object     = json_decode(json_encode($data),FALSE);
        // passing data
        $collection = collect($object)->map(function ($values) {
            return [
                'nomor_induk'       => $values->nomor_induk,
                'nama'              => ucwords($values->nama),
                'keterangan'        => ucwords($values->keterangan),
                'tanggal_cuti'      => \Carbon\Carbon::createFromFormat('Y-m-d', $values->tanggal_cuti)->format('d-M-Y'),
            ];
        });
        //mengirim data pegawai ke view index
    	return view($laman,['pegawai' => json_decode(json_encode($collection),FALSE)]);
    }
}
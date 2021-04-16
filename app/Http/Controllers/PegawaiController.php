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

class PegawaiController extends Controller
{
    public function index(Request $request) {
        $currentURL = $request->segment(count(request()->segments()));
        // mengambil data pegawai dengan eloquent ORM
        if ($currentURL=='trash') {
            $pegawai    = Pegawai::with('Cuti')->onlyTrashed()->get();
            $laman      = 'pages/trashedPegawai';
        } else {
            $pegawai    = Pegawai::with('Cuti')->get();
            $laman      = 'pages/indexPegawai';
        }
        // mengubah ke array
        $data       = $pegawai->toArray();
        // mengubah ke objek
        $object     = json_decode(json_encode($data),FALSE);
        // passing data
        $collection = collect($object)->map(function ($values) {
            return [
                'nomor_induk'       => $values->nomor_induk,
                'nama'              => $values->nama,
                'alamat'            => $values->alamat,
                'tanggal_lahir'     => \Carbon\Carbon::createFromFormat('Y-m-d', $values->tanggal_lahir)->format('d-M-Y'),
                'tanggal_gabung'    => \Carbon\Carbon::createFromFormat('Y-m-d', $values->tanggal_gabung)->format('d-M-Y'),
            ];
        });
        if($pegawai->count() > 0) { 
        //mengirim data pegawai ke view index
    	    return view($laman,['pegawai' => json_decode(json_encode($collection),FALSE)]);
        } else {
            return view($laman,['pegawai' => array()]);
        }
    }

    public function create() {
        // mengambil data pegawai dengan kode paling besar
        $qrymax =   Pegawai::max('nomor_induk'); 
        // mengambil angka dari kode pegawai terbesar, menggunakan fungsi substr dan diubah ke integer dengan (int)
        $urutan =   (int) substr($qrymax, 4);
        $urutan++;
        // membentuk kode pegawai baru
        // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
        // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
        // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan 
        $huruf = "IP06";
        $kodepegawai = $huruf . sprintf("%03s", $urutan);
        return view('pages/formPegawai',['pegawai' => array('nomor_induk'=>$kodepegawai)]);
    }

    public function edit($id) {
        // mengambil data pegawai by id dengan eloquent ORM
        $pegawai   = Pegawai::select('nomor_induk','nama','alamat','tanggal_lahir','tanggal_gabung')->where('nomor_induk',$id)->get();
        if($pegawai->count() > 0) {
        // mengirim data pegawai ke view input mapping data
            foreach($pegawai as $key=>$value) {
                $collection = collect($value)->map(function ($values,$keys) {
                    if (Arr::accessible($values)) {
                        foreach($values as $item=>$valueitem) {
                            return $valueitem;
                        }
                    } else {
                        return $values;
                    }
                });
            }
            // passing data
            $dtpegawai[]       =   array(
                'nomor_induk'       => $collection['nomor_induk'],
                'nama'              => $collection['nama'],
                'alamat'            => $collection['alamat'],
                'tanggal_lahir'     => $collection['tanggal_lahir'],
                'tanggal_gabung'    => $collection['tanggal_gabung'],
            );
            return view('pages/formPegawai',['pegawai' => json_decode(json_encode($dtpegawai),FALSE)]);
        } else { 
            return view('pages/404');
        }
    }

    public function store(Request $request) {
        // data from input
        $dataPegawai   = [
            'nomor_induk'   => $request->noInduk,
            'nama'          => $request->inputName,
            'alamat'        => $request->inputAddress,
            'tanggal_lahir' => $request->inputBOD,
            'tanggal_gabung'=> $request->inputJOD
        ];
        // query eloquent ORM insert data
        $insertPegawai  =   Pegawai::create($dataPegawai);
        $response       =   array('status' => 200,'message' => 'Save Success.','success' => 'OK','location' => '/pegawai/index');
        echo json_encode($response);
    }

    public function update(Request $request, $id) {
        // data from input
        $dataPegawai   = [
            'nama'          => $request->inputName,
            'alamat'        => $request->inputAddress,
            'tanggal_lahir' => $request->inputBOD,
            'tanggal_gabung'=> $request->inputJOD
        ];
        // query eloquent ORM update data
        $updatePegawai  =   Pegawai::where('nomor_induk',$id)->update($dataPegawai);
        $response       =   array('status' => 200,'message' => 'Update Success.','success' => 'OK','location' => '/pegawai/index');
        echo json_encode($response);
    }

    public function destroy(Request $request) {
        // eloquent ORM delete data
        $delPegawai    =   Pegawai::where('nomor_induk',$request->noInduk)->delete();
        $response       =   array('status' => 200,'message' => 'Delete Success.','success' => 'OK','location' => '/pegawai/index');
        echo json_encode($response);        
    }

    public function restore(Request $request) {
        // eloquent ORM restore data
        $restorePegawai =   Pegawai::withTrashed()->where('nomor_induk',$request->noInduk)->restore();
        $response       =   array('status' => 200,'message' => 'Restore Success.','success' => 'OK','location' => '/pegawai/index');
        echo json_encode($response);        
    }    
    
    public function truedelete(Request $request) {
        // eloquent ORM delete permanent data
        $delPegawai =   Pegawai::withTrashed()->where('nomor_induk',$request->noInduk)->forceDelete();
        $response   =   array('status' => 200,'message' => 'Delete Permanent Success.','success' => 'OK','location' => '/pegawai/trash');
        echo json_encode($response);        
    }
}
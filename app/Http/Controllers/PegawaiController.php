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
        return view('pages/formPegawai',['pegawai' => array()]);
    }

    public function edit($id) {
        // mengambil data pegawai by id dengan eloquent ORM
        $pegawai   = Pegawai::select('uniqID_Pegawai','email_Pegawai','nama_Pegawai','bod_Pegawai','phone_Pegawai')
        ->with('eloAdr:id_Pegawais,alamat','eloRek:id_Pegawais,nomor_rekening,bank_rekening','eloCustImg:id_Pegawais,file_location,file_image')
        ->where('uniqID_Pegawai',$id)->get();
        // mapping data
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
            'uniqID_Pegawai' 	=> $collection['uniqID_Pegawai'],
            'email_Pegawai' 	=> $collection['email_Pegawai'],
            'nama_Pegawai' 	=> $collection['nama_Pegawai'],
            'bod_Pegawai'      => $collection['bod_Pegawai'],
            'phone_Pegawai' 	=> $collection['phone_Pegawai'],
            'alamat'            => $collection['elo_adr']['alamat'],
            'bank_rekening'     => $collection['elo_rek']['bank_rekening'],
            'nomor_rekening'    => $collection['elo_rek']['nomor_rekening'],
            'file_location'     => $collection['elo_cust_img']['file_location'],
            'file_image'        => $collection['elo_cust_img']['file_image']
        );
        if($pegawai->count() > 0) { 
        // mengirim data pegawai ke view input
            return view('pages/formPegawai',['pegawai' => json_decode(json_encode($dtpegawai),FALSE)]);
        } else { 
            return view('pages/formPegawai',['pegawai' => array()]);
        }
    }

    public function store(Request $request) {
        // membuat ID Pegawai
        $uniqID     = 'Cust-'.hash('crc32', $request->inputEmail);
        // data from input
        $dataPegawai   = [
            'uniqID_Pegawai'   => $uniqID,
            'email_Pegawai'    => $request->inputEmail,
            'nama_Pegawai'     => $request->inputName,
            'bod_Pegawai'      => $request->inputBOD,
            'phone_Pegawai'    => $request->inputPhone
        ];
        $dataAlamat     = [
            'id_Pegawais'  => $uniqID,
            'alamat'        => $request->inputAddress
        ];
        $dataRekening   = [
            'id_Pegawais'      => $uniqID,
            'nomor_rekening'    => $request->inputRekening,
            'bank_rekening'     => $request->inputBank
        ];
        // mengecek Pegawai yg sudah ada by email
        $check  =   Pegawai::where('email_Pegawai','=',$request->inputEmail);
        if ($check->count() > 0) {
            $response       =   array('status' => 400,'message' => 'Data is store.','success' => 'Error','location' => '/Pegawai/index');
        } else {
            if ($request->file('fileImg')!==NULL) {
                $namefile   = $uniqID.'.'.$request->file('fileImg')->extension();
                $uploadFile = Storage::putFileAs('public/img',$request->file('fileImg'),$namefile);
            }
            $dataImage      = [
                'id_Pegawais'      => $uniqID,
                'file_location'     => 'storage/img',
                'file_image'        => ($namefile==NULL) ? 'null':$namefile
            ];
            // query eloquent ORM insert data
            $insertPegawai =   Pegawai::create($dataPegawai);
            $insertAlamat   =   $insertPegawai->eloAdr()->create($dataAlamat);
            $insertRekening =   $insertPegawai->eloRek()->create($dataRekening);
            $insertImage    =   $insertPegawai->eloCustImg()->create($dataImage);
            $response       =   array('status' => 200,'message' => 'Save Success.','success' => 'OK','location' => '/Pegawai/index');
        }
        echo json_encode($response);
    }

    public function update(Request $request, $id) {
        // data from input
        $dataPegawai   = [
            'email_Pegawai'    => $request->inputEmail,
            'nama_Pegawai'     => $request->inputName,
            'bod_Pegawai'      => $request->inputBOD,
            'phone_Pegawai'    => $request->inputPhone
        ];
        $dataAlamat     = [
            'alamat'        => $request->inputAddress
        ];
        $dataRekening   = [
            'nomor_rekening'    => $request->inputRekening,
            'bank_rekening'     => $request->inputBank
        ];
        // query eloquent ORM update data
        $updatePegawai =   Pegawai::where('uniqID_Pegawai',$id)->update($dataPegawai);
        $updateAlamat   =   eloAdr::where('id_Pegawais',$id)->update($dataAlamat);
        $updateRekening =   eloRek::where('id_Pegawais',$id)->update($dataRekening);
        // mengecek file img
        if ($request->file('fileImg')!==NULL) {
            $namefile   = $id.'.'.$request->file('fileImg')->extension();
            $uploadFile = Storage::putFileAs('public/img',$request->file('fileImg'),$namefile);
            $dataImage      = [
                'file_location' => 'storage/img',
                'file_image'    => $namefile
            ];
            $updateImage    =   eloCustImg::where('id_Pegawais',$id)->update($dataImage);
        }
        $response       =   array('status' => 200,'message' => 'Save Success.','success' => 'OK','location' => '/Pegawai/index');
        echo json_encode($response);
    }

    public function destroy(Request $request) {
        // data from input
        $dataPegawai   = [
            'status_delete'    => 1
        ];
        // eloquent ORM delete data
        $updPegawai    =   Pegawai::where('uniqID_Pegawai',$request->dataID)->update($dataPegawai);
        $delPegawai    =   Pegawai::where('uniqID_Pegawai',$request->dataID)->delete();
        $response       =   array('status' => 200,'message' => 'Delete Success.','success' => 'OK','location' => '/Pegawai/index');
        echo json_encode($response);        
    }

    public function restore(Request $request) {
        // data from input
        $dataPegawai   = [
            'status_delete'    => 0
        ]; 
        // eloquent ORM delete data
        $updPegawai        =   Pegawai::withTrashed()->where('uniqID_Pegawai',$request->dataID)->update($dataPegawai);
        $restorePegawai    =   Pegawai::withTrashed()->where('uniqID_Pegawai',$request->dataID)->restore();
        $response   =   array('status' => 200,'message' => 'Restore Success.','success' => 'OK','location' => '/Pegawai/index');
        echo json_encode($response);        
    }    
    
    public function truedelete(Request $request) {
        // eloquent ORM delete data
        $delPegawai    =   Pegawai::withTrashed()->where('uniqID_Pegawai',$request->dataID)->forceDelete();
        $response       =   array('status' => 200,'message' => 'Delete Success.','success' => 'OK','location' => '/Pegawai/trash');
        echo json_encode($response);        
    }
}

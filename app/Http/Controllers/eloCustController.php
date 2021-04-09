<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\eloCust;
use App\Models\eloAdr;
use App\Models\eloRek;
use App\Models\eloCustImg;

class eloCustController extends Controller {

    public function index(Request $request) {
        $currentURL = $request->segment(count(request()->segments()));
        // mengambil data konsumen dengan eloquent ORM
        if ($currentURL=='trash') {
            $konsumen   = eloCust::with('eloAdr','eloRek','eloCustImg')->where('status_delete',1)->onlyTrashed()->get();
            $laman      = 'trashedCustomer';
        } else {
            $konsumen   = eloCust::with('eloAdr','eloRek','eloCustImg')->where('status_delete',0)->get();
            $laman      = 'indexCustomer';
        }
        // mengubah ke array
        $data       = $konsumen->toArray();
        // mengubah ke objek
        $object     = json_decode(json_encode($data),FALSE);
        // passing data
        $collection = collect($object)->map(function ($values) {
            return [
                'uniqID_Customer' 	=> $values->uniqID_Customer,
                'email_customer' 	=> $values->email_customer,
                'nama_customer' 	=> $values->nama_customer,
                'bod_customer'      => $values->bod_customer,
                'phone_customer' 	=> $values->phone_customer,
                'alamat'            => collect($values->elo_adr[0])->get('alamat'),
                'bank_rekening'     => collect($values->elo_rek[0])->get('bank_rekening'),
                'nomor_rekening'    => collect($values->elo_rek[0])->get('nomor_rekening'),
                
            ];
        });
        if($konsumen->count() > 0) { 
        //mengirim data konsumen ke view index
    	    return view($laman,['konsumen' => json_decode(json_encode($collection),FALSE)]);
        } else { 
            return view($laman,['konsumen' => array()]);
        }
    }

    public function create() {
        return view('formCustomer',['konsumen' => array()]);
    }

    public function show($id) {
        // mengambil data konsumen by id dengan eloquent ORM
        $konsumen   = eloCust::with('eloAdr','eloRek','eloCustImg')->where('uniqID_Customer',$id)->get();
        // mengubah ke array
        $data       = $konsumen->toArray();
        // mengubah ke objek
        $object     = json_decode(json_encode($data),FALSE);
        // passing data
        foreach($object as $key) {
            foreach($key->elo_adr as $kAdr) {
                foreach($key->elo_rek as $kRek) {
                    foreach($key->elo_cust_img as $kImg) {
                        $dtkonsumen[]       =   array(
                            'uniqID_Customer' 	=> $key->uniqID_Customer,
                            'email_customer' 	=> $key->email_customer,
                            'nama_customer' 	=> $key->nama_customer,
                            'bod_customer'      => $key->bod_customer,
                            'phone_customer' 	=> $key->phone_customer,
                            'alamat'            => $kAdr->alamat,
                            'bank_rekening'     => $kRek->bank_rekening,
                            'nomor_rekening'    => $kRek->nomor_rekening,
                            'file_location'     => $kImg->file_location,
                            'file_image'        => $kImg->file_image
                        );
                        
                    }
                } 
            }
        }
        // dd($data);
        if($konsumen->count() > 0) { 
        // mengirim data konsumen ke view input
            return view('formCustomer',['konsumen' => json_decode(json_encode($dtkonsumen),FALSE)]);
        } else { 
            return view('formCustomer',['konsumen' => array()]);
        }
    }

    public function store(Request $request) {
        // membuat ID customer
        $uniqID     = 'Cust-'.hash('crc32', $request->inputEmail);
        // data from input
        $dataCustomer   = [
            'uniqID_Customer'   => $uniqID,
            'email_customer'    => $request->inputEmail,
            'nama_customer'     => $request->inputName,
            'bod_customer'      => $request->inputBOD,
            'phone_customer'    => $request->inputPhone
        ];
        $dataAlamat     = [
            'id_customers'  => $uniqID,
            'alamat'        => $request->inputAddress
        ];
        $dataRekening   = [
            'id_customers'      => $uniqID,
            'nomor_rekening'    => $request->inputRekening,
            'bank_rekening'     => $request->inputBank
        ];
        // mengecek customer yg sudah ada by email
        $check  =   eloCust::where('email_customer','=',$request->inputEmail);
        if ($check->count() > 0) {
            $response       =   array('status' => 400,'message' => 'Data is store.','success' => 'Error','location' => '/customer/index');
        } else {
            if ($request->file('fileImg')!==NULL) {
                $namefile   = $uniqID.'.'.$request->file('fileImg')->extension();
                $uploadFile = Storage::putFileAs('public/img',$request->file('fileImg'),$namefile);
            }
            $dataImage      = [
                'id_customers'      => $uniqID,
                'file_location'     => 'storage/img',
                'file_image'        => ($namefile==NULL) ? 'null':$namefile
            ];
            // query eloquent ORM insert data
            $insertCustomer =   eloCust::create($dataCustomer);
            $insertAlamat   =   $insertCustomer->eloAdr()->create($dataAlamat);
            $insertRekening =   $insertCustomer->eloRek()->create($dataRekening);
            $insertImage    =   $insertCustomer->eloCustImg()->create($dataImage);
            $response       =   array('status' => 200,'message' => 'Save Success.','success' => 'OK','location' => '/customer/index');
        }
        echo json_encode($response);
    }

    public function update(Request $request) {
        // data from input
        $dataCustomer   = [
            'email_customer'    => $request->inputEmail,
            'nama_customer'     => $request->inputName,
            'bod_customer'      => $request->inputBOD,
            'phone_customer'    => $request->inputPhone
        ];
        $dataAlamat     = [
            'alamat'        => $request->inputAddress
        ];
        $dataRekening   = [
            'nomor_rekening'    => $request->inputRekening,
            'bank_rekening'     => $request->inputBank
        ];
        // query eloquent ORM update data
        $updateCustomer =   eloCust::where('uniqID_Customer',$request->inputIDCustomer)->update($dataCustomer);
        $updateAlamat   =   eloAdr::where('id_customers',$request->inputIDCustomer)->update($dataAlamat);
        $updateRekening =   eloRek::where('id_customers',$request->inputIDCustomer)->update($dataRekening);
        // mengecek file img
        if ($request->file('fileImg')!==NULL) {
            $namefile   = $request->inputIDCustomer.'.'.$request->file('fileImg')->extension();
            $uploadFile = Storage::putFileAs('public/img',$request->file('fileImg'),$namefile);
            $dataImage      = [
                'file_location' => 'storage/img',
                'file_image'    => $namefile
            ];
            $updateImage    =   eloCustImg::where('id_customers',$request->inputIDCustomer)->update($dataImage);
        }
        $response       =   array('status' => 200,'message' => 'Save Success.','success' => 'OK','location' => '/customer/index');
        echo json_encode($response);
    }

    public function delete(Request $request) {
        // data from input
        $dataCustomer   = [
            'status_delete'    => 1
        ];
        // eloquent ORM delete data
        $updCustomer    =   eloCust::where('uniqID_Customer',$request->dataID)->update($dataCustomer);
        $delCustomer    =   eloCust::where('uniqID_Customer',$request->dataID)->delete();
        $response       =   array('status' => 200,'message' => 'Delete Success.','success' => 'OK','location' => '/customer/index');
        echo json_encode($response);        
    }

    public function restore(Request $request) {
        // data from input
        $dataCustomer   = [
            'status_delete'    => 0
        ]; 
        // eloquent ORM delete data
        $updCustomer        =   eloCust::withTrashed()->where('uniqID_Customer',$request->dataID)->update($dataCustomer);
        $restoreCustomer    =   eloCust::withTrashed()->where('uniqID_Customer',$request->dataID)->restore();
        $response   =   array('status' => 200,'message' => 'Restore Success.','success' => 'OK','location' => '/customer/index');
        echo json_encode($response);        
    }    
    
    public function truedelete(Request $request) {
        // eloquent ORM delete data
        $delCustomer    =   eloCust::withTrashed()->where('uniqID_Customer',$request->dataID)->forceDelete();
        // DB::statement("ALTER TABLE customer AUTO_INCREMENT = 1"); 
        // DB::statement("ALTER TABLE alamat AUTO_INCREMENT = 1");
        // DB::statement("ALTER TABLE rekening AUTO_INCREMENT = 1");
        $response       =   array('status' => 200,'message' => 'Delete Success.','success' => 'OK','location' => '/customer/trash');
        echo json_encode($response);        
    }        
}
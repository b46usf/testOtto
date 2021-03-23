<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class konsumenController extends Controller
{
    public function index() {
        // mengambil data konsumen dengan query builder
        $konsumen = DB::table('customer');
        $konsumen->select(DB::raw('customer.uniqID_Customer,customer.email_customer,customer.nama_customer,alamat.alamat,customer.phone_customer,rekening.bank_rekening'))
        ->join('alamat', 'customer.uniqID_Customer', '=', 'alamat.id_customers')
        ->join('rekening', 'customer.uniqID_Customer', '=', 'rekening.id_customers')
        ->where('customer.status_delete', '=', 0);
        $results    =   $konsumen->get();
        if($results->count() > 0) { 
        //mengirim data konsumen ke view index
    	    return view('indexCustomer',['konsumen' => $results]);
        } 
        else { 
            return false; 
        }
    }
    public function create() {
        return view('formCustomer',['konsumen' => array()]);
    }
    public function show($id) {
        $konsumen = DB::table('customer')
        ->select(DB::raw('*'))
        ->join('customers_image', 'customer.uniqID_Customer', '=', 'customers_image.id_customers')
        ->join('alamat', 'customer.uniqID_Customer', '=', 'alamat.id_customers')
        ->join('rekening', 'customer.uniqID_Customer', '=', 'rekening.id_customers')
        ->where('customer.uniqID_Customer', '=', $id);
        $results    =   $konsumen->get();
        if($results->count() > 0) { 
        //mengirim data konsumen ke view input
            return view('formCustomer',['konsumen' => $results]);
        } 
        else { 
            return false; 
        }
    }
    public function edit(Request $request){
        // mengambil data konsumen by request id dengan query builder
        $konsumen = DB::table('customer')
        ->select(DB::raw('*'))
        ->join('customers_image', 'customer.uniqID_Customer', '=', 'customers_image.id_customers')
        ->join('alamat', 'customer.uniqID_Customer', '=', 'alamat.id_customers')
        ->join('rekening', 'customer.uniqID_Customer', '=', 'rekening.id_customers')
        ->where('customer.uniqID_Customer', '=', $request->dataID);
        $results    =   $konsumen->get();
        if($results->count() > 0) { 
        //mengirim data konsumen ke view input
            $response   =   array('status' => 200,'message' => 'View Success.','success' => 'OK','data'=>$results);
            echo json_encode($response);
        } 
        else { 
            return false; 
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
        $check  =   DB::table('customer')->where('email_customer','=',$request->inputEmail);
        if ($check->count() > 0) {
            $response       =   array('status' => 400,'message' => 'Data is store.','success' => 'Error','location' => '/customer');
        } 
        else {
            if ($request->file('fileImg')!==NULL) {
                $namefile   = $uniqID.'.'.$request->file('fileImg')->extension();
                $uploadFile = Storage::putFileAs('public/img',$request->file('fileImg'),$namefile);
            }
            $dataImage      = [
                'id_customers'      => $uniqID,
                'file_location'     => 'storage/img',
                'file_image'        => ($namefile==NULL) ? 'null':$namefile
            ];
            // query builder insert data
            $insertImage    =   DB::table('customers_image')->insert($dataImage);
            $insertCustomer =   DB::table('customer')->insert($dataCustomer);
            $insertAlamat   =   DB::table('alamat')->insert($dataAlamat);
            $insertRekening =   DB::table('rekening')->insert($dataRekening);
            $response       =   array('status' => 200,'message' => 'Save Success.','success' => 'OK','location' => '/customer');
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
        // mengecek file img
        if ($request->file('fileImg')!==NULL) {
            $namefile   = $request->inputIDCustomer.'.'.$request->file('fileImg')->extension();
            $uploadFile = Storage::putFileAs('public/img',$request->file('fileImg'),$namefile);
            $dataImage      = [
                'file_location' => 'storage/img',
                'file_image'    => $namefile
            ];
            $updateImage    =   DB::table('customers_image')->where('id_customers',$request->inputIDCustomer)->update($dataImage);
        }
        // query builder update data
        $updateCustomer =   DB::table('customer')->where('uniqID_Customer',$request->inputIDCustomer)->update($dataCustomer);
        $updateAlamat   =   DB::table('alamat')->where('id_customers',$request->inputIDCustomer)->update($dataAlamat);
        $updateRekening =   DB::table('rekening')->where('id_customers',$request->inputIDCustomer)->update($dataRekening);
        $response       =   array('status' => 200,'message' => 'Save Success.','success' => 'OK','location' => '/customer');
        echo json_encode($response);
    }
    public function delete(Request $request)
    {
        // data from input
        $dataCustomer   = [
            'status_delete'    => 1
        ];
        // query builder update data
        $deleteCustomer =   DB::table('customer')->where('uniqID_Customer',$request->dataID)->update($dataCustomer);
        $response       =   array('status' => 200,'message' => 'Delete Success.','success' => 'OK','location' => '/customer');
        echo json_encode($response);        
    }
}
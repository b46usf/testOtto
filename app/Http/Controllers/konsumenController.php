<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('formCustomer');
    }
    public function show() {
        return view('formCustomer');
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
    //
    }
    public function update(Request $request) {
    //
    }
}
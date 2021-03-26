<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\eloCust;

class eloCustController extends Controller
{
    public function index() {
        // mengambil data konsumen dengan eloquent ORM
        $konsumen   = eloCust::with('eloAdr','eloRek','eloCustImg')->where('status_delete',0)->get();
        // mengubah ke array
        $data       = $konsumen->toArray();
        // mengubah ke objek
        $object     = json_decode(json_encode($data),FALSE);
        // passing data
        foreach($object as $key) {
            foreach($key->elo_adr as $kAdr) {
                foreach($key->elo_rek as $kRek) {
                    $dtkonsumen[]       =   array(
                        'uniqID_Customer' 	=> $key->uniqID_Customer,
                        'email_customer' 	=> $key->email_customer,
                        'nama_customer' 	=> $key->nama_customer,
                        'bod_customer'      => $key->bod_customer,
                        'phone_customer' 	=> $key->phone_customer,
                        'alamat'            => $kAdr->alamat,
                        'bank_rekening'     => $kRek->bank_rekening
                    );
                }
            }
        }
        //dd($dtkonsumen);
        if($konsumen->count() > 0) { 
        //mengirim data konsumen ke view index
    	    return view('indexCustomer',['konsumen' => json_decode(json_encode($dtkonsumen),FALSE)]);
        } 
        else { 
            return view('indexCustomer',['konsumen' => array()]);
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
        //dd($dtkonsumen);
        if($konsumen->count() > 0) { 
        //mengirim data konsumen ke view input
            return view('formCustomer',['konsumen' => json_decode(json_encode($dtkonsumen),FALSE)]);
        } 
        else { 
            return view('formCustomer',['konsumen' => array()]);
        }
    }
    public function store(Request $request) {
        // membuat ID customer
        $uniqID     = 'Cust-'.hash('crc32', $request->inputEmail);
        // data from input
    }
}
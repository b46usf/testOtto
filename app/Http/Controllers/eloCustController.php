<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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
    	    return view('indexCustomer',['konsumen' => json_decode(json_encode($collection),FALSE)]);
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
        $konsumen   = eloCust::select('uniqID_Customer','email_customer','nama_customer','bod_customer','phone_customer')
        ->with('eloAdr:id_customers,alamat','eloRek:id_customers,nomor_rekening,bank_rekening','eloCustImg:id_customers,file_location,file_image')
        ->where('uniqID_Customer',$id)->get();
        // mapping data
        foreach($konsumen as $key=>$value) {
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
        $dtkonsumen[]       =   array(
            'uniqID_Customer' 	=> $collection['uniqID_Customer'],
            'email_customer' 	=> $collection['email_customer'],
            'nama_customer' 	=> $collection['nama_customer'],
            'bod_customer'      => $collection['bod_customer'],
            'phone_customer' 	=> $collection['phone_customer'],
            'alamat'            => $collection['elo_adr']['alamat'],
            'bank_rekening'     => $collection['elo_rek']['bank_rekening'],
            'nomor_rekening'    => $collection['elo_rek']['nomor_rekening'],
            'file_location'     => $collection['elo_cust_img']['file_location'],
            'file_image'        => $collection['elo_cust_img']['file_image']
        );
        if($konsumen->count() > 0) { 
        // mengirim data konsumen ke view input
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
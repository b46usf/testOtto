<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\eloCust;

class eloCustController extends Controller
{
    public function index() {
        DB::enableQueryLog();
        // mengambil data konsumen dengan eloquent ORM
        $konsumen = eloCust::with(['eloAdr' => function ($query) {$query->select('alamat');}])->get();dd(DB::getQueryLog());
        if($konsumen->count() > 0) { 
        //mengirim data konsumen ke view index
    	    return view('indexCustomer',['konsumen' => $konsumen]);
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
        $konsumen = eloCust::where('uniqID_Customer',$id)->get();dd($konsumen);
        if($konsumen->count() > 0) { 
        //mengirim data konsumen ke view input
            return view('formCustomer',['konsumen' => $konsumen]);
        } 
        else { 
            return view('formCustomer',['konsumen' => array()]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\eloCust;

class eloCustController extends Controller
{
    public function index() {
        // mengambil data konsumen dengan eloquent ORM
        $konsumen = eloCust::all();
        if($konsumen->count() > 0) { 
        //mengirim data konsumen ke view index
    	    return view('indexCustomer',['konsumen' => $konsumen]);
        } 
        else { 
            return view('indexCustomer',['konsumen' => array()]);
        }
    }
}

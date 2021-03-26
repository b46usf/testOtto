<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eloRek extends Model
{
    //use HasFactory;
    // table
    protected $table = 'rekening';
    // primary key
    //protected $primaryKey = 'id_customers';
    // coloumn table
    protected $fillable = 
    [
        'nomor_rekening',
        'bank_rekening'
    ];
    // public function eloCust()
    // {
    //     return $this->belongsTo('App\Models\eloCust','uniqID_Customer','id_customers');
    // }
}

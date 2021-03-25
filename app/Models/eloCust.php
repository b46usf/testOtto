<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\eloAdr;
// use App\Models\eloRek;
// use App\Models\eloCustImg;

class eloCust extends Model
{
    //use HasFactory;
    // table
    protected $table = 'customer';
    // primary key
    protected $primaryKey = 'uniqID_Customer';
    // coloumn table
    protected $fillable = 
    [
        //'uniqID_Customer',
        'nama_customer',
        'bod_customer',
        'phone_customer',
        'status_delete',
        //'alamat',
        //'provinsi'
    ];
    public function eloAdr()
    {
        return $this->hasMany('App\Models\eloAdr','uniqID_Customer','id_customers'); 
    }
    // public function rekeningRelation()
    // {
    //     return $this->hasMany(eloRek::class,'uniqID_Customer','id_customers');
    // }
    // public function imageRelation()
    // {
    //     return $this->hasOne(eloCustImg::class,'uniqID_Customer','id_customers');
    // }
}

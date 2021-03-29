<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class eloCust extends Model {
    // table
    protected $table = 'customer';
    // primary key
    // protected $primaryKey = 'uniqID_Customer';
    // coloumn table
    protected $fillable = 
    [
        'uniqID_Customer',
        'nama_customer',
        'bod_customer',
        'phone_customer',
        'status_delete',
    ];
    public function eloAdr() {
        return $this->hasMany('App\Models\eloAdr','id_customers','uniqID_Customer'); 
    }
    public function eloRek() {
        return $this->hasMany('App\Models\eloRek','id_customers','uniqID_Customer');
    }
    public function eloCustImg() {
        return $this->hasMany('App\Models\eloCustImg','id_customers','uniqID_Customer');
    }
}
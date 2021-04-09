<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class eloCust extends Model {
    use SoftDeletes;
    // table
    protected $table = 'customer';
    protected $dates = ['deleted_at'];
    // primary key
    // protected $primaryKey = 'uniqID_Customer';
    // coloumn table
    protected $fillable = 
    [
        'uniqID_Customer',
        'email_customer',
        'nama_customer',
        'bod_customer',
        'phone_customer',
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
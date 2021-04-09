<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class eloAdr extends Model {
    // table
    protected $table = 'alamat';
    // primary key
    // protected $primaryKey = 'id_customers';
    // coloumn table
    protected $fillable = 
    [
        'id_customers',
        'alamat',
    ];
    public function eloCust() {
        return $this->belongsTo('App\Models\eloCust','uniqID_Customer','id_customers');
    }
}
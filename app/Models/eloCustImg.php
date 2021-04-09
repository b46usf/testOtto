<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class eloCustImg extends Model {
    // table
    protected $table = 'customers_image';
    // primary key
    // protected $primaryKey = 'id_customers';
    // coloumn table
    protected $fillable = 
    [
        'id_customers',
        'file_location',
        'file_image',
    ];
    public function eloCust() {
        return $this->belongsTo('App\Models\eloCust','uniqID_Customer','id_customers');
    }
}
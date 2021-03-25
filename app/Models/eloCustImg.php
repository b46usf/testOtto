<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eloCustImg extends Model
{
    use HasFactory;
    // table
    protected $table = 'customers_image';
    // primary key
    protected $primaryKey = 'idtab_image';
    // coloumn table
    protected $fillable = 
    [
        'file_location',
        'file_image'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eloRek extends Model
{
    use HasFactory;
    // table
    protected $table = 'rekening';
    // primary key
    protected $primaryKey = 'id_rekening';
    // coloumn table
    protected $fillable = 
    [
        'nomor_rekening',
        'bank_rekening'
    ];
}

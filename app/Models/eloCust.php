<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eloCust extends Model
{
    use HasFactory;
    // table
    protected $table = 'customer';
    // primary key
    protected $primaryKey = 'id_table_customer ';
    // coloumn table
    protected $fillable = 
    [
        'nama_customer',
        'bod_customer',
        'phone_customer',
        'status_delete'
    ];
    public function alamatRelation()
    {
        return $this->hasMany(Alamat::class,'id_customers'); 
    }
    public function RekeningRelation()
    {
        return $this->hasMany(Rekening::class,'id_customers');
    }
}

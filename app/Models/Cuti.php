<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuti extends Model
{
    use HasFactory;
    use SoftDeletes;
    // table
    protected $table = 'cuti';
    protected $dates = ['deleted_at'];
    // coloumn table
    protected $fillable = 
    [
        'nomor_induk',
        'tanggal_cuti',
        'lama_cuti',
        'keterangan',
    ];
    public function Pegawai() {
        return $this->hasMany('App\Models\Pegawai','nomor_induk','nomor_induk');
    }
}
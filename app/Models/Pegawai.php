<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory;
    use SoftDeletes;
    // table
    protected $table = 'pegawai';
    protected $dates = ['deleted_at'];
    // coloumn table
    protected $fillable = 
    [
        'nomor_induk',
        'nama',
        'alamat',
        'tanggal_lahir',
        'tanggal_gabung',
    ];
    public function Cuti() {
        return $this->hasMany('App\Models\Cuti','nomor_induk','nomor_induk');
    }
}
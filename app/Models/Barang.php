<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Barang extends Model
{
     protected $table = 'barang';
     protected $primaryKey = 'id';
     public $fillable = ['nama', 'satuan', 'limit', 'keterangan', 'flag'];

     public function pembelian(){
     	return $this->hasMany('App\Models\Pembelian','id_barang')
     			  ->select('id_barang', DB::raw('SUM(stok) as total_stok'))
     			  ->groupBy('id_barang');
     }

     public function penjualan(){
     	return $this->hasMany('App\Models\Penjualan', 'id_barang')
                      ->select('id_barang', DB::raw('SUM(stok) as total_stok'))
                      ->groupBy('id_barang');
     }
}

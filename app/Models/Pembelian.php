<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'id';
    public $fillable = ['id_barang', 'id_user', 'id_supplier', 'stok', 'stok_akhir', 'expired', 'flag'];

    public function Barang(){

    	return $this->belongsTo('App\Models\Barang','id_barang'); 
    }

    public function Supplier(){
    	return $this->belongsTo('App\Models\Supplier', 'id_supplier');
    }

    public function User(){
    	return $this->belongsTo('App\User', 'id_user');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id';
    public $fillable = ['id_barang', 'id_user', 'stok', 'flag'];

    public function barang(){

    	return $this->belongsTo('App\Models\Barang','id_barang'); 
    }

    public function user(){
    	return $this->belongsTo('App\User', 'id_user');
    }
}

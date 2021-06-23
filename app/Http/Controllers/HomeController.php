<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    
        
        $data['limit'] = $this->getLimitStok();
        $data['stok'] = $this->getAllCount();
        $data['bulan'] = $this->getGrafik();
        return view('home', $data);
    }

    public function getAllCount(){
        $countBarang    = Barang::count('id');
        $countPembelian = Pembelian::count('id');
        $countPenjualan = Penjualan::count('id');

        // get All Stok
        $pembelian = Pembelian::select(DB::raw('SUM(stok) as total_stok'))->get();
        $penjualan = Penjualan::select(DB::raw('SUM(stok) as total_stok'))->get();

        foreach ($pembelian as $key => $value) {

            $stokPembelian = $value->total_stok;

            foreach ($penjualan as $k => $v) {
                $stokPenjualan = $v->total_stok;
                $allStok = $value->total_stok - $v->total_stok;
            }
        }

        $data = [
                    'barang'        => $countBarang,
                    'penjualan'     => $countPenjualan,
                    'pembelian'     => $countPembelian,
                    'allStok'       => $allStok,
                    'stokPembelian' => $stokPembelian,
                    'stokPenjualan' => $stokPenjualan, 
                ];


        return $data;
    }

    public function getLimitStok(){

         $data = Barang::with('pembelian', 'penjualan')->where('flag', 1)->get();
         $arrayData = [];

         foreach ($data as $key => $row) {

            // mendapat kan total pembelian
            if (count($row->pembelian) > 0){
                foreach ($row->pembelian as $key => $value) {
                $stok_beli = $value->total_stok;
                }
            }else{
                $stok_beli = 0;
            }

            //mendapat kan total penjualan
            if (count($row->penjualan) > 0){
                foreach ($row->penjualan as $key => $x) {
                $stok_jual = $x->total_stok;
                }
            }else{
                 $stok_jual = 0;
            }

            $stok_total = $stok_beli - $stok_jual;
            
            if ($stok_total <= $row->limit){
                
                $arrayData[] = ['id' => $row->id, 'nama' => $row->nama, 'stok' => $stok_total];

            }

         }

          return $arrayData;
    }

    public function getGrafik(){
        //setting tangal utama
        $now = \Carbon\Carbon::now()->addMonth(-5);
        //tampungan array
        $arrayData = [];
        //lopping tanggal 6 bulan terakhir
        for ($i=1; $i <= 6; $i++) {
            // set date array
            $date = $now->format('m-Y');  
            
            // query pemebelian
            $pembelian = Pembelian::whereYear('created_at', '=', $now->format('Y'))
                                   ->whereMonth('created_at', '=', $now->format('m'))
                                   ->select(DB::raw('SUM(stok) as total_stok'))
                                   ->get();
            
            foreach ($pembelian as $key => $value) {
                if(!empty($value->total_stok)){
                    $stok_pembelian = $value->total_stok;
                }else{
                    $stok_pembelian = 0;
                }
            }
            // end pembelian

            // query penjualan
            $penjualan = Penjualan::whereYear('created_at', '=', $now->format('Y'))
                                   ->whereMonth('created_at', '=', $now->format('m'))
                                   ->select(DB::raw('SUM(stok) as total_stok'))
                                   ->get();

            foreach ($penjualan as $key => $value) {
                if(!empty($value->total_stok)){
                    $stok_penjualan = $value->total_stok;
                }else{
                    $stok_penjualan = 0;
                }
            }
            // end penjualan
          
            // push ke variable $arrayData
            if (!in_array($date, $arrayData)){
                $arrayData[$date] = [
                                'date'           => $now->format('M Y'),  
                                'stok_pembelian' => $stok_pembelian,
                                'stok_penjualan' => $stok_penjualan,
                            ]; 
            }

            // looping menambah 1 bulan setiap looping 
            $now->addMonth(1);
        }

        return $arrayData;
    }

}

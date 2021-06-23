<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\Barang;
use DataTables;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax()) {
            $query = Penjualan::with('barang', 'user')->get();
            return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) {
                        $btn = '
                                <button type="button" class="mb-1 btn btn-warning btn-sm edit" data-id='.$row->id.'>
                                    <i class="mdi mdi-pencil-box-multiple mr-1"></i>Edit
                                </button>
                                <button type="button" class="mb-1 btn btn-danger btn-sm delete" data-id='.$row->id.'>
                                    <i class="mdi mdi-trash-can-outline mr-1"></i>Hapus
                                </button>
                                
                                ';
                        return $btn;
                    })
                    ->addColumn('date', function($row){
                        return $row->created_at->format('d, M Y H:i');
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $data=['item' => Barang::all()];
        return view('penjualan.view', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Barang::with('pembelian', 'penjualan')->where('flag', 1)->where('id', $request->barang)->first();
        if(count($data->penjualan) > 0 ){
            foreach ($data->penjualan as $key => $value) {
                $penjualan = $value->total_stok;
            } 
        }else{
            $penjualan = 0;
        }

        if(count($data->pembelian) > 0 ){
            foreach ($data->pembelian as $key => $value) {
                $pembelian = $value->total_stok;
            }
        }else{
            $pembelian = 0;
        }
        $stok = $pembelian - $penjualan;
        $jual = $request->stok + $data->limit;
        
        if($stok > $jual){
           $insert = Penjualan::updateOrCreate(['id' => $request->id],
            [
                'id_barang' => $request->barang,
                'id_user'   => $request->user,
                'stok'      => $request->stok,
                'flag'      => 1
            ]);
         return response()->json(['data' => $insert, 'kondisi' => true]);

        }else{
            $insert = [];
            return response()->json(['data' => $insert, 'kondisi' => false]);
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Penjualan::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ['flag' => 2];
        $update = Penjualan::find($id)->update($data);
        return response()->json($update);
    }
}

<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pembelian;
use Illuminate\Support\Facades\DB;
use DataTables;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $data = Barang::with('pembelian', 'penjualan')->where('flag', 1)->get();

        if ($request->ajax()) {
            return DataTables::of($data)    
                    ->addIndexColumn()
                    ->addColumn('action', function($row) {
                        $btn = '
                                <button type="button" class="mb-1 btn btn-info btn-sm detail" data-id='.$row->id.'>
                                    <i class="mdi mdi-account-card-details mr-1"></i>Detail
                                </button>
                                <button type="button" class="mb-1 btn btn-warning btn-sm edit" data-id='.$row->id.'>
                                    <i class="mdi mdi-pencil-box-multiple mr-1"></i>Edit
                                </button>
                                <button type="button" class="mb-1 btn btn-danger btn-sm delete" data-id='.$row->id.'>
                                    <i class="mdi mdi-trash-can-outline mr-1"></i>Hapus
                                </button>
                                
                                ';
                        return $btn;
                    })
                    ->addColumn('stok', function($row) {
                       if (count($row->pembelian) > 0){
                            foreach ($row->pembelian as $key => $value) {
                            $stok_beli = $value->total_stok;
                            }
                        }else{
                            $stok_beli = 0;
                        }

                        if (count($row->penjualan) > 0){
                            foreach ($row->penjualan as $key => $x) {
                            $stok_jual = $x->total_stok;
                            }
                        }else{
                             $stok_jual = 0;
                        }

                        $stok_total = $stok_beli - $stok_jual;


                        return [ 'stok_total' => $stok_total,
                                 'stok_awal' => $stok_beli,
                                 'stok_jual' => $stok_jual
                               ];
                    })
                    ->addColumn('status', function($row) {
                        if (count($row->pembelian) > 0){
                            foreach ($row->pembelian as $key => $value) {
                            $stok_beli = $value->total_stok;
                            }
                        }else{
                            $stok_beli = 0;
                        }

                        if (count($row->penjualan) > 0){
                            foreach ($row->penjualan as $key => $x) {
                            $stok_jual = $x->total_stok;
                            }
                        }else{
                             $stok_jual = 0;
                        }

                        $stok_total = $stok_beli - $stok_jual;
                        if ($stok_total <= $row->limit){
                            $status = '<span class="mb-2 mr-2 badge badge-danger">Stok Limit</span>';
                        }else{
                            $status = '<span class="mb-2 mr-2 badge badge-primary">Aman</span>';
                        }
                        return $status;
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);

        }

        return view('barang.view');
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
        $insert = Barang::updateOrCreate(['id' => $request->id],
            [
                    'nama'       => $request->barang,
                    'satuan'     => $request->satuan,
                    'limit'      => $request->limit,
                    'keterangan' => $request->ket,
                    'flag'       => 1
        ]);

         return response()->json($insert);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Barang::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ['flag' => 2];
        $update = Barang::find($id)->update($data);
        return response()->json($update);
    }
}

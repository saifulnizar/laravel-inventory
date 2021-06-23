<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Illuminate\Http\Request;

use App\Models\Barang;
use App\Models\Supplier;
use DataTables;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
       

        if ($request->ajax()) {
            $data = Pembelian::with(['Barang', 'Supplier', 'User'])->where('flag', 1)->get();
            return DataTables::of($data)
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
                    ->addColumn('date', function($row) {
                        $date = [
                            'expired' => date('d, M Y', strtotime($row->expired)) ,
                            'created' => $row->created_at->format('d, M Y H:i')
                        ];
                        return $date;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $data = [
                    'item' => Barang::all(),
                    'supplier' => Supplier::All(),
        ];
        
        return view('pembelian.view', $data);
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
        
        $insert = Pembelian::updateOrCreate(['id' => $request->id],
            [
                    'id_barang'     => $request->barang,
                    'id_supplier'   => $request->supplier,
                    'id_user'       => $request->user,
                    'stok'          => $request->stok,
                    'stok_akhir'    => $request->stok,
                    'expired'       => date('Y-m-d H:i:s', strtotime($request->dateRange)),
                    'flag'          => 1,
        ]);

         return response()->json($insert);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show(Pembelian $pembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Pembelian::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ['flag' => 2];
        $update = Pembelian::find($id)->update($data);
        return response()->json($update);
    }
}

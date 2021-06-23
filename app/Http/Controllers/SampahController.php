<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\User;

use DataTables;

class SampahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            
            $arrayData = [];
            $barang = Barang::where('flag', 2)->get();

            foreach ($barang as $key => $value) {
                
                $arrayData[] = [ 
                    'id'    => $value->id, 
                    'nama'  => $value->nama, 
                    'stok'  => '---',
                    'jenis' => 'Barang', 
                    'date'  => $value->updated_at->format('d, M Y H:i') 
                ];

            }

            $supplier = Supplier::where('flag', 2)->get();

            foreach ($supplier as $key => $value) {

                 $arrayData[] = [ 
                    'id'    => $value->id, 
                    'nama'  => $value->nama, 
                    'stok'  => '---',
                    'jenis' => 'Supplier', 
                    'date'  => $value->updated_at->format('d, M Y H:i') 
                ];

            }

            $user  = User::where('flag', 2)->get();

            foreach ($user as $key => $value) {

                $arrayData[] = [ 
                    'id'    => $value->id, 
                    'nama'  => $value->name, 
                    'stok'  => '---',
                    'jenis' => 'User', 
                    'date'  => $value->updated_at->format('d, M Y H:i') 
                ];

            }

            $pembelian = Pembelian::with('Barang')->where('flag', 2)->get();
            foreach ($pembelian as $key => $value) {
                
                $arrayData[] =[
                    'id'    => $value->id,
                    'nama'  => $value->barang['nama'],
                    'stok'  => $value->stok,
                    'jenis' => 'Pembelian',
                    'date'  => $value->updated_at->format('d, M Y H:i')
                ];

            }

            $penjualan = Penjualan::with('Barang')->where('flag', 2)->get();
            foreach ($penjualan as $key => $value) {
                
                $arrayData[] = [
                        'id'    => $value->id,
                        'nama'  => $value->barang['nama'],
                        'stok'  => $value->stok,
                        'jenis' => 'Penjualan',
                        'date'  => $value->updated_at->format('d, M Y H:i')
                ];

            }

            return DataTables::of($arrayData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) {
                        $btn = "
                                <button type='button' class='mb-1 btn btn-warning btn-sm undo' data-id=".$row['id']." data-jenis=".$row['jenis'].">
                                    <i class='mdi mdi-pencil-box-multiple mr-1'></i>Restore
                                </button>
                                ";
                        return $btn;
                    })
                    ->addColumn('tanggal', function($row){
                        return $row['date'];
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }    

        return view('sampah.view');
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
        $data = ['flag' => 1];  
        switch ($request->jenis) {
            case 'Barang':
                 $update = Barang::find($request->id)->update($data);
                break;
            case 'Supplier':
                 $update = Supplier::find($request->id)->update($data);
                break;
            case 'Pembelian':
                 $update = Pembelian::find($request->id)->update($data);
                break;
            case 'Penjualan':
                 $update = Penjualan::find($request->id)->update($data);
                break;
            default:
                 $update = User::find($request->id)->update($data);
                break;
        }
       

        return response()->json($request->jenis);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

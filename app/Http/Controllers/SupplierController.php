<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

use DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Supplier::where('flag', 1)->get();
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
                    ->addColumn('ket', function($row) {
                        switch ($row->status) {
                            case 1:
                                $btn = '<span class="mb-2 mr-2 badge badge-primary">Aktiv</span>';
                                break;
                            
                            default:
                                 $btn = '<span class="mb-2 mr-2 badge badge-danger">Tidak Aktiv</span>';
                                break;
                        }
                         return $btn;
                    })
                    ->rawColumns(['action', 'ket'])
                    ->make(true);
        }

        return view('supplier.view');
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
        $insert = Supplier::updateOrCreate(['id' => $request->id],
            [
                    'nama'       => $request->nama,
                    'no'         => $request->no,
                    'status'     => $request->status,
                    'flag'       => 1
        ]);

         return response()->json($insert);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Supplier::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ['flag' => 2];
        $update = Supplier::find($id)->update($data);
        return response()->json($update);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use DataTables;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::where('flag', 1)->get();

        if ($request->ajax()) {
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
                    ->addColumn('status', function($row) {
                        return '1 Transaksi';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return  view('user.view');
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
         $insert = User::updateOrCreate(['id' => $request->id],
            [
                    
                    'name'      => $request->nama,
                    'email'     => $request->email,
                    'level'     => $request->level,
                    'password'  => bcrypt('123456'),
                    'flag'      => 1
        ]);

         return response()->json($insert);
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
         $data = User::find($id);
        return response()->json($data);
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
        $data = ['flag' => 2];
        $update = User::find($id)->update($data);
        return response()->json($update);
    }
}

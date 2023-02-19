<?php

namespace App\Http\Controllers;

use App\Models\tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ControllerTamu extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = tamu::orderBy('nama','asc')->paginate(5);
        return view('tamu.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tamu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Session::flash('nama', $request->nama);
        Session::flash('notelp', $request->notelp);
        Session::flash('alamat', $request->alamat);

        $request->validate([
            'nama' => 'required',
            'notelp' => 'required|numeric|unique:tamu,notelp',
            'alamat' => 'required',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'notelp.numeric' => 'Nomor Telepon wajib dalam angka',
            'notelp.unique' => 'Nomor Telepon sudah terdaftar',
            'notelp.required' => 'Nomor Telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
        ]);
        $data = [
            'nama' => $request->nama,
            'notelp' => $request->notelp,
            'alamat' => $request->alamat,
        ];
        tamu::create($data);
        return redirect()->to('tamu')->with('success', 'Data berhasil ditambahkan');
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
        $data = tamu::where('notelp',$id)->first();
        return view('tamu.edit')->with('data', $data);
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
        Session::flash('nama', $request->nama);
        Session::flash('notelp', $request->notelp);
        Session::flash('alamat', $request->alamat);

        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
        ]);
        $data = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
        ];
        tamu::where('notelp',$id)->update($data);
        return redirect()->to('tamu')->with('success', 'BERHASIL UPDATE');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        tamu::where('notelp', $id)->delete();
        return redirect()->to('tamu')->with('success', 'Data terhapus');
    }
}

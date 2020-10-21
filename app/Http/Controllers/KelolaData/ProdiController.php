<?php

namespace App\Http\Controllers\KelolaData;

use App\Http\Controllers\Controller;
use App\Major;
use App\StudyProgram;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jurusan = Major::all();
        $prodi = StudyProgram::all();

        return view('admin.kelola-data.prodi.index', compact('prodi','jurusan'));
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
        $request->validate([
            'nama_prodi' => 'required|unique:study_programs,nama_prodi',
        ]);

        StudyProgram::create([
            'nama_prodi' => $request->nama_prodi,
            'jurusan_id' => $request->jurusan_id
        ]);

        return redirect('/admin/kelola-data/prodi');
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
        $jurusan = Major::all();
        $prodi = StudyProgram::find($id);

        return view('admin.kelola-data.prodi.edit', compact('prodi','jurusan'));
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
        $request->validate([
            'nama_prodi' => 'required',
        ]);

        StudyProgram::where('id', $id)->update([
            'nama_prodi' => $request->nama_prodi,
            'jurusan_id' => $request->jurusan_id
        ]);
        return redirect('/admin/kelola-data/prodi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StudyProgram::destroy($id);
        return redirect('/admin/kelola-data/prodi');
    }
}

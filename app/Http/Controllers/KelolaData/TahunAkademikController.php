<?php

namespace App\Http\Controllers\KelolaData;

use App\AcademicYear;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun_akademik = AcademicYear::all();

        return view('admin.kelola-data.tahun-akademik.index', compact('tahun_akademik'));
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
            'tahun' => 'required',
        ]);

        AcademicYear::create([
            'tahun' => $request->tahun,
            'ganjil_genap' => $request->ganjil_genap
        ]);

        return redirect('/admin/kelola-data/tahun-akademik');
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
        $tahun_akademik = AcademicYear::find($id);

        return view('admin.kelola-data.tahun-akademik.edit', compact('tahun_akademik'));
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
            'tahun' => 'required',
        ]);

        AcademicYear::where('id', $id)->update([
            'tahun' => $request->tahun,
            'ganjil_genap' => $request->ganjil_genap
        ]);

        return redirect('/admin/kelola-data/tahun-akademik');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AcademicYear::destroy($id);

        return redirect('/admin/kelola-data/tahun-akademik');
    }
}

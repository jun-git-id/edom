<?php

namespace App\Http\Controllers;

use App\Competence;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kompetensi =  Competence::all();
        $pertanyaan = DB::table('questions')
        ->join('competences', 'questions.kompetensi_id','competences.id')
        ->select('questions.*', 'aspek_kompetensi')
        ->get();

        return view('admin.kuisioner.pertanyaan.index', compact('pertanyaan','kompetensi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.kuisioner.pertanyaan.create', compact('kompetensi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Question::create([
            'pertanyaan' => $request->pertanyaan,
            'kompetensi_id' => $request->kompetensi_id
        ]);

        return redirect('/admin/kuisioner/pertanyaan');
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
        $kompetensi =  Competence::all();
        $pertanyaan = Question::find($id);

        return view('admin.kuisioner.pertanyaan.edit', compact('pertanyaan','kompetensi'));
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
        Question::where('id',$id)->update([
            'pertanyaan' => $request->pertanyaan,
            'kompetensi_id' => $request->kompetensi_id
        ]);

        return redirect('/admin/kuisioner/pertanyaan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::destroy($id);

        return redirect('/admin/kuisioner/pertanyaan');
    }
}

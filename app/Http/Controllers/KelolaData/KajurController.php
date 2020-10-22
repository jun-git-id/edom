<?php

namespace App\Http\Controllers\KelolaData;

use App\Http\Controllers\Controller;
use App\Major;
use App\MajorChief;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KajurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jurusan = Major::all();
        $kajur = MajorChief::all();

        return view('admin.kelola-akun.kajur.index', compact('kajur', 'jurusan'));
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
            'username' => 'required|max:10|unique:users,username',
            'nama' => 'required|string',
            'email' => 'required',
            'ttd' => 'required|file|image|max:5000'
        ]);

        $file = $request->file('ttd');

        $nama_file = $file->getClientOriginalName() . rand();

        $file->move('ttd-kajur', $nama_file);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role_id' => '4'
        ]);

        MajorChief::create([
            'nama' => $request->nama,
            'user_id' => $user->id,
            'jurusan_id' => $request->jurusan_id,
            'ttd' => $nama_file
        ]);

        return redirect('/admin/kelola-akun/kajur');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $kajur = MajorChief::find($id);

        return view('admin.kelola-akun.kajur.edit', compact('kajur', 'jurusan'));
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
            'username' => 'required|max:10',
            'nama' => 'required|string',
            'email' => 'required'
        ]);


        $nama_file = $request->ttd;
        if ($request->file('ttd')) {
            $request->validate([
                'ttd' => 'file|image|max:5000'
            ]);

            $file = $request->file('ttd');

            $nama_file = $file->getClientOriginalName() . rand();

            $file->move('ttd-kajur', $nama_file);
        }

        MajorChief::where('id', $id)->update([
            'nama' => $request->nama,
            'jurusan_id' => $request->jurusan_id,
            'ttd' => $nama_file
        ]);

        User::where('id', MajorChief::find($id)->user->id)->update([
            'email' => $request->email,
            'username' => $request->username
        ]);

        return redirect('/admin/kelola-akun/kajur');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user_id = MajorChief::find($id)->user_id;
        MajorChief::destroy($id);
        User::destroy($user_id);

        return redirect('/admin/kelola-akun/kajur');
    }
}

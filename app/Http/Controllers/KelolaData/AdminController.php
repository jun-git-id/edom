<?php

namespace App\Http\Controllers\KelolaData;

use App\Admin;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::all();
        return view('admin.kelola-akun.admin.index', compact('admin'));
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
            'email' => 'required'
        ]);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role_id' => '1'
        ]);
        Admin::create([
            'nama' => $request->nama,
            'user_id' => $user->id
        ]);

        return redirect('/admin/kelola-akun/admin');
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
        $admin = Admin::find($id);

        return view('admin.kelola-akun.admin.edit', compact('admin'));
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

        Admin::where('id', $id)->update([
            'nama' => $request->nama
        ]);

        User::where('id', Admin::find($id)->user->id)->update([
            'email' => $request->email,
            'username' => $request->username
        ]);

        return redirect('/admin/kelola-akun/admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::destroy($id);

        return redirect('/admin/kelola-akun/admin');
    }
}

@extends('layouts.master-admin')

@section('title','Lihat Data Mahasiswa')

@section('search')
<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="" method="GET">
    <div class="input-group">
        <input name="s" type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
</form>

@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Lihat Data Mahasiswa</h1>
</div>


<table class="table table-bordered table-striped table-hover">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">NIM</th>
            <th scope="col">Nama</th>
            <th scope="col">Email</th>
            <th scope="col">Kelas</th>
            <th scope="col">Prodi</th>
            <th scope="col">Angkatan</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mahasiswa as $mhs)
        <tr>
            <td>{{ $loop->iteration + $mahasiswa->firstItem() - 1 }}</td>
            <td>{{ $mhs->nim }}</td>
            <td>{{ $mhs->nama }}</td>
            <td>{{ $mhs->user->email }}</td>
            <td>{{ $mhs->kelas }}</td>
            <td>{{ $mhs->class->studyProgram->nama_prodi }}</td>
            <td>{{ $mhs->class->angkatan }}</td>
            <td><span class="btn btn-success">Aktif</span></td>
        </tr>
        @endforeach

    </tbody>
</table>

{{ $mahasiswa->links() }}


@endsection

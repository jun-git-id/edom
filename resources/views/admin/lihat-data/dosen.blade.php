@extends('layouts.master-admin')

@section('title','Lihat Data Dosen')

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
    <h1 class="h3 mb-0 text-gray-800">Lihat Data Dosen</h1>
</div>


<table class="table table-bordered table-striped table-hover">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nomor Induk</th>
            <th scope="col">Nama</th>
            <th scope="col">Email</th>
            <th scope="col">Prodi</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dosen as $dsn)
        <tr>
            <td>{{ $loop->iteration + $dosen->firstItem() - 1 }}</td>
            <td>{{ $dsn->nomor_induk }}</td>
            <td>{{ $dsn->nama }}</td>
            <td>{{ $dsn->user->email }}</td>
            <td>{{ $dsn->study_program->nama_prodi }}</td>
            <td> <a href="<?= url('/admin/hasil-evaluasi/dosen/dosen/' . $dsn->id) ?>"><i class="fas fa-search-plus"></i></a> </td>
        </tr>
        @endforeach

    </tbody>
</table>

{{ $dosen->links() }}


@endsection

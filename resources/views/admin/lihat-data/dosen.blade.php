@extends('layouts.master-admin')

@section('title','Lihat Data Dosen')

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
            <th scope="col">Prodi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dosen as $dsn)
        <tr>
            <td>{{ $loop->iteration + $dosen->firstItem() - 1 }}</td>
            <td>{{ $dsn->nomor_induk }}</td>
            <td>{{ $dsn->nama }}</td>
            <td>{{ $dsn->nama_prodi }}</td>
        </tr>
        @endforeach

    </tbody>
</table>

{{ $dosen->links() }}


@endsection

@extends('layouts.master-admin')

@section('title','Lihat Data Mahasiswa')

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
            <td>{{ $mhs->kelas }}</td>
            <td>{{ $mhs->nama_prodi }}</td>
            <td>{{ $mhs->angkatan }}</td>
            <td><span class="btn btn-success">Aktif</span></td>
        </tr>
        @endforeach

    </tbody>
</table>

{{ $mahasiswa->links() }}


@endsection

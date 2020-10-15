@extends('layouts.master-admin')

@section('title','Lihat Data Mata Kuliah')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Lihat Data Mata Kuliah</h1>
</div>


<table class="table table-bordered table-striped table-hover">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">Mata Kuliah</th>
            <th scope="col">Semester</th>
            <th scope="col">Prodi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($matkul as $mk)
        <tr>
            <td>{{ $loop->iteration + $matkul->firstItem() - 1 }}</td>
            <td>{{ $mk->nama_mk }}</td>
            <td>{{ $mk->semester }}</td>
            <td>{{ $mk->nama_prodi }}</td>
        </tr>
        @endforeach

    </tbody>
</table>

{{ $matkul->links() }}


@endsection

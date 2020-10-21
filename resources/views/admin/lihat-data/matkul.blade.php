@extends('layouts.master-admin')

@section('title','Lihat Data Mata Kuliah')

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

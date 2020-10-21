@extends('layouts.master-admin')

@section('title','Lihat Data Mahasiswa')

@section('search')
<form class="form-inline  navbar-search" action="" method="GET">
    <div class="input-group">
        <input name="s" type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
</form>
<form action="" method="GET" >
    <div class="form-inline">
        <div class="form-group">
            <label class=" mr-2" for="name">Tahun Akademik : </label>
            <select name="tahun_id" class="form-control" id="tahun_akademik">

            </select>
        </div>
        <button id="tampilkan-btn" class=" ml-2 btn btn-primary">Tampilkan</button>
    </div>
</form>

@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Lihat Data Mahasiswa</h1>
</div>

<p>
    <b>Tahun Akademik : {{ $tahun_akademik->tahun }} {{ $tahun_akademik->ganjil_genap }}</b>
</p>

<table class="table table-bordered table-striped table-hover">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Dosen</th>
            <th scope="col">Kelas</th>
            <th scope="col">Mata Kuliah</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ajaran as $ajr)
        <tr>
            <td>{{ $loop->iteration + $ajaran->firstItem() - 1 }}</td>
            <td>{{ $ajr->nama }}</td>
            <td>{{ $ajr->kelas }}</td>
            <td>{{ $ajr->nama_mk }}</td>
        </tr>
        @endforeach

    </tbody>
</table>

{{ $ajaran->links() }}


@endsection

@push('script')
<script>
    const url_ambil_thn = "<?= url('/api/get-thn_ak') ?>";

    tampilTahunAk(url_ambil_thn);
</script>

@endpush

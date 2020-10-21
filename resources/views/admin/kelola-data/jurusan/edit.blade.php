@extends('layouts.master-admin')

@section('title','Jurusan')

@section('content')
@error('nama_jurusan')
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@enderror
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Jurusan</h1>
</div>

<form action="<?= url('/admin/kelola-data/jurusan/' . $jurusan->id) ?>" method="post">
    @csrf
    @method('put')
    <div class="form-group">
        <label for="pert">Nama Jurusan</label>
        <input type="text" name="nama_jurusan" class="form-control" id="pert" value="{{ $jurusan->nama_jurusan }}">
    </div>
    <button type="submit" class="btn btn-primary">Oke</button>
</form>

@endsection

@push('script')
<script>
    /* const url = "<?= url('/api/ambil-jurusan') ?>";

    $.get(url, data => {
        tampilData(data);
    });

    const tampilData = data => {
        data.forEach(dt => {
            const el = `<a href="<?= url('/admin/hasil-evaluasi/mhs/jurusan/${dt.id}') ?>" class="list-group-item list-group-item-action">${dt.nama_jurusan}</a>`;
            $('#jurusan').append(el);
        });

    }; */
</script>


@endpush

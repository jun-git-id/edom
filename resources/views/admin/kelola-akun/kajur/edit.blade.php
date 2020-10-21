@extends('layouts.master-admin')

@section('title','Akun Kajur')

@section('content')
@error('username')
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@enderror
@error('nama')
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@enderror
@error('email')
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@enderror
@error('ttd')
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@enderror
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Akun Kajur</h1>
</div>

<form action="<?= url('/admin/kelola-akun/kajur/' . $kajur->id) ?>" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <input type="hidden" name="ttd" value="{{ $kajur->ttd }}" >
    <div class="form-group">
        <label for="pert">Username</label>
        <input type="text" name="username" class="form-control" id="pert" value="{{ $kajur->user->username }}">
    </div>
    <div class="form-group">
        <label for="pert">Nama</label>
        <input type="text" name="nama" class="form-control" id="pert" value="{{ $kajur->nama }}">
    </div>
    <div class="form-group">
        <label for="pert">Email</label>
        <input type="email" name="email" class="form-control" id="pert" value="{{ $kajur->user->email }}">
    </div>
    <div class="form-group">
        <label for="aspek">Jurusan</label>
        <select class="form-control" name="jurusan_id" id="aspek">
            @foreach($jurusan as $jur)
            <option value="{{ $jur->id }}" @if($kajur->jurusan_id == $jur->id) selected @endif >{{ $jur->nama_jurusan }}</option>
            @endforeach

        </select>
    </div>
    <div class="form-group">
        <label for="pert">Gambar Tanda Tangan</label>
        <input type="file" name="ttd" class="form-control" id="pert">
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

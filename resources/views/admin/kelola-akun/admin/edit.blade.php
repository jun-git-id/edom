@extends('layouts.master-admin')

@section('title','Akun Admin')

@section('content')
<!-- Page Heading -->
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
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Akun Admin</h1>
</div>

<form action="<?= url('/admin/kelola-akun/admin/' . $admin->id) ?>" method="post">
    @csrf
    @method('put')
    <div class="form-group">
        <label for="pert">Username</label>
        <input type="text" name="username" class="form-control" id="pert" value="{{ $admin->user->username }}">
    </div>
    <div class="form-group">
        <label for="pert">Nama</label>
        <input type="text" name="nama" class="form-control" id="pert" value="{{ $admin->nama }}">
    </div>
    <div class="form-group">
        <label for="pert">Email</label>
        <input type="email" name="email" class="form-control" id="pert" value="{{ $admin->user->email }}">
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

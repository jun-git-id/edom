@extends('layouts.master-admin')

@section('title','Tahun Akademik')

@section('content')
@error('tahun')
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@enderror
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tahun Akademik</h1>
</div>

<form action="<?= url('/admin/kelola-data/tahun-akademik/' . $tahun_akademik->id) ?>" method="post">
    @csrf
    @method('put')
    <div class="form-group">
        <label for="pert">Tahun Akademik</label>
        <input type="text" name="tahun" class="form-control" id="pert" value="{{ $tahun_akademik->tahun }}">
    </div>
    <div class="form-group">
        <select class="form-control" name="ganjil_genap" id="aspek">
            <option value="ganjil" @if( $tahun_akademik->ganjil_genap == 'ganjil') selected @endif >Ganjil</option>
            <option value="genap" @if( $tahun_akademik->ganjil_genap == 'genap') selected @endif >Genap</option>
        </select>
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

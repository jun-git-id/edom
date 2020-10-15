@extends('layouts.master-admin')

@section('title','Kompetensi Kuisioner')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kompetensi Kuisioner</h1>
</div>

<form action="<?= url('/admin/kuisioner/kompetensi/'.$kompetensi->id) ?>" method="post">
    @csrf
    @method('put')
    <div class="form-group">
        <label for="aspek">Aspek Kompetensi</label>
        <input type="text" name="aspek" class="form-control" id="aspek" value="{{ $kompetensi->aspek_kompetensi }}">
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

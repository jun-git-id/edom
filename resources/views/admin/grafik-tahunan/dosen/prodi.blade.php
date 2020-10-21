@extends('layouts.master-admin')

@section('title','Hasil Evaluasi Dosen')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">

        <li class="breadcrumb-item"><a href="#">Jurusan</a></li>
        <li class="breadcrumb-item"><a href="#">Prodi</a></li>

    </ol>
</nav>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Hasil Evaluasi Dosen</h1>
</div>
<br><br>

<div class="list-group" id="prodi">
</div>




@endsection

@push('script')
<script>
    const url = "<?= url('/api/ambil-dosen/' . $prodi_id) ?>";

    $.get(url, data => {
        tampilData(data);
    });

    const tampilData = data => {
        const el = `<button type="button" class="list-group-item list-group-item-action active">
                        Dosen pada Prodi ${data.prodi.nama_prodi}
                    </button>`;
        $('#prodi').append(el);

        data.dosen.forEach(dt => {
            const el = `<a href="<?= url('/admin/grafik-tahunan/dosen/dosen/${dt.id}') ?>" class="list-group-item list-group-item-action">${dt.nomor_induk} ${dt.nama}</a>`;
            $('#prodi').append(el);
        });

    };
</script>


@endpush

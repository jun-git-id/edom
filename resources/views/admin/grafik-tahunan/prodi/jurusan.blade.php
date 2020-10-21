@extends('layouts.master-admin')

@section('title','Hasil Evaluasi Dosen')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">

        <li class="breadcrumb-item"><a href="#">Jurusan</a></li>

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
    const url = "<?= url('/api/ambil-prodi/' . $jurusan_id) ?>";

    $.get(url, data => {
        tampilData(data);
    });

    const tampilData = data => {
        const el = `<button type="button" class="list-group-item list-group-item-action active">
                        Prodi pada Jurusan ${data.jurusan.nama_jurusan}
                    </button>`;
        $('#prodi').append(el);

        data.prodi.forEach(dt => {
            const el = `<a href="<?= url('/admin/grafik-tahunan/prodi/prodi/${dt.id}') ?>" class="list-group-item list-group-item-action">${dt.nama_prodi}</a>`;
            $('#prodi').append(el);
        });

    };
</script>


@endpush

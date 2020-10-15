@extends('layouts.master-admin')

@section('title','Hasil Evaluasi Mahasiswa')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Mahasiswa</a></li>
        <li class="breadcrumb-item"><a href="#">Jurusan</a></li>
        <li class="breadcrumb-item"><a href="#">Prodi</a></li>
    </ol>
</nav>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Hasil Evaluasi Mahasiswa</h1>
</div>
<br><br>

<div class="list-group" id="angkatan">

</div>




@endsection

@push('script')
<script>
    const url = "<?= url('/api/ambil-angkatan/' . $prodi_id) ?>";

    $.get(url, data => {
        tampilData(data);
    });

    const tampilData = data => {
        const el = `<button type="button" class="list-group-item list-group-item-action active">
                        Prodi pada Jurusan ${data.prodi.nama_prodi}
                    </button>`;
        $('#angkatan').append(el);

        const prodi_id = data.prodi.id;
        data.angkatan.forEach(dt => {
            const el = `<a href="<?= url('/admin/hasil-evaluasi/mhs/angkatan/${prodi_id}/${dt.angkatan}') ?>" class="list-group-item list-group-item-action">${dt.angkatan}</a>`;
            $('#angkatan').append(el);
        });

    };
</script>


@endpush

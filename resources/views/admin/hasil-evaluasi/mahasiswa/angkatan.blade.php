@extends('layouts.master-admin')

@section('title','Hasil Kuisioner Mahasiswa')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Mahasiswa</a></li>
        <li class="breadcrumb-item"><a href="#">Jurusan</a></li>
        <li class="breadcrumb-item"><a href="#">Prodi</a></li>
        <li class="breadcrumb-item"><a href="#">Angkatan</a></li>
    </ol>
</nav>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Hasil Evaluasi Mahasiswa</h1>
</div>
<br><br>

<div class="list-group" id="kelas">
</div>




@endsection

@push('script')
<script>
    const url = "<?= url('/api/ambil-kelas/' . $prodi_id .'/'. $angkatan) ?>";

    $.get(url, data => {
        tampilData(data);
    });

    const tampilData = data => {
        const el = `<button type="button" class="list-group-item list-group-item-action active">
                        Kelas pada ${data.prodi.nama_prodi}  angkatan ${data.angkatan}
                    </button>`;
        $('#kelas').append(el);

        data.kelas.forEach(dt => {
            const el = `<a href="<?= url('/admin/hasil-evaluasi/mhs/kelas/${dt.id}') ?>" class="list-group-item list-group-item-action">${dt.kelas}</a>`;
            $('#kelas').append(el);
        });

    };
</script>


@endpush

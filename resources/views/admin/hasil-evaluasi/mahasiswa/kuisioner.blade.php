@extends('layouts.master-admin')

@section('title','Hasil Evaluasi Mahasiswa')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Mahasiswa</a></li>
        <li class="breadcrumb-item"><a href="#">Jurusan</a></li>
        <li class="breadcrumb-item"><a href="#">Prodi</a></li>
        <li class="breadcrumb-item"><a href="#">Angkatan</a></li>
        <li class="breadcrumb-item"><a href="#">Kelas</a></li>
        <li class="breadcrumb-item"><a href="#">Mahasiswa</a></li>
        <li class="breadcrumb-item"><a href="#">Kuisioner</a></li>
    </ol>
</nav>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Hasil Evaluasi Mahasiswa</h1>
</div>

<div class="card">
    <div class="card-header py-3">
        <div id="info">

        </div>

        <br>
    </div>
    <div class="card-body">
        <div class="row" id="keterangan">

        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Aspek Penialian</th>
                    <th scope="col">Kompetensi</th>
                    <th scope="col">Nilai</th>
                </tr>
            </thead>
            <tbody id="pertanyaan">

            </tbody>
        </table>


        <br>
        <br>
        <div class="alert alert-warning" role="alert">
            <span class=" font-weight-bold">Komentar : </span>
            <br>
            <span id="komentar">

            </span>
        </div>
        <br>
        <br><br>
        <br>
        <br>


    </div>
</div>




@endsection

@push('script')
<script>
    const url = "<?= url('/api/admin/hasil-evaluasi/mhs/kuisioner/'. $pengisian_id) ?>";

    $.get(url, data => {
        tampilData(data);
    });

    const tampilData = data => {
        const el = `<h6>NIM : ${data.info.nim}</h6>
                    <h6>Nama Mahasiswa : ${data.info.nama_mhs}</h6>
                    <h6>Kelas : ${data.info.kelas}</h6>
                    <br>
                    <h6>Ni Dosen : ${data.info.nomor_induk}</h6>
                    <h6>Nama Dosen : ${data.info.nama_dosen}</h6>
                    <h6>MatKul : ${data.info.nama_mk}</h6>
                    <br>
                    <h6>Tahun Ajaran : ${data.info.thn_ak}</h6>`
        $('#info').append(el);

        let i = 1;
        data.kuisioner.forEach(dt => {
            const el = `<tr>
                            <td>${i}</td>
                            <td>${dt.pertanyaan}</td>
                            <td>${dt.kompetensi}</td>
                            <td>${dt.nilai}</td>
                        </tr>`;
            $('#pertanyaan').append(el);

            i++;
        });

        $('#komentar').text(data.info.komentar);

    };
</script>


@endpush

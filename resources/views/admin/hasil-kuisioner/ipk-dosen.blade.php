@extends('layouts.master-admin')

@section('title','Detail Evaluasi Kinerja Dosen')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Evaluasi Kinerja Dosen</h1>
    <div>
        <a href="/chart" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-chart-bar fa-sm text-white-50"></i> Tampilan Grafik</a>
        <a href="<?= url('/pdf/table') ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-file-pdf fa-sm text-white-50"></i> Export to pdf</a>
    </div>

</div>

<div class="card">
    <div class="card-body">
        <div class="row" id="keterangan-dosen">

        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Mata Kuliah</th>
                    <th scope="col">Jumlah Mahasiswa</th>
                    <th scope="col">IPD</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody id="kelas">

            </tbody>
        </table>

        <div class="text font-weight-bold float-right" id="keterangan-dosen-2">

        </div>

        <br>
        <br>
        <br>
        <br> <br>
        <br>
        <br>
        <div style="max-width: 80%;">
            <div class="float-left">
                Ketua LPM STMIK Mataram,
            </div>
            <div class=" float-right">
                Mataram, 18 Oktober 2018 <br>
                Ketua STMIK Mataram,
            </div>
        </div>
        <br>
        <br>
        <br>
        <br><br>
        <br>
        <br>


    </div>
</div>


@endsection

@push('script')
<script>
    const url = "<?= url('/api/admin/hasil-evaluasi/dosen-per-kelas') ?>"
    $.get(url, function(data, textStatus, jqXHR) {
        tampilData(data.data)
    });

    const tampilData = data => {
        const el_dos = `<div class="col-md">
                <table class="table table-borderless">
                    <tr>
                        <td>NIK Dosen</td>
                        <td>: <b>${data.nik}</b></td>
                    </tr>
                    <tr>
                        <td>Nama Dosen</td>
                        <td>: <b>${data.nama}</b></td>
                    </tr>
                </table>
            </div>
            <div class="col-md">
                <table class="table table-borderless">
                    <tr>
                        <td>Tahun Akademik</td>
                        <td>: <b>${data.tahun_akademik}</b></td>
                    </tr>
                </table>
            </div>`;
        $('#keterangan-dosen').append(el_dos);


        data.data_per_kelas.forEach( dt => {
            const el_kls = `<tr>
                    <th scope="row">1</th>
                    <td>${dt.kelas}</td>
                    <td>${dt.matkul}</td>
                    <td>${dt.jml_mhs}</td>
                    <td>${dt.ipd}</td>
                    <td>${dt.keterangan}</td>
                </tr>`;

            $('#kelas').append(el_kls);
        });

        const el_ket = `<p>IPK Dosen Semester ini : ${data.ipk}</p>
            <p>Kesimpulan Akhir : ${data.kesimpulan}</p>`;

            $('#keterangan-dosen-2').append(el_ket);





    }
</script>


@endpush

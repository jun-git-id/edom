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
        <div class="row" id="keterangan">

        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Aspek Penialian</th>
                    <th scope="col">IPD</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody id="pertanyaan">

            </tbody>
        </table>


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
    const url = "<?= url('/api/admin/hasil-evaluasi/dosen-kelas/60/29/22') ?>"
    $.get(url, function(data, textStatus, jqXHR) {
        tampilData(data.data)
    });

    const tampilData = data => {
        const el_ket = `<div class="col-md">
                <table class="table table-borderless">
                    <tr>
                        <td>NIK Dosen</td>
                        <td>: <b>${data.nik}</b></td>
                    </tr>
                    <tr>
                        <td>Nama Dosen</td>
                        <td>: <b>${data.nama_dosen}</b></td>
                    </tr>
                    <tr>
                        <td>Tahun Akademik</td>
                        <td>: <b>${data.tahun_akademik}</b></td>
                    </tr>
                </table>
            </div>
            <div class="col-md">
                <table class="table table-borderless">
                    <tr>
                        <td>Mata Kuliah</td>
                        <td>: <b>${data.matkul}</b></td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>: <b>${data.kelas}</b></td>
                    </tr>
                    <tr>
                        <td>Mahasiswa Responden</td>
                        <td>: <b>${data.responden}</b></td>
                    </tr>

                </table>
            </div>`;

            $('#keterangan').append(el_ket);


            data.pertanyaanFinal.forEach(dt => {
                const el_pert = `<tr>
                    <th scope="row">1</th>
                    <th>${dt.pertanyaan}</th>
                    <td>${dt.ipd}</td>
                    <td>${dt.kesimpulan}</td>
                </tr>`;

                $('#pertanyaan').append(el_pert);
            });
    }
</script>

@endpush

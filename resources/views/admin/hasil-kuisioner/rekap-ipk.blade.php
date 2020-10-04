@extends('layouts.master-admin')

@section('title','Rekap IPK Dosen STMIK Mataram 2017-2')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Rekap IPK Dosen STMIK Mataram 2017-2</h1>
    <div>
        <a href="/chart" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-chart-bar fa-sm text-white-50"></i> Tampilan Grafik</a>
        <a href="<?= url('/pdf/table') ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-file-pdf fa-sm text-white-50"></i> Export to pdf</a>
    </div>

</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">NIK</th>
                    <th scope="col">Nama Dosen</th>
                    <th scope="col">Jumlah Kelas</th>
                    <th scope="col">IPK</th>
                    <th scope="col">Kesimpulan Akhir</th>
                </tr>
            </thead>
            <tbody id="tempat-data">
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
    const url = "<?= url('/api/admin/hasil-evaluasi/per-dosen') ?>"
    $.get(url, function(data, textStatus, jqXHR) {
        tampilData(data.data)
    });

    const tampilData = data => {

        data.forEach(dt => {
            const el = `<tr>
                    <th scope="row">1</th>
                    <th>${dt.nik}</th>
                    <th>${dt.nama}</th>
                    <td>${dt.jumlah_kelas}</td>
                    <td>${dt.ipk}</td>
                    <td>${dt.kesimpulan}</td>
                </tr>`;
            $('#tempat-data').append(el);
        });
    }
</script>

@endpush

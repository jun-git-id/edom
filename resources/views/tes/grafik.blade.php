@extends('layouts.master-admin')

@section('title','SB Admin 2 - Blank')

@section('content')



    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Evaluasi Kinerja Dosen</h1>
        <div>
            <a href="/table" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-table fa-sm text-white-50"></i> Tampilan Tabel</a>
            <a href="/pdf/chart" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-file-pdf fa-sm text-white-50"></i> Export to pdf</a>
        </div>

    </div>


    <!-- Bar Chart -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <p>Nama Dosen : XXX</p>
            <p>Tahun Akademik : 2020-Genap</p>
        </div>
        <div class="card-body">
            <div class="chart-bar">
                <canvas id="myBarChart"></canvas>
            </div>
            <hr>
            Styling for the bar chart can be found in the <code>/js/demo/chart-bar-demo.js</code> file.
        </div>
    </div>



@endsection


@push('script')
<script src="<?= url('/template-admin/vendor/chart.js/Chart.min.js') ?>"></script>
<script src="<?= url('/template-admin/js/demo/chart-bar-demo.js') ?>"></script>
@endpush


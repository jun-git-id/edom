@extends('layouts.master-admin')

@section('title','Hasil Evaluasi Dosen')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dosen</a></li>
        <li class="breadcrumb-item"><a href="#">Jurusan</a></li>
        <li class="breadcrumb-item"><a href="#">Prodi</a></li>
        <li class="breadcrumb-item"><a href="#">Dosen</a></li>
    </ol>
</nav>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Hasil Evaluasi Dosen</h1>
    <div>

    </div>

</div>

<div class="card">
    <div class="card-header py-3">
        <div id="info">

        </div>
        <br>

        <form>
            <div class="form-inline">
                <div class="form-group">
                    <label class=" mr-2" for="name">Tahun Akademik : </label>
                    <select name="" class="form-control" id="tahun_akademik">

                    </select>
                </div>
                <button id="tampilkan-btn" class=" ml-2 btn btn-primary">Tampilkan</button>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="row" id="keterangan">

        </div>
        <div class="chart-bar">
            <canvas id="myBarChart"></canvas>
        </div>
        <hr>


        <br>
        <br>
        <br> <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div style="display: flex; justify-content: flex-end" class=" mr-5">
            <table class=" font-weight-bold" id="rata2">

            </table>
        </div>
        <br><br>
        <br>
        <br>


    </div>
</div>




@endsection

@push('script')
<script src="<?= url('/template-admin/vendor/chart.js/Chart.min.js') ?>"></script>
<script src="<?= url('/js/chart-obj.js') ?>"></script>
<script>
    const label_gr = ['2012', '2013'];
    const data_gr = [2,3];
    buatGrafikLine(label_gr, data_gr);
</script>


@endpush

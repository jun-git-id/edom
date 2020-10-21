@extends('layouts.master-admin')

@section('title','Hasil Evaluasi Dosen')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" id="breadcrumb">


    </ol>
</nav>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800" id="judul">Hasil Evaluasi Dosen</h1>
    <div>
        <a id="pdf-button" target="_blank" href="<?= url('/pdf/table') ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-file-pdf fa-sm text-white-50"></i> Export to pdf</a>
    </div>

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
        <div class="chart-bar">
            <canvas id="myBarChart"></canvas>
        </div>
        <hr>
        <div id="preloader">
            <br><br>
            <div class="text-center">
                <div class="spinner-border text-warning" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>


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
<script>
    const url = '<?=  $url ?>';


    $.get(url, data => {
        $('#preloader').css('display', 'none');
        tampilData(data);
    });

    const tampilData = data => {

        //################################################################################
        data.nav.forEach(dt => {
            const el = `<li class="breadcrumb-item"><a href="#">${dt}</a></li>`;
            $('#breadcrumb').append(el);
        });
        $('#pdf-button').attr('href',data.pdf_link);
        $('#judul').text(data.title);


        data.info1.forEach(dt => {
            const el = `<h6> ${dt.name} : ${dt.value} </h6>`;
            $('#info').append(el);
        });


        label_arr = [];
        data_arr = [];
        data.nilai.forEach(dt => {
            label_arr.push(dt.tahunFinal);
            data_arr.push(dt.nilai);
        });

        buatGrafikLine(label_arr, data_arr);





    };
</script>


@endpush

@extends('layouts.master-dosen')

@section('title','Hasil Evaluasi Dosen')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Hasil Evaluasi Dosen</h1>
    <div>
        <a href="<?= url('/dosen/hasil-evaluasi/dosen/ajaran/' . $ajaran_id) ?>" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-table fa-sm text-white-50"></i> Tampilan Tabel</a>
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
        <div style="overflow: scroll">
            <div class="chart-bar" style="width: 100em; height:50em;">
                <canvas id="myBarChart"></canvas>
            </div>
            <hr>
        </div>

        <div id="komentar" class=" mt-4" style="display: none;">

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
<script src="<?= url('/js/chart-obj.js') ?>"></script>
<script>
    const url = "<?= url('/api/admin/hasil-evaluasi/dosen/ajaran/' . $ajaran_id) ?>";
    const url_kom = "<?= url('/api/admin/hasil-evaluasi/dosen/ajaran-komentar/' . $ajaran_id) ?>";

    $.get(url, data => {
        tampilData(data);
    });
    $.get(url_kom, data => {
        tampilDataKom(data);
    });

    const tampilData = data => {
        const el = `<h6>Nomor Induk : ${data.info.nomor_induk} </h6>
                    <h6>Nama Dosen : ${data.info.nama_dosen}</h6>
                    <br>
                    <br>
                    <h6>Matkul : ${data.info.matkul}</h6>
                    <h6>Kelas : ${data.info.kelas}</h6>
                    <h6>Jumlah Responden : ${data.info.jml_responden} Orang</h6>
                    <br>
                    <h6>Tahun Ajaran : ${data.info.thn_ak}</h6>`
        $('#info').append(el);

        let i = 1;
        let arr = [];
        let label_gr = [];
        let data_gr = [];
        data.pertanyaan.forEach(dt => {
            const el = `<tr>
                    <td>${i}</td>
                    <td>${dt.pertanyaan}</td>
                    <td>${dt.kompetensi}</td>
                    <td>${ toPersen(dt.nilai) }</td>
                    <td>${ambilKesimpulan(dt.nilai)}</td>
                </tr>`;
            $('#pertanyaan').append(el);

            i++;
            arr.push(parseFloat(dt.nilai));
            label_gr.push(dt.pertanyaan);
            data_gr.push(dt.nilai);
        });


        const el2 = `<tr>
                        <td>Rata - rata</td>
                        <td>: ${toPersen(average(arr))}</td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>: ${ambilKesimpulan(average(arr))}</td>
                    </tr>`;

        $('#rata2').append(el2);
        buatGrafikBar(label_gr, data_gr);

        $('#pdf-button').attr('href',`<?= url('/dosen/hasil-evaluasi/dosen/ajaran/' . $ajaran_id . '/pdf?grafik=yes') ?>`);

    };

    const tampilDataKom = data => {
        data.forEach(dt => {
            const el = `<div class="alert alert-${randomWarna()}" role="alert">
                ${dt.komentar}
            </div>`;
            $('#komentar').append(el);
        });
    }


    $('#komentar-button').click(function(e) {
        e.preventDefault();
        $('#table, #komentar, #pertanyaan-text, #komentar-text').toggle();

    });
</script>


@endpush

@extends('layouts.master-admin')

@section('title','Hasil Evaluasi Dosen')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Matkul</a></li>
        <li class="breadcrumb-item"><a href="#">Jurusan</a></li>
        <li class="breadcrumb-item"><a href="#">Prodi</a></li>

    </ol>
</nav>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Hasil Evaluasi Dosen</h1>
    <div>
        <a href="<?= url('/admin/hasil-evaluasi/dosen/prodi/'. $prodi_id) ?>" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-table fa-sm text-white-50"></i> Tampilan Tabel</a>
        <a id="pdf-button" target="_blank" href="<?= url('/admin/hasil-evaluasi/dosen/prodi/'. $prodi_id) ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-file-pdf fa-sm text-white-50"></i> Export to pdf</a>
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



        <br>
        <br>
        <br>
        <br>
        <br><br><br>
        <div style="display: flex; justify-content: flex-end" class=" mr-5">
            <table class=" font-weight-bold" id="rata2">

            </table>
        </div>


        <br>
        <br>
    </div>
</div>



@endsection

@push('script')
<script src="<?= url('/template-admin/vendor/chart.js/Chart.min.js') ?>"></script>
<script src="<?= url('/js/chart-obj.js') ?>"></script>
<script>
    const url = "<?= url('/api/admin/hasil-evaluasi/dosen/prodi/' . $prodi_id) ?>";

    const url_ambil_thn = "<?= url('/api/get-thn_ak') ?>";

    tampilTahunAk(url_ambil_thn);
    $('#tampilkan-btn').click(e => {
        e.preventDefault();
        $('#info').text('');
        $('#dosen').text('');
        $('#rata2').text('');
        $('#preloader').css('display', '');
        $('canvas').remove();
        $('.chart-bar').append(`<canvas id="myBarChart"></canvas>`);



        const thn_id = $('#tahun_akademik').find(":selected").attr('value');
        const url2 = `<?= url('/api/admin/hasil-evaluasi/dosen/prodi/' . $prodi_id . '?tahun_id=${thn_id}') ?>`;
        $.get(url2, data => {
            $('#preloader').css('display', 'none');
            tampilData(data);
        });

    });

    $.get(url, data => {
        $('#preloader').css('display', 'none');
        tampilData(data);
    });

    const tampilData = data => {
        const el = `<h4>Prodi ${data.prodi.nama_prodi}</h4>`;
        $('#info').append(el);

        let i = 1;
        let arr = [];
        let label_gr = [];
        let data_gr = [];
        data.dosen.forEach(dt => {
            const el = `<tr>
                    <td>${i}</td>
                    <td>${dt.nomor_induk}</td>
                    <td>${dt.nama}</td>
                    <td>${dt.jml_kelas}</td>
                    <td>${ toPersen(dt.nilai) }</td>
                    <td>${ambilKesimpulan(dt.nilai)}</td>
                    <td> <a href="<?= url('/admin/hasil-evaluasi/dosen/dosen/${dt.id}') ?>"><i class="fas fa-search-plus" ></i></a> </td>
                </tr>`;
            $('#dosen').append(el);

            i++;
            arr.push(parseFloat(dt.nilai));
            label_gr.push(dt.nama);
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

        $('#pdf-button').attr('href',`<?= url('/admin/hasil-evaluasi/dosen/prodi/' . $prodi_id . '/pdf?tahun_id=${data.tahun_id}&grafik=yes') ?>`);

    };
</script>



@endpush

@extends('layouts.master-kajur')

@section('title','Hasil Evaluasi Dosen')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dosen</a></li>
        <li class="breadcrumb-item"><a href="#">Jurusan</a></li>
        <li class="breadcrumb-item"><a href="#">Prodi</a></li>
        <li class="breadcrumb-item"><a href="#">Dosen</a></li>
        <li class="breadcrumb-item"><a href="#">Ajaran</a></li>
    </ol>
</nav>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Hasil Evaluasi Dosen</h1>
    <div>
        <a id="komentar-button" href="#" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-chart-bar fa-sm text-white-50"></i>
            <span id="pertanyaan-text">Komentar</span>
            <span id="komentar-text" style="display: none;">Pertanyaan</span>
        </a>
        <a target="_blank" id="pdf-button" href="<?= url('/pdf/table') ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-file-pdf fa-sm text-white-50"></i> Export to pdf</a>
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
        <table id="table" class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Aspek Penialian</th>
                    <th scope="col">Kompetensi</th>
                    <th scope="col">Nilai</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody id="pertanyaan">

            </tbody>
        </table>

        <div id="komentar" class=" mt-4" style="display: none;">

        </div>

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
<script>
    const url = "<?= url('/api/admin/hasil-evaluasi/dosen/ajaran/' . $ajaran_id) ?>";
    const url_kom = "<?= url('/api/admin/hasil-evaluasi/dosen/ajaran-komentar/' . $ajaran_id) ?>";

    $.get(url, data => {
        $('#preloader').css('display', 'none');
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

        $('#pdf-button').attr('href',`<?= url('/kajur/hasil-evaluasi/dosen/ajaran/' . $ajaran_id . '/pdf') ?>`);

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

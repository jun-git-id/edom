@extends('layouts.master-kajur')

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
        <a href="<?= url('/kajur/hasil-evaluasi/dosen/dosen/' . $dosen_id) ?>" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-table fa-sm text-white-50"></i> Per Kelas</a>
        <a  target="_blank" id="pdf-button" href="<?= url('/pdf/table') ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-file-pdf fa-sm text-white-50"></i> Export to pdf</a>
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
        <table class="table table-bordered table-striped table-hover">
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
    const url = "<?= url('/api/admin/hasil-evaluasi/dosen/dosen_pert/' . $dosen_id) ?>";

    const url_ambil_thn = "<?= url('/api/get-thn_ak') ?>";

        tampilTahunAk(url_ambil_thn);
        $('#tampilkan-btn').click(e => {
            e.preventDefault();
            $('#preloader').css('display', '');



            const thn_id = $('#tahun_akademik').find(":selected").attr('value');
            const url2 = `<?= url('/api/admin/hasil-evaluasi/dosen/dosen_pert/' . $dosen_id . '?tahun_id=${thn_id}') ?>`;
            $.get(url2, data => {
                $('#info').text('');
                $('#pertanyaan').text('');
                $('#rata2').text('');
                tampilData(data);
                $('#preloader').css('display', 'none');
                //console.log(data);
            });

        });

    $.get(url, data => {
        $('#preloader').css('display', 'none');
        tampilData(data);
    });

    const tampilData = data => {
        const el = `<h6>Nomor Induk : ${data.dosen.nomor_induk} </h6>
                    <h6>Nama Dosen : ${data.dosen.nama}</h6>`;
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

        $('#pdf-button').attr('href',`<?= url('/kajur/hasil-evaluasi/dosen/dosen-pert/' . $dosen_id . '/pdf?tahun_id=${data.tahun_id}') ?>`);

    };
</script>


@endpush

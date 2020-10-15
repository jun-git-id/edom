@extends('layouts.master-admin')

@section('title','Hasil Evaluasi Mata Kuliah')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dosen</a></li>
        <li class="breadcrumb-item"><a href="#">Jurusan</a></li>
        <li class="breadcrumb-item"><a href="#">Prodi</a></li>
    </ol>
</nav>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Hasil Evaluasi Matkul</h1>
    <div>
        <a href="/chart" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-chart-bar fa-sm text-white-50"></i> Tampilan Grafik</a>
        <a href="<?= url('/pdf/table') ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-file-pdf fa-sm text-white-50"></i> Export to pdf</a>
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
                    <th scope="col">Nama Matkul</th>
                    <th scope="col">Jumlah Dosen</th>
                    <th scope="col">Nilai</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="matkul">
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
    const url = "<?= url('/api/admin/hasil-evaluasi/matkul/prodi/' . $prodi_id) ?>";

    const url_ambil_thn = "<?= url('/api/get-thn_ak') ?>";

    tampilTahunAk(url_ambil_thn);
    $('#tampilkan-btn').click(e => {
        e.preventDefault();



        const thn_id = $('#tahun_akademik').find(":selected").attr('value');
        const url2 = `<?= url('/api/admin/hasil-evaluasi/matkul/prodi/' . $prodi_id . '?tahun_id=${thn_id}') ?>`;
        $.get(url2, data => {
            $('#info').text('');
            $('#matkul').text('');
            //$('#rata2').text('');
            tampilData(data);
            //console.log(data);
        });

    });

    $.get(url, data => {
        tampilData(data);
    });

    const tampilData = data => {
        const el = `<h4>Prodi ${data.prodi.nama_prodi}</h4>`;
        $('#info').append(el);

        let i = 1;
        data.matkul.forEach(dt => {
            const el = `<tr>
                            <td>${i}</td>
                            <td>${dt.nama_mk}</td>
                            <td>${dt.jml_dosen}</td>
                            <td>${dt.nilai}</td>
                            <td>${ambilKesimpulan(dt.nilai)}</td>
                            <td> <a href="<?= url('/admin/hasil-evaluasi/matkul/matkul/${dt.id}') ?>"><i class="fas fa-search-plus"></i></a> </td>
                        </tr>`;
            $('#matkul').append(el);

            i++;
        });

    };
</script>


@endpush

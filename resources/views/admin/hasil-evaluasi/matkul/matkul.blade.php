@extends('layouts.master-admin')

@section('title','Hasil Evaluasi Mata Kuliah')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dosen</a></li>
        <li class="breadcrumb-item"><a href="#">Jurusan</a></li>
        <li class="breadcrumb-item"><a href="#">Prodi</a></li>
        <li class="breadcrumb-item"><a href="#">Matkul</a></li>
    </ol>
</nav>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Hasil Evaluasi Matkul</h1>
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

        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ni Dosen</th>
                    <th scope="col">Nama Dosen</th>
                    <th scope="col">Nilai</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="dosen">
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
        <br><br>
        <br>
        <br>


    </div>
</div>




@endsection

@push('script')
<script>
    const url = "<?= url('api/admin/hasil-evaluasi/matkul/matkul/' . $matkul_id) ?>";

    const url_ambil_thn = "<?= url('/api/get-thn_ak') ?>";

    tampilTahunAk(url_ambil_thn);
    $('#tampilkan-btn').click(e => {
        $('#preloader').css('display', '');
        e.preventDefault();



        const thn_id = $('#tahun_akademik').find(":selected").attr('value');
        const url2 = `<?= url('api/admin/hasil-evaluasi/matkul/matkul/' . $matkul_id . '?tahun_id=${thn_id}') ?>`;
        $.get(url2, data => {
            $('#info').text('');
            $('#dosen').text('');
            //$('#rata2').text('');
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
        const el = `<h4>Daftar Dosen yang mengajar mata kuliah ${data.matkul} pada ${data.prodi}</h4>`;
        $('#info').append(el);

        let i = 1;
        data.dosen.forEach(dt => {
            const el = `<tr>
                            <td>${i}</td>
                            <td>${dt.nomor_induk}</td>
                            <td>${dt.nama}</td>
                            <td>${ toPersen(dt.nilai) }</td>
                            <td>${ambilKesimpulan(dt.nilai)}</td>
                            <td> <a href="<?= url('/admin/hasil-evaluasi/dosen/dosen/${dt.id}') ?>"><i class="fas fa-search-plus"></i></a> </td>
                        </tr>`;
            $('#dosen').append(el);
        });

    };
</script>


@endpush

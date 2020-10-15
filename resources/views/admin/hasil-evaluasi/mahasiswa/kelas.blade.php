@extends('layouts.master-admin')

@section('title','Hasil Evaluasi Mahasiswa')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Mahasiswa</a></li>
        <li class="breadcrumb-item"><a href="#">Jurusan</a></li>
        <li class="breadcrumb-item"><a href="#">Prodi</a></li>
        <li class="breadcrumb-item"><a href="#">Angkatan</a></li>
        <li class="breadcrumb-item"><a href="#">Kelas</a></li>
    </ol>
</nav>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Hasil Evaluasi Mahasiswa</h1>
</div>

<div class="card">
    <div class="card-header py-3">
        <div id="informasi">

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
                    <th scope="col">NIm</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Nilai</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="mahasiswa">

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
    $(document).ready(function() {
        const url = "<?= url('/api/admin/hasil-evaluasi/mhs/kelas/' . $kelas_id) ?>";


        const url_ambil_thn = "<?= url('/api/get-thn_ak') ?>";

        tampilTahunAk(url_ambil_thn);
        $('#tampilkan-btn').click(e => {
            e.preventDefault();



            const thn_id = $('#tahun_akademik').find(":selected").attr('value');
            const url2 = `<?= url('/api/admin/hasil-evaluasi/mhs/kelas/' . $kelas_id . '?tahun_id=${thn_id}') ?>`;
            $.get(url2, data => {
                //$('#mahasiswa').text('');
                //tampilData(data);
                console.log(url2);
            });

        });



        $.get(url, data => {
            tampilData(data);
        });

        const tampilData = data => {
            const el = `<h4>Mahasiswa kelas ${data.kelas}</h4>`;
            $('#informasi').append(el);

            let i = 1;
            data.mhs.forEach(dt => {
                const el = `<tr>
                    <td>${i}</td>
                    <td>${dt.nim}</td>
                    <td>${dt.nama}</td>
                    <td>${dt.nilai}</td>
                    <td>${ambilKesimpulan(dt.nilai)}</td>
                    <td> <a href="<?= url('/admin/hasil-evaluasi/mhs/mhs/${dt.id}') ?>"><i class="fas fa-search-plus" ></i></a> </td>
                </tr>`;
                $('#mahasiswa').append(el);

                i++;
            });

        };
    });
</script>


@endpush

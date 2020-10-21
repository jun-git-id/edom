@extends('layouts.master-mhs')

@section('title','SB Admin 2 - Blank')

@section('content')
<!-- Page Heading -->

<center>
    <div class="card mb-5" style="max-width: 60em;">
        <div class="card-header">
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
            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <h1 id="info" class="h3 mb-4 text-gray-800"></h1>
            <br><br>
            <div class=" table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Dosen</th>
                            <th scope="col">Mata Kuliah</th>
                            <th scope="col">SKS</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="ajaran">

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
            </div>

        </div>
    </div>
</center>




@endsection
@push('script')
<script>
    const url = "<?= url('/api/mhs/daftar-dosen/' . $mhs_id) ?>";

    const url_ambil_thn = "<?= url('/api/get-thn_ak-bag') ?>";

    tampilTahunAk(url_ambil_thn);
    $('#tampilkan-btn').click(e => {
        e.preventDefault();
        $('#preloader').css('display', '');



        const thn_id = $('#tahun_akademik').find(":selected").attr('value');
        const url2 = `<?= url('/api/mhs/daftar-dosen/' .$mhs_id. '?tahun_id=${thn_id}') ?>`;
        $.get(url2, data => {
            $('#info').text('');
            $('#ajaran').text('');
            $('#preloader').css('display', 'none');
            tampilData(data);
            //console.log(data);
        });

    });

    $.get(url, data => {
        console.log(data);
        tampilData(data);
        $('#preloader').css('display', 'none');
    });

    const tampilData = data => {
        const el = `Dosen yang mengajar di Kelas ${data.info.kelas} pada TA ${data.info.tahun_akademik}`;
        $('#info').append(el);

        let i = 1;
        data.ajaran.forEach(dt => {


            const status = dt.status == 'Kuisioner Belum Diisi' ? `<td class=" text-small"> <span class="btn btn-danger">Kuisioner Belum Diisi</span> </td>` : `<td class=" text-small"> <span class="btn btn-success">Kuisioner Sudah Diisi</span> </td>`;

            let isi = '';
            if(dt.status == 'Kuisioner Belum Diisi'){
                isi = `<td class="text text-primary"> <a href=" <?= url('/mhs/isi') ?>/${dt.id}"><i class="fas fa-edit"></i></a> </td>`;
            }else{
                isi = `<td> <a class=" text-secondary" ><i class="fas fa-edit"></i></a> </td>`;
            }

            const el = `<tr>
                        <th scope="row">${i}</th>
                        <td>${dt.nama}</td>
                        <td>${dt.nama_mk}</td>
                        <td>${dt.sks}</td>
                        ${status}
                        ${isi}
                    </tr>`;
            $('#ajaran').append(el);

            i++;
        });

    };
</script>

@endpush

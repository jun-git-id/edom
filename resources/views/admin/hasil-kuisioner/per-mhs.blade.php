@extends('layouts.master-admin')

@section('title','Hasil Kuisioner per Mahasiswa')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Hasil Kuisioner per Mahasiswa</h1>
<br><br>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <form>
            <div class="form-inline">
                <div class="form-group">
                    <label class=" mr-2" for="name">Tahun Akademik : </label>
                    <select name="" id="" class="form-control">
                        <option value="">2017 - 1</option>
                        <option value="">2017 - 2</option>
                    </select>
                </div>
                <button class=" ml-2 btn btn-primary">Tampilkan</button>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Kelas</th>
                        <th>Tahun Akademik</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>NIM</th>
                        <th>Kelas</th>
                        <th>Tahun Akademik</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>IP</th>
                    </tr>
                </tfoot>
                <tbody id="tempat-data">
                    <tr>
                        <td>16KAxon</td>
                        <td>16KA</td>
                        <td>2017-2</td>
                        <td>Akutansi</td>
                        <td>Budiarto</td>
                        <td>3.4</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@push('script')
<script>
    const url = "<?= url('/api/admin/hasil-evaluasi/per-mahasiswa') ?>"
    $.get(url, function(data, textStatus, jqXHR) {
        tampilData(data.data)
    });

    const tampilData = function(data) {

        data.forEach(dt => {
            const el = `<tr>
                        <td>${dt.id_mhs}</td>
                        <td>${dt.kelas}</td>
                        <td>${dt.tahun_akademik}</td>
                        <td>${dt.mata_kuliah}</td>
                        <td>${dt.dosen}</td>
                        <td>${dt.ip}</td>
                    </tr>`;
            $('#tempat-data').append(el);
        });

    }
</script>
<!-- Page level plugins -->
<script src="<?= url('/template-admin/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= url('/template-admin/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>

<!-- Page level custom scripts -->
<script src="<?= url('/template-admin/js/demo/datatables-demo.js') ?>"></script>
@endpush

@extends('layouts.master-admin')

@section('title','Import Data Mahasiswa')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Import Data Pengajaran</h1>
</div>


<div class="card">
    <div class="card-body">
        <p>Silahkan download dahulu template berikut ini. Kemudian silahkan isi dengan data yang diinginkan. Jika diisi silahkan upload pada form di bawah ini.</p>
    </div>
</div>
<br><br>
<div class="card">
    <div class="card-body">
        Download template excel import Pengajaran. <br>
        <a class=" btn btn-outline-primary" href="<?= url('/template-import-excel/edom-excel-import-pengajaran.xlsx') ?>" download="">Download</a>
    </div>
</div>

<div class="row" style="padding-top: 30px">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ url('/admin/import-data/pengajaran') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-success">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="tahun_akademik">Tahun Akademik</label>
                        <select class="form-control" name="tahun_akademik_id" id="tahun_akademik">
                        </select>
                        <p class="text-danger">{{ $errors->first('tahun_akademik_id') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="">File (.xls, .xlsx)</label>
                        <input type="file" class="form-control" name="file">
                        <p class="text-danger">{{ $errors->first('file') }}</p>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6"></div>
</div>`

@endsection

@push('script')
<script>
    const url_ambil_thn = "<?= url('/api/get-thn_ak') ?>";

    tampilTahunAk(url_ambil_thn);
</script>


@endpush

@extends('layouts.master-admin')

@section('title','Hasil Kuisioner Mahasiswa')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Library</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
    </ol>
</nav>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Evaluasi Kinerja Dosen</h1>
    <div>
        <a href="/chart" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-chart-bar fa-sm text-white-50"></i> Tampilan Grafik</a>
        <a href="<?= url('/pdf/table') ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-file-pdf fa-sm text-white-50"></i> Export to pdf</a>
    </div>

</div>

<div class="card">
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
        <div class="row" id="keterangan">

        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Aspek Penialian</th>
                    <th scope="col">IPD</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody id="pertanyaan">
                <tr>
                    <td>1</td>
                    <td>Ikan disini enak</td>
                    <td>2.7</td>
                    <td>BAik</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Kursi Nyaman</td>
                    <td>3.2</td>
                    <td>Cukup</td>
                </tr>
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
    //alert('adfasf');
</script>


@endpush

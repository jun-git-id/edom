@extends('layouts.master-admin')



@push('title')
<script language='JavaScript'>
    var txt = "|Sistem Informasi Evaluasi Dosen Oleh Mahasiswa (EDOM)";
    var speed = 300;
    var refresh = null;

    function action() {
        document.title = txt;
        txt = txt.substring(1, txt.length) + txt.charAt(0);
        refresh = setTimeout("action()", speed);
    }
    action();
</script>
@endpush


@section('content')

<!-- Page Heading -->
@if (session('kesalahan'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('kesalahan') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>
<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">kuisioner</div>
                        <a href="<?= url('/admin/bagikan') ?>" onclick="return confirm('Anda akan membagikan kuisioner sehingga mahasiswa dapat mengisi kuisioner pada tahun ajaran terkini. Apa anda yakin?');" class="text-uppercase btn btn-primary text-white">Bagikan kuisioner</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Dosen</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $jml_dosen }} </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-university fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Mahasiswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $jml_mhs }} </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Mata Kuliah</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $jml_matkul }} </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-sticky-note fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection

@push('script')
<script>
    //alert('adfasf');
</script>


@endpush

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
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>



@endsection

@push('script')
<script>
    //alert('adfasf');
</script>


@endpush

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Mahasiswa tak aktif') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Maaf Anda sudah bukan lagi mahasiswa Politeknik Negeri Cilacap sehingga tak dapat mengisi kuisioner.') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

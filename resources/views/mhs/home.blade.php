@extends('layouts.master-mhs')

@section('title','SB Admin 2 - Blank')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Dosen yang mengajar di Kelas 17TIA pada TA 2017-2</h1>

<div class="card mb-5">
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Dosen</th>
                    <th scope="col">Mata Kuliah</th>
                    <th scope="col">SKS</th>
                    <th scope="col">T/P</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>M. Zohn, S.si, M.Sc</td>
                    <td>Matematika Diskrit</td>
                    <td>3</td>
                    <td>T</td>
                    <td> <span class="btn btn-warning">Kuisioner belum diisi</span> </td>
                    <td class="text text-primary"> <a href=" <?= url('/isi') ?> "><i class="fas fa-edit"></i></a> </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Darmini, SH.,MH</td>
                    <td>Pendidikan Kewarganegaraan</td>
                    <td>2</td>
                    <td>T</td>
                    <td> <span class="btn btn-warning">Kuisioner belum diisi</span> </td>
                    <td class="text text-primary"> <a href=" <?= url('/isi') ?> "><i class="fas fa-edit"></i></a> </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>M. Zufri, S.Si,M.Sc</td>
                    <td>Algoritma dan Pemrogaman</td>
                    <td>3</td>
                    <td>T</td>
                    <td> <span class="btn btn-warning">Kuisioner belum diisi</span> </td>
                    <td class="text text-primary"> <a href=" <?= url('/isi') ?> "><i class="fas fa-edit"></i></a> </td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>Emi Suryadi, S.Kom.,M.Kom</td>
                    <td>Sistem Basis Data</td>
                    <td>2</td>
                    <td>T</td>
                    <td> <span class="btn btn-warning">Kuisioner belum diisi</span> </td>
                    <td class="text text-primary"> <a href=" <?= url('/isi') ?> "><i class="fas fa-edit"></i></a> </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>



@endsection

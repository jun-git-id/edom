@extends('layouts.master-mhs')

@section('title','SB Admin 2 - Blank')

@section('content')

<div class="card m-auto" style="max-width: 60em;">
    <div class="card-body">

        <div class="row">
            <div class="col-md">
                <table class="table table-borderless">
                    <tr>
                        <td>NIK Dosen</td>
                        <td><b>{{ $ajaran->nomor_induk }} </b> </td>
                    </tr>
                    <tr>
                        <td>Nama Dosen</td>
                        <td><b>{{ $ajaran->nama }} </b> </td>
                    </tr>
                    <tr>
                        <td>Tahun Akademik</td>
                        <td><b>{{ $ajaran->tahun }} {{ $ajaran->ganjil_genap }}</b> </td>
                    </tr>
                </table>
            </div>
            <div class="col-md">
                <table class="table table-borderless">
                    <tr>
                        <td>Mata Kuliah</td>
                        <td><b>{{ $ajaran->nama_mk }} </b> </td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td><b>{{ $ajaran->kelas }} </b> </td>
                    </tr>
                    <tr>
                        <td>Program Studi</td>
                        <td><b>{{ $ajaran->nama_prodi }} </b> </td>
                    </tr>
                </table>
            </div>
        </div>
        <b>Cara Menjawab</b> <br>
        Jawablah semua pertanyaan di bawah ini secara jujur dan objektif dengan memilih salah satu opsi dalam setiap pertanyaan. Jawaban Anda tidak akan berpengaruh terhadap nilai akademik karena bioadata Anda tidak akan tersimpan. <br>
        <b>Keterangan : K = Kurang, C = Cukup, B = Baik, SB = Sangat Baik</b>
        <br><br><br>


        <form action="<?= url('/mhs/store') ?>" method="post">
            @csrf
            <input type="hidden" name="mengajar_id" value="{{ $ajaran->mengajar_id }} ">
            @foreach ($kompetensi as $kmp)
            <h5> {{ $loop->iteration }}. {{ $kmp->aspek_kompetensi }} </h5>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Aspek Penilaian</th>
                        <th scope="col">K</th>
                        <th scope="col">C</th>
                        <th scope="col">B</th>
                        <th scope="col">SB</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kmp->question as $pert)
                    <tr>
                        <th scope="row"> {{ $loop->iteration }} </th>
                        <td> {{ $pert->pertanyaan }} </td>
                        <td> <input type="radio" value="1" name="nilai[{{ $pert->id }}]" id=""> </td>
                        <td> <input type="radio" value="2" name="nilai[{{ $pert->id }}]" id=""> </td>
                        <td> <input type="radio" value="3" name="nilai[{{ $pert->id }}]" id=""> </td>
                        <td> <input type="radio" value="4" name="nilai[{{ $pert->id }}]" id="" checked> </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            @endforeach


            <div class="form-group">
                <label for="exampleFormControlTextarea1"><b>Komentar Anda : </b></label>
                <textarea name="komentar" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <br><br>

            <center>
                <button type="submit" class=" btn btn-primary btn-lg"> Kirim </button>
            </center>

        </form>


    </div>
</div>



@endsection

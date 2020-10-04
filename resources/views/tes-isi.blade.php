@extends('layouts.master-admin')

@section('title','SB Admin 2 - Blank')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Blank Page</h1>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md">
                <table class="table table-borderless">
                    <tr>
                        <td>NIK Dosen</td>
                        <td>: <b>01.01.08</b></td>
                    </tr>
                    <tr>
                        <td>Nama Dosen</td>
                        <td>: <b>Maspeni, S.Kom, M.Kom</b></td>
                    </tr>
                    <tr>
                        <td>Tahun Akademik</td>
                        <td>: <b>2017-2</b></td>
                    </tr>
                </table>
            </div>
            <div class="col-md">
                <table class="table table-borderless">
                    <tr>
                        <td>Mata Kuliah</td>
                        <td>: <b>Pemrogaman Terstruktur</b></td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>: <b>1711A</b></td>
                    </tr>
                    <tr>
                        <td>Program Studi</td>
                        <td>: <b>Teknik Informatika</b></td>
                    </tr>
                </table>
            </div>
        </div>
        <b>Cara Menjawab</b> <br>
        Jawablah semua pertanyaan di bawah ini secara jujur dan objektif dengan memilih salah satu opsi dalam setiap pertanyaan. Jawaban Anda tidak akan berpengaruh terhadap nilai akademik karena bioadata Anda tidak akan tersimpan. <br>
        <b>Keterangan : SB = Sangat Baik, B = Baik, C = Cukup, K = Kurang, SK = Sangat Kurang</b>
        <br><br><br>
        <h5>A. Kompetensi Pedagodik</h5>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Aspek Penilaian</th>
                    <th scope="col">SB</th>
                    <th scope="col">B</th>
                    <th scope="col">C</th>
                    <th scope="col">K</th>
                    <th scope="col">SK</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td> Kesiapan memberikan kuliah atau praktek </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td> Kempampuan menghidupkan orang mati </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td> Kejelasan penyampaian materi yang diajarkan </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                </tr>
            </tbody>
        </table>

        <br>
        <h5>B. Kompetensi Profesional</h5>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Aspek Penilaian</th>
                    <th scope="col">SB</th>
                    <th scope="col">B</th>
                    <th scope="col">C</th>
                    <th scope="col">K</th>
                    <th scope="col">SK</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td> Kesiapan memberikan kuliah atau praktek </td>
                    <td> <input type="radio" name="udang" id="udang" value="a"> </td>
                    <td> <input type="radio" name="udang" id="udang" value="b"> </td>
                    <td> <input type="radio" name="udang" id="udang"> </td>
                    <td> <input type="radio" name="udang" id="udang"> </td>
                    <td> <input type="radio" name="udang" id="udang"> </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td> Kempampuan menghidupkan orang mati </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td> Kejelasan penyampaian materi yang diajarkan </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                    <td> <input type="radio" name="" id=""> </td>
                </tr>
            </tbody>
        </table>


        <input type="radio" name="abc" value="a">
        <input type="radio" name="abc" value="b">


    </div>
</div>


@endsection

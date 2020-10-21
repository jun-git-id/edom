<!DOCTYPE html>
<html lang="en">

<head>
    <title>Hasil Evaluasi Dosen</title>
    <link rel="stylesheet" href="<?= public_path('css/style-pdf.css') ?>">
</head>

<body id="page-top">

    <center id="judul">
        <p>Hasil Evaluasi Dosen </p>
    </center>
    <div id="info">
        <p>
            Nomor Induk : {{ $dosen->nomor_induk }} <br>
            Nama Dosen : {{ $dosen->nama }} <br>
            Tahun Akademik : {{ $thn_ak }} <br>
        </p>


    </div>

    <div>
        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>Kelas</td>
                    <td>Mata Kuliah</td>
                    <td>Jumlah Mahasiswa</td>
                    <td>IPD</td>
                    <td>Keterangan</td>
                </tr>
            </thead>
            <tbody id="ajaran">
                @foreach($ajaran as $ajr)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$ajr->kelas }} </td>
                    <td>{{$ajr->nama_mk }} </td>
                    <td>{{$ajr->jml_responden }} </td>
                    <td>{{$ajr->nilaiPersen }} </td>
                    <td>{{$ajr->keterangan }} </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br><br><br><br>
        <table id="keterangan">
            <tr id="keterangan_tr">
                <td id="keterangan_td">Rata - rata</td>
                <td id="keterangan_td">: {{ $ket['rata2'] }} </td>
            </tr>
            <tr id="keterangan_tr">
                <td id="keterangan_td">Keterangan</td>
                <td id="keterangan_td">: {{ $ket['kesimpulan'] }} </td>
            </tr>
        </table>
    </div>

</body>

</html>

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
        <p>Prodi {{ $prodi }} <br>
        Tahun Akademik : {{ $thn_ak }} </p>
    </div>

    <div>
        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nomor Induk</td>
                    <td>Nama Dosen</td>
                    <td>Jumlah Kelas</td>
                    <td>Nilai</td>
                    <td>Keterangan</td>
                </tr>
            </thead>
            <tbody id="dosen">
                @foreach ($dosen as $dsn)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dsn->nomor_induk }}</td>
                    <td>{{ $dsn->nama }}</td>
                    <td>{{ $dsn->jml_kelas }}</td>
                    <td>{{ $dsn->nilaiPersen }} </td>
                    <td>{{ $dsn->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br><br><br><br>
        <table id="keterangan">
            <tr id="keterangan_tr" >
                <td id="keterangan_td" >Rata - rata</td>
                <td id="keterangan_td" >: {{ $ket['rata2'] }} </td>
            </tr>
            <tr id="keterangan_tr" >
                <td id="keterangan_td" >Keterangan</td>
                <td id="keterangan_td" >: {{ $ket['kesimpulan'] }} </td>
            </tr>
        </table>
    </div>

</body>

</html>

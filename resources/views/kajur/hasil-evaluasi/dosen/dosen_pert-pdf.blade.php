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
                    <td>Aspek Penialian</td>
                    <td>Kompetensi</td>
                    <td>Nilai</td>
                    <td>Keterangan</td>
                </tr>
            </thead>
            <tbody id="pertanyaan">
                @foreach ($pertanyaan as $prt)
                <tr>
                    <td>{{ $loop->iteration }} </td>
                    <td>{{ $prt->pertanyaan }} </td>
                    <td>{{ $prt->kompetensi }} </td>
                    <td>{{ $prt->nilaiPersen }} </td>
                    <td>{{ $prt->keterangan }} </td>
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

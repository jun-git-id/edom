<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hasil Evaluasi Dosen</title>
    <link href="<?= url('/template-admin/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?= url('/template-admin/css/sb-admin-2.min.css') ?>" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <center>
                        <h1 class=" h2 text-black-50 mt-5 mb-3">Hasil Evaluasi Dosen </h1>
                    </center>



                    <div class="card">
                        <div class="card-header py-3">
                            <div id="info">
                                <h6>Nomor Induk : {{ $info['nomor_induk'] }}  </h6>
                                <h6>Nama Dosen : {{ $info['nama_dosen'] }} </h6>
                                <br>
                                <br>
                                <h6>Matkul : {{ $info['matkul'] }} </h6>
                                <h6>Kelas : {{ $info['kelas'] }} </h6>
                                <h6>Jumlah Responden : {{ $info['jml_responden'] }}  Orang</h6>
                                <br>
                                <h6>Tahun Ajaran : {{ $info['thn_ak'] }} </h6>
                            </div>

                            <br>

                        </div>
                        <div class="card-body">
                            <div class="row" id="keterangan">

                            </div>
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Aspek Penialian</th>
                                        <th scope="col">Kompetensi</th>
                                        <th scope="col">Nilai</th>
                                        <th scope="col">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="pertanyaan">
                                    @foreach ($pertanyaan as $prt)
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td>{{ $prt->pertanyaan }} </td>
                                        <td>{{ $prt->kompetensi }} </td>
                                        <td>{{ $prt->nilai }} </td>
                                        <td>{{ $prt->keterangan }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            <br>
                            <br>
                            <br>
                            <div style="display: flex; justify-content: flex-end" class=" mr-5">
                                <table class=" font-weight-bold" id="rata2">
                                    <tr>
                                        <td>Rata - rata</td>
                                        <td>: {{ $ket['rata2'] }} </td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td>: {{ $ket['kesimpulan'] }} </td>
                                    </tr>
                                </table>
                            </div>
                            <br><br>
                            <br>
                            <br>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>

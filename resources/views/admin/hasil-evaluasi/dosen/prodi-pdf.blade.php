<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hasil Evaluasi Dosen</title>
    <link href="<?= public_path('/template-admin/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?= public_path('/template-admin/css/sb-admin-2.min.css') ?>" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <center>
                        <h1 class=" h2 text-black-50 mt-5 mb-3">Hasil Evaluasi Dosen </h1>
                    </center>

                    <div>
                        <div id="info">
                            <h4>Prodi {{ $prodi }} </h4>
                            <h4>Tahun Akademik : {{ $thn_ak }} </h4>
                        </div>
                    </div>
                    <br><br>
                    <div class="card">

                        <div class="card-body">
                            <div class="row" id="keterangan">

                            </div>
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nomor Induk</th>
                                        <th scope="col">Nama Dosen</th>
                                        <th scope="col">Jumlah Kelas</th>
                                        <th scope="col">Nilai</th>
                                        <th scope="col">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="dosen">
                                    @foreach ($dosen as $dsn)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $dsn->nomor_induk }}</td>
                                        <td>{{ $dsn->nama }}</td>
                                        <td>{{ $dsn->jml_kelas }}</td>
                                        <td>{{ $dsn->nilai }}</td>
                                        <td>{{ $dsn->keterangan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>


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

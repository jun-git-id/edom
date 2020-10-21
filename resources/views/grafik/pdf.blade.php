<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <link rel="stylesheet" href="<?= public_path('css/style-pdf.css') ?>">
</head>

<body id="page-top">

    <center id="judul">
        <p> {{ $title }} </p>
    </center>
    <div id="info">
        <p>
            @foreach ($info1 as $inf)
            {{ $inf['name'] }} : {{ $inf['value'] }} <br>
            @endforeach
        </p>


    </div>

    <img src="{{ $url }} " alt="" srcset="">

    <div>
        <br><br><br><br>
        <table id="keterangan">
            @foreach ($info2 as $inf)
            <tr id="keterangan_tr">
                <td id="keterangan_td">{{ $inf['name'] }} </td>
                <td id="keterangan_td">: {{ $inf['value'] }} </td>
            </tr>
            @endforeach
        </table>
    </div>

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="<?= public_path('css/style-pdf.css') ?>">
    <link rel="stylesheet" href="<?= public_path('/css/tes.css') ?>">
</head>

<body>
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
    <br>
    <br>
    <br>
    <br>
    <br><br><br>

    <img height="250" width="315" src="{{ $url }}" alt="" srcset="">

    <div>
        <br>
        <br>
        <br>
        <br>
        <table id="keterangan">
            @isset($info2)
            @foreach ($info2 as $inf)
            <tr id="keterangan_tr">
                <td id="keterangan_td">{{ $inf['name'] }} </td>
                <td id="keterangan_td">: {{ $inf['value'] }} </td>
            </tr>
            @endforeach
            @endisset

        </table>
    </div>

</body>

</html>

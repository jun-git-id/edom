@extends('layouts.master-admin')

@section('title','Pertanyaan Kuisioner')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pertanyaan Kuisioner</h1>
</div>

<form action="<?= url('/admin/kuisioner/pertanyaan/' . $pertanyaan->id) ?>" method="post">
    @csrf
    @method('put')
    <div class="form-group">
        <label for="pert">Pertanyaan</label>
        <input type="text" name="pertanyaan" class="form-control" id="pert" value="{{ $pertanyaan->pertanyaan }}">
    </div>
    <div class="form-group">
        <label for="aspek">Aspek Kompetensi</label>
        <select class="form-control" name="kompetensi_id" id="aspek">
            @foreach($kompetensi as $kmp)
            <option value="{{ $kmp->id }}" @if($pertanyaan->kompetensi_id == $kmp->id) selected @endif >{{ $kmp->aspek_kompetensi }}</option>
            @endforeach

        </select>
    </div>
    <button type="submit" class="btn btn-primary">Oke</button>
</form>

@endsection

@push('script')
<script>
    /* const url = "<?= url('/api/ambil-jurusan') ?>";

    $.get(url, data => {
        tampilData(data);
    });

    const tampilData = data => {
        data.forEach(dt => {
            const el = `<a href="<?= url('/admin/hasil-evaluasi/mhs/jurusan/${dt.id}') ?>" class="list-group-item list-group-item-action">${dt.nama_jurusan}</a>`;
            $('#jurusan').append(el);
        });

    }; */
</script>


@endpush

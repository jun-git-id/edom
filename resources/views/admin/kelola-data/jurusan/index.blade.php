@extends('layouts.master-admin')

@section('title','Jurusan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Jurusan</h1>
</div>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Jurusan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= url('admin/kelola-data/jurusan') ?>" method="post">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="pert">Jurusan</label>
                        <input type="text" name="nama_jurusan" class="form-control" id="pert">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Oke</button>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
@error('nama_jurusan')
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@enderror
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Tambah <i class="fas fa-plus-circle"></i>
</button>
<br>
<br>
<table class="table table-bordered table-striped table-hover">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">Jurusan</th>
            <th class="text text-center" colspan="2" scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jurusan as $jur)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $jur->nama_jurusan }}</td>
            <td><a class="btn btn-warning" href="{{ url('admin/kelola-data/jurusan/'.$jur->id.'/edit') }}"><i class="fas fa-edit"></i></a></td>
            <td>
                <form action="{{ url('/admin/kelola-data/jurusan/' . $jur->id) }}" method="post" class="d-inline">
                    @csrf
                    @method('delete')
                    <button onclick="return confirm('Data akan dihapus?');" type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </form>

            </td>
        </tr>
        @endforeach

    </tbody>
</table>


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

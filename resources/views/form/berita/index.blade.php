
@extends('layouts.dashboard')
@section('content')
<div class="card-body">

    @if(Session::has('success'))
    <div class="alert alert-primary">
        {{Session('success')}}
    </div>
    @endif
    <div class="table-responsive">
        <table id="basic-datatables" class="display table table-striped table-hover" >
            <a href="{{route('superadmin.berita_add')}}" class="btn btn-secondary btn-round">Add Berita</a>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Kategori</th>
                    <th>Gambar</th>
                    <th>action</th>
                </tr>
            </thead>

            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.dashboard')
@section('content')
<div class="card-body">
    <div class="row">

        <div class="col-md-6 col-lg-6">
            <form action="{{route($role.'.kategori_update', $kategori->id)}}" method="POST">
                @method('PUT')
                @csrf
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="nama_kategori"  value = "{{$kategori->nama_kategori}}"class="form-control" placeholder="Enter kategori">

            </div>

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
            </div>
    </div>
</div>
@endsection

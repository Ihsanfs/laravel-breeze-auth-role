@extends('layouts.dashboard')
@section('content')
@include('alert.alert')
<div class="card-body">
    <div class="row">

        <div class="col-md-6 col-lg-6">
            <form action="{{route($role.'.kategori_store')}}" method="POST">
                @method('POST')
                @csrf
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="nama_kategori"  class="form-control" placeholder="Enter kategori">
            </div>

            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



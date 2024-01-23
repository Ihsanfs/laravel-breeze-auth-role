
@extends('layouts.dashboard')
@section('content')
@include('alert.alert')
<div class="card-body">
    <div class="row">

        <div class="col-md-6 col-lg-6">
            <form action="{{route($role.'.galery_store')}}" method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf
            <div class="form-group">
                <label>judul</label>
                <input type="text" name="judul"  class="form-control" placeholder="Enter judul">
            </div>



            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="gambar_galery" class="form-control" >
            </div>


            <div class="form-group">
                <label>status</label>
                <select name="is_active" id="" class="form-control">
                    <option value="1">publish</option>
                    <option value="0">draft</option>


                </select>

            </div>


            <button type="submit" class="btn btn-primary">Send message</button>

        </form>
            </div>

    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

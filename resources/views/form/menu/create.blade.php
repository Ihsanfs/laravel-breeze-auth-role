@extends('layouts.dashboard')
@section('content')
@include('alert.alert')
<div class="card-body">
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <form action="{{route($role.'.menu_store')}}" method="POST">
                @method('POST')
                @csrf
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama_menu" class="form-control" placeholder="Nama menu">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="is_active" id="" class="form-control">
                        <option value=""  disabled selected>Pilih Status</option>
                        <option value="1">publish</option>
                        <option value="0">draft</option>


                    </select>

                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

        </div>



        </form>
    </div>
</div>

@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

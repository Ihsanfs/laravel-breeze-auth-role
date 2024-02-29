@extends('layouts.dashboard')
@section('content')
@include('alert.alert')
<style>
    #url_menu{
        display: none;
    }
</style>
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
                    <label>pilih status menu</label>
                    <select name="menu_pilih" id="menu_pilih" class="form-control">
                        <option value=""  disabled selected>Pilih Status menu</option>
                        <option value="1">internal</option>
                        <option value="2">tunggal</option>
                        <option value="3">internal/eksternal</option>

                    </select>
                </div>

                <div class="form-group" id="url_menu">
                    <label for="">URL</label>
                    <input type="text" name="url_menu" class="form-control">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#url_menu').hide(); // Menggunakan selector ID dengan tanda #

        $('#menu_pilih').change(function () {
            var menu_pilih = parseInt($(this).val());
            if (menu_pilih == 2) {
                $('#url_menu').show();
            } else {
                $('#url_menu').hide();
            }
        });
    });
</script>


@extends('layouts.dashboard')
@section('content')
@include('alert.alert')
    <div class="container">
        <h2 class="text-dark">Profil Instansi</h2>
        <div class="col-6 col-md-12 ml-auto text-right">
            @if($instansi)
                <a href="{{ route($role.'.instansi_edit', $instansi->first()->id) }}" class="btn btn-warning">Edit Profil</a>
            @else
                <a href="{{ route($role.'.instansi_create') }}" class="btn btn-warning">Buat Profil</a>
            @endif
        </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



        @if($instansi)
        <div class="row py-4">

                <div class="col-12 col-md-6 mb-2">

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" value="{{$instansi->nama}}" name="nama">
                    </div>


                    <div class="form-group">
                        <label for="sosial_media">Sosial Media (Berupa URL)</label>
                        <input type="text" class="form-control" name="sosmed" value="{{$instansi->link}}">
                    </div>
                    <div class="form-group ">
                        <label for="kecamatan">Kecamatan</label>
                        <textarea class="form-control" name="kecamatan" cols="50" rows="10">{{$instansi->kecamatan}}</textarea>

                    </div>
                </div>

                <div class="col-12 col-md-6 mb-2">

                    <div class="form-group">
                        <label for="kabupaten">Kabupaten</label>
                        <textarea class="form-control" id="kabupaten" name="kabupaten" cols="50" rows="10">{{$instansi->kabupaten}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="nagari">Nagari/Kelurahan/Desa</label>
                        <textarea class="form-control" name="nagari" cols="50" rows="10">{{$instansi->nagari}}</textarea>
                    </div>
                </div>


                <div class="col-12 col-md-6 mb-2 h-50">
                    <div class="form-group d-flex flex-column align-items-center">
                        <label for="foto_instansi" class="mb-2">Instansi</label>
                        <img src="{{ asset($instansi->foto_instansi) }}" alt="Foto Instansi" class="mb-2" style="max-width: 300px;">
                    </div>
                </div>



                <div class="col-12 col-md-6 mb-2 h-50">
                    <div class="form-group d-flex flex-column align-items-center">
                        <label for="foto_kepala" class="mb-2">Kepala Instansi</label>
                        <img src="{{ asset($instansi->foto_kepala) }}" alt="foto_kepala" class="mb-2" style="max-width: 300px;">
                    </div>
                </div>


        </div>
        @endif
    </div>
@endsection

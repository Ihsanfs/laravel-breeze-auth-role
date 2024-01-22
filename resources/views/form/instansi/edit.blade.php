@extends('layouts.dashboard')
@section('content')
    <div class="container">
        <h2 class="text-white">Profil Instansi</h2>
        <div class="row py-4">

                <div class="col-12 col-md-6 mb-2">
                    <form action="{{ route($role.'.instansi_update', $instansi->id) }}" class="col-md-auto" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" value="{{$instansi->nama}}" name="nama">
                    </div>

                    <div class="form-group">
                        <label for="sosial_media">Sosial Media (Berupa URL)</label>
                        <input type="text" class="form-control" value="{{$instansi->link}}" name="sosmed">
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
                        <input type="file" class="form-control-file mt-2" name="gambar_instansi">
                    </div>
                </div>

                <div class="col-12 col-md-6 mb-2 h-50">
                    <div class="form-group d-flex flex-column align-items-center">
                        <label for="foto_kepala" class="mb-2">Kepala Instansi</label>
                        <img src="{{ asset($instansi->foto_kepala) }}" alt="Foto kepala" class="mb-2" style="max-width: 300px;">
                        <input type="file" class="form-control-file mt-2" name="gambar_kepala">
                    </div>
                </div>

                <div class="col-12 col-md-12 mb-2">
                    <button class="btn btn-info col-md-12">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

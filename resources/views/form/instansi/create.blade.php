@extends('layouts.dashboard')
@section('content')
    <div class="container">
        <h2 class="text-white">Profil Perusahaan</h2>
        <div class="row py-4">

                <div class="col-12 col-md-6 mb-2">
                <form action="{{route($role.'.instansi_store')}}" class="col-md-auto" method="POST" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>

                    <div class="form-group">
                        <label for="sosial_media">Sosial Media (Berupa URL)</label>
                        <input type="text" class="form-control" name="sosmed">
                    </div>
                    <div class="form-group ">
                        <label for="kecamatan">Kecamatan</label>
                        <textarea class="form-control" name="kecamatan" cols="50" rows="10"></textarea>

                    </div>


                </div>

                <div class="col-12 col-md-6 mb-2">
                    <div class="form-group">
                        <label for="kabupaten">Kabupaten</label>
                        <textarea class="form-control" id="kabupaten" name="kabupaten" cols="50" rows="10"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="nagari">Nagari/Kelurahan/Desa</label>
                        <textarea class="form-control" name="nagari" cols="50" rows="10"></textarea>
                    </div>
                </div>


                <div class="col-12 col-md-6 mb-2">
                    <div class="form-group">
                        <label for="foto_instansi">Foto Instansi</label>
                        <input type="file" class="form-control-file" name="gambar_instansi">
                    </div>
                    <div class="form-group">
                        <label for="foto_kepala_nagari">Foto Kepala Instansi</label>
                        <input type="file" class="form-control-file" name="gambar_kepala">
                    </div>
                </div>
                <div class="col-12 col-md-12 mb-2">
                    <button class="btn btn-info col-md-12">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

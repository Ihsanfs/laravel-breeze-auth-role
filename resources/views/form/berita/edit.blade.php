
@extends('layouts.dashboard')
@section('content')
@include('alert.alert')
<div class="card-body">
    <div class="row">

        <div class="col-md-6 col-lg-6">
            <form action="{{ route($role.'.berita_update', $berita->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method ('put')
            <div class="form-group">
                <label>judul</label>
                <input type="text" name="judul" value="{{$berita->judul}}" class="form-control" placeholder="Enter judul">
            </div>

            <div class="form-group">
                <label>isi</label>

                <textarea name="body" id="editor1"  cols="30" rows="10">{!! $berita->body !!}</textarea>

            </div>

            <div class="form-group">
                <label>Kategori</label>

                <select name="kategori_id" id="" class="form-control">
                    @if($berita->id)
                        <option value="" disabled selected>Pilih Kategori</option>
                    @endif
                    @foreach ($kategori_all as $item)
                        <option value="{{$item->id}}" {{ $item->id == $berita->kategori_id ? 'selected' : '' }}>
                            {{$item->nama_kategori}}
                        </option>
                    @endforeach
                </select>




            </div>

            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="gambar_file"  class="form-control" >


            </div>
            <div class="form-group">
                <label>Gambar sekarang</label>
            <img width="150px"  src="{{asset($berita->gambar_artikel)}}">

        </div>
        <br>
        <div class="form-group">
            <label>Status</label>
            <select name="is_active" class="form-control">
                <option value="" {{ $berita->is_active == null ? 'selected' : '' }} disabled>Select Status</option>
                <option value="1" {{ $berita->is_active == '1' ? 'selected' : '' }}>Publish</option>
                <option value="0" {{ $berita->is_active == '0' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>




            <button type="submit" class="btn btn-primary">Send message</button>

        </form>
            </div>

        </div>
    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@extends('layouts.dashboard')
@section('content')
@include('alert.alert')

<div class="card-body">
    <div class="row">

        <div class="col-md-12 col-lg-12">
            <form action="{{route($role.'.halaman_update', $halaman->id)}}" method="POST"  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="nama_h">Nama menu</label>
                        <select name="nama_h" class="form-control">
                            <option value="" {{ $halaman->menu_id ? '' : 'selected' }}>Pilih Menu</option>
                            @foreach ($menu as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $halaman->menu_id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                </div>

                <div class="form-group">
                    <label for="nama_halaman">Judul</label>
                    <input type="text" name="judul_halaman" value="{{$halaman->nama}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="deskripsi_h">Deskripsi</label>
                    <textarea name="deskripsi_h"  class="form-control" id="editor1" rows="5" placeholder="deskripsi">{{$halaman->deskripsi}}</textarea>
                </div>

                <div class="form-group">
                    <label>Gambar sekarang</label>
                <img width="150px"  src="{{asset($halaman->gambar_h)}}">

            </div>

                <div class="form-group">
                    <label for="g_halaman">Gambar</label>
                    <input type="file" class="form-control-file" name="g_halaman" id="g_halaman">
                </div>

                <div class="form-group">
                    <label for="urut">Urutan halaman</label>
                    <input type="number" name="urutan" value="{{$halaman->page_halaman}}" class="form-control">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="is_active" class="form-control">
                        <option value="" {{ $halaman->is_active == null ? 'selected' : '' }} disabled>Select Status</option>
                        <option value="1" {{ $halaman->is_active == '1' ? 'selected' : '' }}>Publish</option>
                        <option value="0" {{ $halaman->is_active == '0' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            <button type="submit" class="btn btn-primary">Send message</button>

        </form>
            </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
     <script>
        CKEDITOR.replace( 'editor1' );
        config.sourceAreaTabSize = 8;
</script>
@extends('layouts.dashboard')
@section('content')
<div class="card-body">
    <div class="row">
        <div class="col-md-12 col-lg-8">
            <form action="{{ route($role.'.halaman_store') }}" method="POST"  enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="form-group">
                    <label for="nama_h">Nama menu</label>
                    <select name="nama_h" class="form-control">
                        @foreach ($menu as $item)
                        <option value="{{$item->id}}">{{$item->nama}}</option>

                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="deskripsi_h">Deskripsi</label>
                    <textarea name="deskripsi_h"  class="form-control"  id="editor1" rows="5" placeholder="deskripsi"></textarea>
                </div>

                <div class="form-group">
                    <label for="g_halaman">Gambar</label>
                    <input type="file" class="form-control-file" name="g_halaman" id="g_halaman">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="is_active" id="" class="form-control">
                        <option value="1">publish</option>
                        <option value="0">draft</option>

                    </select>

                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
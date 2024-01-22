@extends('layouts.dashboard')
@section('content')
<div class="card-body">
    <div class="row">

        <div class="col-md-6 col-lg-6">
            <form action="{{route($role.'.slider_store')}}" method="POST" enctype="multipart/form-data">
                @method('post')
                @csrf
            <div class="form-group">
                <label>judul</label>
                <input type="text" name="judul_slide"  class="form-control" placeholder="Enter judul">
            </div>

            <div class="form-group">
                <label>isi</label>
               <input type="text" name="link" class="form-control"  placeholder="enter link">
            </div>


            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="video_slide"  >
            </div>


            <div class="form-group">
                <label>status</label>
                <select name="is_active" id="">
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

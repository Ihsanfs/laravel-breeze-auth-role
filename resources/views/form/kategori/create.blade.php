@extends('layouts.dashboard')
@section('content')
<div class="card-body">
    <div class="row">

        <div class="col-md-6 col-lg-6">
            <form action="" method="POST">
                @csrf
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="nama_kategori"  class="form-control" placeholder="Enter kategori">
                {{-- <small id="emailHelp2" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
            </div>

            <button type="submit" class="btn btn-primary">Send message</button>

        </form>
            </div>
    </div>
</div>
@endsection

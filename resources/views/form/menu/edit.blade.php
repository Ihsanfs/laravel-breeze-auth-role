@extends('layouts.dashboard')
@section('content')
<div class="card-body">
    <div class="row">

        <div class="col-md-6 col-lg-6">
            <form action="{{route($role.'.menu_update', $menu->id)}}" method="POST">
                @method('PUT')
                @csrf
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama_menu"  value = "{{$menu->nama}}"class="form-control" >

            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="" {{ $menu->is_active == null ? 'selected' : '' }} disabled>Select Status</option>
                    <option value="1" {{ $menu->is_active == '1' ? 'selected' : '' }}>Publish</option>
                    <option value="0" {{ $menu->is_active == '0' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
            </div>
    </div>
</div>
@endsection

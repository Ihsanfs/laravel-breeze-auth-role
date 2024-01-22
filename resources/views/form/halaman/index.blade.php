
@extends('layouts.dashboard')
@section('content')
<div class="card-body">

    @if(Session::has('success'))
    <div class="alert alert-primary">
        {{Session('success')}}
    </div>
    @endif

    <div class="table-responsive">
        <table id="basic-datatables" class="display table table-striped table-hover" >
            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)

            <a href="{{ route($role . '.halaman_create') }}" class="btn btn-secondary btn-round">Add Halaman</a>
        @endif


            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Author</th>
                    <th>Deskripsi</th>
                    <th>status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($halaman as $key => $item)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>
                        @if($item->menu_nama)
                            {{ $item->menu_nama->nama }}
                        @else
                            Menu tidak ada
                        @endif
                    </td>

                    <td>{{$item->author_halaman->name}}</td>
                    <td>{!! $item->deskripsi !!}</td>
                    <td>{{$item->is_active}}</td>
                    <td>

                        <a href="{{ route($role. '.halaman_edit', $item->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> edit</a>

                        <form action="{{ route($role. '.halaman_delete', $item->id) }}"  style="display: inline;" method="POST">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-xs">delete</button>
                            </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

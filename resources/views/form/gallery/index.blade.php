
@extends('layouts.dashboard')
@section('content')
<div class="card-body">

    @include('alert.alert')
    <div class="table-responsive">
        <table id="basic-datatables" class="display table table-striped table-hover" >
            <a href="{{route($role.'.galery_create')}}" class="btn btn-secondary btn-round">Add Gallery</a>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Gambar</th>
                    <th>Status</th>
                    <th>action</th>
                </tr>
            </thead>

            <tbody>
                <tbody>
                    @foreach ($gallery as $key => $item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->nama}}</td>
                        <td><img src="{{asset($item->gambar_galery)}}" alt="" class="img-thumbnail mb-2 mt-2" style="max-width: 150px"></td>
                        <td>
                            @if($item->is_active == 1)
                               Published
                            @else
                                Draft
                            @endif

                        </td>
                        <td><a href="{{ route($role.'.galery_edit', ['id' => $item->id]) }}" class="btn btn-primary btn-sm "><i class="fa fa-edit"></i> Edit</a>
                            <form action="{{ route($role.'.galery_destroy', ['id' => $item->id]) }}" method="post" style="display: inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm " onclick="return confirm('apakah anda ingin menghapus ?')">Delete</button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

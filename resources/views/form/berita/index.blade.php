
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
            <a href="{{route($role.'.berita_add')}}" class="btn btn-secondary btn-round">Add Berita</a>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Slug</th>
                    <th>Isi</th>
                    <th>Kategori</th>
                    <th>Gambar</th>
                    <th>Status</th>

                    <th>action</th>
                </tr>
            </thead>

            <tbody>


                @forelse($berita as $key=> $item)
                    <tr>
                        <td>{{$berita->firstItem() + $key}}</td>
                        <td>{{$item->judul}}</td>
                        <td>{{$item->slug}}</td>
                        <td>{!!$item->body!!}</td>
                        <td>
                            @if(isset($item->kategori))
                                {{$item->kategori->nama_kategori}}
                            @else
                              Kategori tidak ada
                            @endif
                        </td>
                        <td><img width="150px" src="{{asset($item->gambar_artikel)}}"></td>
                        <td>
                            @if($item->is_active == 1)
                                Publish
                            @else
                                Draft
                            @endif
                        </td>
                        <td>
                            <a href="{{ route($role.'.berita_edit', ['id' => $item->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <form action="{{ route($role.'.berita_delete', ['id' => $item->id]) }}" method="post" style="display: inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('apakah anda ingin menghapus ?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            Data masih kosong
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
    {!! $berita->render() !!}
</div>
@endsection

@extends('layouts.dashboard')
@section('content')
    <div class="card-body">

        @if (Session::has('success'))
            <div class="alert alert-primary">
                {{ Session('success') }}
            </div>
        @endif
        <div class="table-responsive">
            <table id="basic-datatables" class="display table table-striped table-hover">
                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                    <a href="{{ route($role . '.menu_create') }}" class="btn btn-secondary btn-round">Add Menu</a>
                @endif


                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Author</th>
                        <th>status</th>
                        <th>action</th>
                    </tr>
                </thead>

                <tbody>

                        @foreach ($menu as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->author_menu->name }}</td>
                                <td>  @if($item->is_active == 1)
                                    Publish
                                @else
                                    Draft
                                @endif</td>

                                <td>
                                    <a href="{{ route($role . '.menu_edit', $item->id) }}" class="btn btn-primary btn-xs"><i
                                            class="fa fa-edit"></i> edit</a>

                                    <form action="{{ route($role . '.menu_delete', $item->id) }}" method="POST"  style="display: inline;">
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
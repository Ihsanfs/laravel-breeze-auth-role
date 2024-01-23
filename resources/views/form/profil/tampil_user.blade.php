@extends('layouts.dashboard')
@section('content')


    <div class="card-body">

        @if (Session::has('success'))
            <div class="alert alert-primary">
                {{ Session('success') }}
            </div>
        @endif
        <div class="col-2">
            <a href="{{ route($role.'.users_create') }}" class="btn btn-info">Tambah User</a>
        </div>
        <div class="table-responsive">
            <table id="basic-datatables" class="display table table-striped table-hover">



                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>status</th>
                        <th>action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($user as $key => $row)
                    <tr>
                        <td>{{ $user->firstItem() + $key }}</td>
                        <td>{{ $row->name }}</td>
                        <td>
                            @if($row->role_id == 1)
                                superadmin
                            @elseif($row->role_id == 2)
                                admin
                            @else
                                <!-- Provide content for the else condition -->
                            @endif
                        </td>
                        <td>
                            @if($row->is_active == 1)
                            Aktif
                            @else
                           Tidak Aktif
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('superadmin.users_status', ['id' => $row->id]) }}" class="btn
                                @if($row->is_active == 1)
                                    btn-success btn-sm
                                @elseif($row->is_active == 0)
                                    btn-danger btn-sm
                                @else
                                    btn-secondary btn-sm
                                @endif">
                                <i class="fas fa-power-off"></i>
                                {{ $row->is_active == 1 ? 'Aktif' : ($row->is_active == 0 ? 'Tidak aktif' : 'Status Lain') }}
                            </a>




                         </td>


                    </tr>
                @endforeach



                </tbody>

            </table>
        </div>
        {!! $user->render() !!}
    </div>

@endsection

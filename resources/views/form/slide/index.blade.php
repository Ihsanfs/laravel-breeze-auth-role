
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
            <a href="{{route('superadmin.slider_add')}}" class="btn btn-secondary btn-round">Add Slide</a>
            <thead>


                <tr>
                    <th>N0</th>
                    <th>judul</th>
                    <th>slug</th>
                    <th>kategori</th>

                    <th>action</th>
                </tr>
            </thead>

            <tbody>




            <tr>
                {{-- <td colspan="6" class="text-center">
                      @if($slide->count() > 0)
                    @else
                    Data masih kosong
                </td> --}}
            </tr>

        </tbody>
        </table>
@endsection

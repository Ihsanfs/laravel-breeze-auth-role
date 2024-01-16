
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
            <a href="#" class="btn btn-secondary btn-round">Add Customer</a>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>slug</th>
                    <th>action</th>
                </tr>
            </thead>

            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection

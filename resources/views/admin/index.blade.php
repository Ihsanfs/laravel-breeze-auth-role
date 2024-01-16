@extends('layouts.dashboard')
@section('content')
<div class="mt-2 mb-4">
    <h2 class="text-white pb-2">Selamat Datang {{ Auth::user()->name }}!</h2>

</div>
<div class="row">
    <div class="col-md-4">
        <div class="card card-dark bg-primary-gradient">
            <div class="card-body pb-0">
                {{-- <div class="h1 fw-bold float-right">+5%</div> --}}
                <h2 class="mb-2">{{ Auth::user()->id }}</h2>
                <p>{{ Auth::user()->name }}</p>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-dark bg-primary-gradient">
            <div class="card-body pb-0">
                {{-- <div class="h1 fw-bold float-right">+5%</div> --}}
                <h2 class="mb-2">{{ Auth::user()->id }}</h2>
                <p>{{ Auth::user()->name }}</p>

            </div>
        </div>
    </div><div class="col-md-4">
        <div class="card card-dark bg-primary-gradient">
            <div class="card-body pb-0">
                {{-- <div class="h1 fw-bold float-right">+5%</div> --}}
                <h2 class="mb-2">{{ Auth::user()->id }}</h2>
                <p>{{ Auth::user()->name }}</p>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card">

            <div class="card col-md-12">

                <div class="card">
                    <h1>hello {{Auth::user()->name}}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-secondary">
            <div class="card-header">
                <div class="card-title">Daily Sales</div>
                <div class="card-category">March 25 - April 02</div>
            </div>
            <div class="card-body pb-0">
                <div class="mb-4 mt-2">
                    <h1>$4,578.58</h1>
                </div>
                <div class="pull-in">
                    <canvas id="dailySalesChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>
@include('form.kategori.index')
@endsection






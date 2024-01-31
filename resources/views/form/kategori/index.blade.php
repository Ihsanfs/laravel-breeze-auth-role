
@extends('layouts.dashboard')
@section('content')
<div class="card-body">
    @if(Session::has('success'))
    <div class="alert alert-primary">
        {{ Session('success') }}
    </div>
    @endif
    <h1> Nama Sekretaris</h1>

    <div class="row">
        <!-- Left side content -->
        <div class="col-md-8">
            <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>jabatan</th>
                            <th>Tps</th>
                            <th>Nagari</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sekretaris as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td>{{ $item->tps }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right side content -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Keterangan</h5>
                    <ul>
                        <li class="bg-warning rounded p-2 text-dark mt-2 mb-2"> Jumlah Sekretaris : {{$sekretaris->count();}}</li>
                        <li class="bg-success rounded p-2 text-dark mt-2 mb-2"> Jumlah TPS : {{$sekretaris->groupBy('tps')->count()}}</li>

                    </ul>
                    @php
                   $groupeSekretaris = $sekretaris->groupBy('tps')->sort(function ($a, $b) {
                    return $a->first()->tps <=> $b->first()->tps;
                });
                @endphp

                   @foreach($groupeSekretaris as $tpsValue => $group)
                   <ul>
                       <li>TPS : <strong>{{ $tpsValue }}</strong></li>
                       <li>Total Sekretaris Berdasarkan TPS : {{ $group->count() }}</li>
                       <div class="card-body bg-info rounded">
                       @foreach($group as $SekretarisItem)
                       <li class="text-dark"> <strong> Nama Sekretaris : {{ $SekretarisItem->nama_gelar }} </strong></li>

                   @endforeach
                </div>
                   </ul>
               @endforeach
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title"> </h5>
                    {{-- <p>Provide additional information or links here.</p> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

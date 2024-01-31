@extends('layouts.dashboard')
@section('content')
    <div class="card-body">
        @if (Session::has('success'))
            <div class="alert alert-primary">
                {{ Session('success') }}
            </div>
        @endif
        <h1>Tps  Kabid</h1>

        <div class="row">
            <!-- Left side content -->
            <div class="col-md-8">
                <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nagari</th>
                                <th>Umur</th>
                                <th>Jenis kelamin</th>
                                <th>Tps</th>



                            </tr>
                        </thead>
                        @php
                            $no =  $tps->firstItem();
                        @endphp
                        <tbody>
                            @foreach ( $tps as $index => $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->nagari }}</td>
                                    <td>{{ $item->umur }}</td>
                                    <td>{{ $item->jenis_kelamin }}</td>
                                    <td style="width : 100%">{{ $item->tps }}</td>




                                </tr>
                            @endforeach
                        </tbody>



                    </table>
                </div>
                {!! $tps->onEachSide(2)->links() !!}

                <div class="card mt-3">
                    <div class="card-body text-dark">
                        <h5 class="card-title"> </h5>


                        <h3>Total Orang memilih : {{ $semuatps->count() }}/orang</h3>


                        <h5>Total Rincian Semua Tps :</h5>
                        @foreach ($semuatps->groupBy('tps') as $tps => $count)
                            <ul>
                                <div class="card">
                                    <li class="p-2">
                                        {{ $tps }}
                                        <hr>
                                        Total = {{ $count->count() }}
                                    </li>
                                </div>
                            </ul>
                        @endforeach

                    </div>
                </div>
            </div>

            <!-- Right side content -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Keterangan</h5>
                        <ul>
                            <li class="bg-warning rounded p-2 text-dark mt-2 mb-2"> Jumlah Kabid :
                                {{  $tpskabid->count() }}</li>
                            <li class="bg-success rounded p-2 text-dark mt-2 mb-2"> Jumlah TPS :
                                {{  $tpskabid->groupBy('tps')->count() }}</li>

                        </ul>
                        @php
                            $groupedkabid =  $tpskabid->groupBy('tps')->sort(function ($a, $b) {
                                return $a->first()->tps <=> $b->first()->tps;
                            });
                        @endphp

                        @foreach ($groupedkabid as $key => $group)
                            <ul>
                                <li>TPS : <strong>{{ $key }}</strong></li>
                                <li>Total kabid Berdasarkan TPS : {{ $group->count() }}</li>
                                <div class="card-body bg-info rounded">
                                    @foreach ($group as $kabidItem)
                                        <li class="text-dark">
                                            <strong> Nama kabid : {{ $kabidItem->nama_gelar }}</strong>

                                            @php
                                                $totalTpskabid = $semuatps->where('tps', $key)->count();
                                            @endphp

                                            <p> Total TPS: {{ $totalTpskabid }}</p>
                                        </li>
                                    @endforeach
                                </div>
                            </ul>
                        @endforeach

                    </div>
                </div>



            </div>

        </div>
    </div>
@endsection

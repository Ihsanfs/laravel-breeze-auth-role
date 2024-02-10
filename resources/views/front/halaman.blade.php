@extends('front.layouts.app')
@section('content')
@include('front.layouts.header_detail')

    <main id="main">
        <section class="detail">
            <div class="container mt-4">
                <div class="row">


                    <div class="col-lg-12 order-lg-2 mt-2 mb-2">
                        <div class="card h-100">
                            @if($halaman_detail->gambar_h)
                            <img class="card-img-top" src="{{ asset($halaman_detail->gambar_h) }}" alt="Card image cap">
                            @else

                            @endif
                            <div class="card-body">
                                <h2>{{ $halaman_detail->judul }}</h2>
                                <p>{!! $halaman_detail->deskripsi !!}</p>
                                {{-- <p>di buat oleh : {{ $halaman_detail->user_halaman->name }}</p>
                                <p> <i class="fa-solid fa-eye"></i> {{ $halaman_detail->view }} <i class="fa-regular fa-calendar-days"></i> {{ $halaman_detail->created_at->format('d M Y') }} <i class="fa-solid fa-clock"></i> {{ $halaman_detail->created_at->diffForHumans() }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

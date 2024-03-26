@extends('front.layouts.app')

@section('content')
    @include('front.layouts.header_detail')

    <main id="main">
        <section class="detail">
            <div class="container mt-4">
                <div class="row">
                    {{ Breadcrumbs::render('halaman', $slug) }}

                    <div class="col-lg-12 order-lg-2 mt-2 mb-2">
                        <div class="card h-100 border-0">
                            <div class="card-body">
                                @if($halaman_detail->gambar_h || $halaman_detail->gambar_page)
                                <div class="d-flex justify-content-center">
                                    <div class="col-lg-8">
                                        @if($halaman_detail->gambar_h)
                                            <img class="card-img-top" src="{{ asset($halaman_detail->gambar_h) }}" alt="Card image cap">
                                        @elseif($halaman_detail->gambar_page)
                                            <img class="card-img-top" src="{{ asset($halaman_detail->gambar_page) }}" alt="Card image cap">
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="p-4">
                                @if($halaman_detail->judul)
                                    <h2>{{ $halaman_detail->judul }}</h2>
                                @endif
                                @if($halaman_detail->deskripsi)
                                    <p>{!! $halaman_detail->deskripsi !!}</p>
                                @endif
                                @if($halaman_detail->nama)
                                    <h2>{{ $halaman_detail->nama }}</h2>
                                @endif
                                @if($halaman_detail->deskripsi_page)
                                    <p>{!! $halaman_detail->deskripsi_page !!}</p>
                                @endif
                            </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    @include('front.layouts.footer')

    </main>
@endsection

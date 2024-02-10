@extends('front.layouts.app')

@section('content')
    @include('front.layouts.header')
    <main id="main">
        <section class="detail_berita">
            <div class="container mt-4">
                <div class="row">


                    <div class="col-md-8  mt-2 mb-2">
                        <div class="card border-0">
                            <img class="card-img-top" src="{{ asset($artikel->gambar_artikel) }}" alt="Card image cap">
                            <div class="card-body">
                                <h2>{{ $artikel->judul }}</h2>
                                <p><i class="fa-solid fa-tags"></i> {{$artikel->kategori->nama_kategori}}</p>

                                <p>{!! $artikel->body !!}</p>
                                <p>di buat oleh : {{ $artikel->users->name }}</p>
                                <p><i class="fa-regular fa-calendar-days"></i> {{ $artikel->created_at->format('d M Y') }} <i class="fa-solid fa-clock"></i> {{ $artikel->created_at->diffForHumans() }} <i class="fa-solid fa-eye"></i> {{ $artikel->views }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mt-2 mb-2" data-aos="fade-up" data-aos-delay="200">
                        <form action="{{route('search_berita')}}" method="GET">
                            <div class="input-group mt-2 mb-3 rounded">

                                <input type="text" class="form-control" name="cari_berita" placeholder="Search Keyword" autocomplete="off">
                                <div class="input-group-append p-2">
                                    <button class="btn btn-outline-success mr-2 ml-2" type="submit">Search</button>
                                </div>

                            </div>
                        </form>
                              <h3>Berita Populer</h3>
                              <div class="card  ">

                                    @foreach ($berita_populer as $berita => $populer)

                                            <div class="col-md-12">
                                                <div class="mb-2 p-2">
                                                    <div class="card mb-1 p-2 h-100">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <a href="{{route('detail',$populer->slug)}}">
                                                                <img class="card-img-top"
                                                                    src="{{ asset($populer->gambar_artikel) }}"
                                                                    alt="Card image cap" style="max-width: 100%; height: auto;">
                                                                </a>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p style="font-size: 15px">{{ $populer->judul }}</p>
                                                                <p style="font-size: 15px"><i class="fa-regular fa-calendar-days"></i> {{ $populer->created_at->format('d M Y') }}</p>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>

                                        </div>
                                    @endforeach

                              </div>
                        <div class="card mt-2 ">
                            <div class="card-body p-2">
                                <h3 class="text-dark p-2">Berita Terbaru</h3>
                                @foreach ($berita_baru as $item)

                                        <div class="col-md-12">
                                            <div class="card mt-2 mb-2 p-2 h-100">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <a href="{{route('detail',$item->slug)}}">
                                                            <img class="card-img-top"
                                                                src="{{ asset($item->gambar_artikel) }}"
                                                                alt="Card image cap" style="max-width: 100%; height: auto;">
                                                            </a>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p style="font-size: 15px">{{ $item->judul }}</p>
                                                            <p style="font-size: 15px"><i class="fa-regular fa-calendar-days"></i> {{ $item->created_at->format('d M Y') }}</p>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                @endforeach

                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </section>
    </main>
@endsection

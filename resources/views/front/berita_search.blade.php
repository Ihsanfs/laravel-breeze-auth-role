@extends('front.layouts.app')

<style>/* Mengubah warna teks dan latar belakang tombol navigasi */
   .custom-pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.custom-pagination .pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
}

.custom-pagination .pagination li {
    margin-right: 5px;
}

.custom-pagination .pagination a,
.custom-pagination .pagination span {
    padding: 8px 16px;
    text-decoration: none;
    color: #333;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.custom-pagination .pagination a:hover {
    background-color: #043175;
    color: white;
}

.custom-pagination .pagination .pagination-current {
    background-color: #007bff;
    color: #fff;
    border: 1px solid #007bff;
}

.custom-pagination .pagination-prev,
.custom-pagination .pagination-next {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s ease;
    color: #333;
}

.custom-pagination .pagination-prev:hover,
.custom-pagination .pagination-next:hover {
    background-color: #043175;
}

    </style>
@section('content')
@include('front.layouts.header')

    <main id="main">
        <section class="search-berita">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        @if($berita->isNotEmpty())
                            @foreach ($berita as $item)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <a href="{{route('detail',$item->slug)}}" style="text-decoration: none; color:#333;">
                                            <img class="card-img-top " src="{{ asset($item->gambar_artikel) }}" alt="Card image cap">
                                            <div class="card-body">
                                                <p class="card-title">{{ mb_substr($item->judul, 0, 100) }}</p>
                                                <p class="card-text" style="font-size: 12px"><i class="fa-regular fa-calendar-days"></i> {{ $item->created_at->format('d M Y') }} <i class="fa-solid fa-eye"></i> {{ $item->views }} <i class="fa-solid fa-user"></i> {{ $item->users->name }} </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <div class="container">
                                    <div class="card p-2 border-0">
                                        <p>Berita tidak ditemukan.</p>
                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>
                    <div class="custom-pagination">
                        {!! $berita->onEachSide(2)->links() !!}
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
                      <div class="card">

                            @foreach ($berita_populer as $berita => $populer)

                                    <div class="col-md-12">
                                        <div class="mt-2 mb-2 p-2">
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
                            @endforeach

                      </div>
                    <div class="card mt-2">
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

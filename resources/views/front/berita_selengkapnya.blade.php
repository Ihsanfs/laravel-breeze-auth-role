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
.gambar-container {
    width: 100%;
        max-height: 260px;
        overflow: hidden;
        }
    </style>
@section('content')
@include('front.layouts.header')

    <main id="main" class="mt-4 py-4">
        <section class="search-berita">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        @foreach ($berita as $item)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 vh-50">
                                <a href="{{ route('detail', $item->slug) }}" style="text-decoration: none; color: #333;">
                                    <div class="gambar-container">
                                        <img class="img-fluid" src="{{ asset($item->gambar_artikel) }}" alt="Card image cap">
                                    </div>
                                    <div class="card-body">
                                        <p class="card-title">{{ mb_substr($item->judul, 0, 100) }}</p>
                                        <div class="col-md-auto" style="display: flex; align-items: center;"> <!-- Tambahkan style untuk perataan vertikal -->
                                            <p class="card-text" style="font-size: 15px">
                                                <i class="fa-regular fa-calendar-days"></i> {{ $item->created_at->format('d M Y') }}
                                                <i class="fa-solid fa-eye" style="margin-left: 10px;"></i> {{ $item->views }}
                                                <i class="fa-solid fa-user" style="margin-left: 10px;"></i> {{ $item->users->name }} <!-- Tambahkan margin-left di sini -->
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach


                    </div>
                    <div class="custom-pagination">
                        {!! $berita->onEachSide(2)->links() !!}
                    </div>
                </div>
                <div class="col-md-4 mt-2 mb-2" data-aos="fade-up" data-aos-delay="200">
                    <form action="{{ route('search_berita') }}" method="GET">
                        <div class="row mt-2">

                            <div class="input-group w-100">
                                <input class="form-control border-end-0 border" type="text" name="cari_berita"
                                    placeholder="Search" autocomplete="off">
                                <span class="input-group-append">
                                    <button
                                        class="btn btn-outline-secondary bg-dark border-start-0 border-bottom-0 border ms-n5"
                                        type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>

                        </div>
                    </form>




                    <h3>Berita Populer</h3>
                    <div class="card  ">

                        @foreach ($berita_populer as $berita => $populer)
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <div class="mb-1  h-100">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <!-- Tambahkan align-items-center di sini -->
                                                <div class="col-md-5">
                                                    <a href="{{ route('detail', $populer->slug) }}">
                                                        <img class="card-img-top"
                                                            src="{{ asset($populer->gambar_artikel) }}"
                                                            alt="Card image cap" style="max-width: 100%; height: auto;">
                                                    </a>
                                                </div>
                                                <div class="col-md-7">
                                                    <p style="font-size: 15px">{!! Str::limit($populer->judul, 50) !!}</p>
                                                    <p style="font-size: 15px">
                                                        <i class="fa-solid fa-calendar-days"></i>
                                                        {{ $populer->created_at->format('d M Y') }}
                                                        <i class="fa-solid fa-eye" style="margin-left: 10px;"></i>
                                                        {{ $populer->views }}
                                                        <!-- Tambahkan style margin-left di sini -->
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="card mt-2 ">

                            <h3 class="text-dark p-2">Berita Terbaru</h3>
                            @foreach ($berita_baru as $item)
                                <div class="col-md-12">
                                    <div class="mt-2 mb-2 h-100">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-md-5">
                                                    <a href="{{ route('detail', $item->slug) }}">
                                                        <img class="card-img-top"
                                                            src="{{ asset($item->gambar_artikel) }}"
                                                            alt="Card image cap" style="max-width: 100%; height: auto;">
                                                    </a>
                                                </div>
                                                <div class="col-md-7">
                                                    <p style="font-size: 15px">{!! Str::limit($item->judul, 70) !!}</p>
                                                    <p style="font-size: 15px">
                                                        <i class="fa-solid fa-calendar-days"></i>
                                                        {{ $item->created_at->format('d M Y') }}
                                                        <i class="fa-solid fa-eye" style="margin-left: 10px;"></i>
                                                        {{ $item->views }}
                                                        <!-- Tambahkan style margin-left di sini -->
                                                    </p>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                    </div>
                    <div class="card mt-2 mb-2 p-2">
                        <h3>kategori</h3>
                        <div class="row">

                            @foreach ($kategori as $item)
                            <div class="col-md-4 border-0">
                                <a href="{{route('kategori_tampil',$item->slug)}}">
                                <div class="card p-2 mb-2 mt-2 bg-info">
                                   {{$item->nama_kategori}}
                                </div>
                            </a>
                            </div>
                            @endforeach

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
    @include('front.layouts.footer')

    </main>
@endsection

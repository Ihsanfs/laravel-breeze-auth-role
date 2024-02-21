@extends('front.layouts.app')

<style>
    /* Mengubah warna teks dan latar belakang tombol navigasi */
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

    .card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);

    }

    .image-container {
        overflow: hidden;
        position: relative;
        transition: transform 0.3s ease;
    }

    .image-container:hover img {
        transform: scale(1.1);
    }
</style>
@section('content')
    @include('front.layouts.header')

    <main id="main">
        <section class="search-berita">
            <div class="container mt-4">
                {{ Breadcrumbs::render('tag', $tag) }}


                {{-- @foreach ($kategori->pluck('nama_kategori') as $nama_kategori)
                <h4>kategori : {{$nama_kategori}}</h4>
            @endforeach --}}
                <div class="div">
                    <h2> tag : {{ $tag }}</h2>

                </div>

                </header>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">


                            @foreach ($tag_data as $key => $item)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <a href="{{ route('detail', $item->slug) }}"
                                            style="text-decoration: none; color:#333;">
                                            <div class="image-container">
                                                <img class="card-img-top" src="{{ asset($item->gambar_artikel) }}"
                                                    alt="Card image cap">

                                            </div>
                                            <div class="card-body">
                                                <div class="category-tags">
                                                    <div class="categories">
                                                        <span><i class="fa-solid fa-tag"></i>
                                                            @if (isset($groupKatLop[$item->id]))
                                                                @foreach ($groupKatLop[$item->id] as $nama_kategori)
                                                                    @php $kategori_slug = $categories[$nama_kategori] ?? ''; @endphp
                                                                    <a
                                                                        href="{{ route('kategori_tampil', $kategori_slug) }}">
                                                                        <span
                                                                            class="badge badge-pill badge-secondary mb-2 ">{{ $nama_kategori }}</span>
                                                                    </a>
                                                                @endforeach
                                                            @endif
                                                        </span>

                                                        {{-- <div class="tags">

                                                    @if (isset($grouptagLop[$item->id]))
                                                        @foreach ($grouptagLop[$item->id] as $nama_tag)
                                                            @php $tag_slug = $tags[$nama_tag] ?? ''; @endphp
                                                            <a href="{{ route('tag_tampil', $tag_slug) }}" >
                                                                <span class="badge badge-pill badge-secondary mt-2 mb-2">{{ $nama_tag }}</span></a>
                                                        @endforeach
                                                    @endif
                                                </div> --}}
                                                    </div>
                                                </div>
                                                <h5 class="card-title">{{ mb_substr($item->judul, 0, 100) }}</h5>
                                                <p style="font-size: 12px">
                                                    <i class="fa-solid fa-user"></i> {{ $item->name }}
                                                    <i class="fa-regular fa-calendar-days"></i>
                                                    {{ $item->created_at->format('d-m-Y') }}
                                                    <span><i class="fa-solid fa-eye"></i> {{ $item->views }}</span>
                                                </p>
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
                            <div class="input-group mt-2 mb-3 rounded">

                                <input type="text" class="form-control" name="cari_berita" placeholder="Search Keyword"
                                    autocomplete="off">
                                <div class=" p-2">
                                    <button class="btn btn-outline-success mr-2 ml-2" type="submit">Search</button>
                                </div>

                            </div>
                        </form>


                        <h3>Berita Populer</h3>
                        <div class="card">

                            @foreach ($berita_populer as $berita => $populer)
                                <div class="col-md-12">
                                    <div class="mt-2 mb-2 p-2">
                                        <div class="card mb-1 p-2 h-100">
                                            <div class="card-body">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <a href="{{ route('detail', $populer->slug) }}">
                                                        <img class="card-img-top"
                                                            src="{{ asset($populer->gambar_artikel) }}"
                                                            alt="Card image cap" style="max-width: 100%; height: auto;">
                                                    </a>
                                                </div>
                                                <div class="col-md-6">
                                                    <p style="font-size: 15px">{{ $populer->judul }}</p>
                                                    <p style="font-size: 15px"><i class="fa-regular fa-calendar-days"></i>
                                                        {{ $populer->created_at->format('d M Y') }}</p>

                                                </div>

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
                                                        <a href="{{ route('detail', $item->slug) }}">
                                                            <img class="card-img-top"
                                                                src="{{ asset($item->gambar_artikel) }}"
                                                                alt="Card image cap" style="max-width: 100%; height: auto;">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p style="font-size: 15px">{{ $item->judul }}</p>
                                                        <p style="font-size: 15px"><i
                                                                class="fa-regular fa-calendar-days"></i>
                                                            {{ $item->created_at->format('d M Y') }}</p>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="card mt-2 mb-12 p-4">
                            <h4>Kategori</h4>
                            <div class="d-flex flex-wrap">
                                @foreach ($kategori as $nama_kategori => $items)
                                    <div class="mr-2 mb-2">
                                        <a href="{{ route('kategori_tampil', $items->slug) }}">
                                            <span class="badge badge-pill badge-info">
                                                {{ $items->nama_kategori }}
                                            </span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>



                        {{-- <div class="card mt-2 mb-12 p-2">
                            <div class="col-md-6 border-0">
                                <h3>Tag</h3>
                                <div class="row">
                                @foreach ($tag_cek as $item)
                                    <a href="{{ route('tag_tampil', $item->slug) }}">
                                        <div class="card p-2 mb-4 mt-2 bg-info">
                                            <span class="badge badge-pill badge-secondary mb-2 ">{{ $item->nama_tag }}</span>
                                        </div>
                                    </a>
                                @endforeach
                                </div>


                            </div>
                        </div> --}}
                        <div class="card mt-2 mb-12 p-4">
                            <h4>Tag</h4>
                            <div class="d-flex flex-wrap">
                                @foreach ($tag_cek as $item)
                                    <div class="mr-2 mb-2">
                                        <a href="{{ route('tag_tampil', $item->slug) }}">
                                            <span class="badge badge-success">{{ $item->nama_tag }}</span>
                                        </a>
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

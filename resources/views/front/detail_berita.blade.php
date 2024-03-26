@extends('front.layouts.app')

@section('content')
    @include('front.layouts.header')
    <main id="main" class="mt-4 py-4">
        <section class="detail_berita">
            <div class="container mt-4">

                <div class="row">
                    {{ Breadcrumbs::render('detail', $slug) }}


                    <div class="col-md-8 mt-2 mb-2">
                        <div class="card border-0">
                            <img class="card-img-top" src="{{ asset($artikel->gambar_artikel) }}" alt="Card image cap">
                            <div class="card-body">
                                <h2>{{ $artikel->judul }}</h2>
                                <p><i class="fa-solid fa-tags"></i>
                                    @foreach ($kat_lop as $item)
                                        <a href="{{ route('kategori_tampil', $item->slug) }}">
                                            <span class="badge badge-pill badge-secondary mb-2">{{ $item->nama_kategori }}</span>
                                        </a>
                                    @endforeach
                                </p>
                                <div class="d-flex align-items-center" style="font-size: 15px;">
                                    <p class="mr-3"><i class="fa-regular fa-calendar-days"></i> {{ $artikel->created_at->format('d M Y') }}</p>
                                    <p class="mr-3"><i class="fa-solid fa-clock"></i> {{ $artikel->created_at->diffForHumans() }}</p>
                                    <p class="mr-3"><i class="fa-solid fa-eye"></i> {{ $artikel->views }}</p>
                                    <p><i class="fa-solid fa-user"></i> {{ $artikel->users->name }}</p>
                                </div>
                                <p>{!! $artikel->body !!}</p>
                            </div>
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

                        <div class="card mt-2 mb-12 p-4">
                            <h4>Kategori</h4>
                            <div class="d-flex flex-wrap">
                                @foreach ($kat_lop as $nama_kategori => $items)
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
                        <div class="card mt-2 mb-12 p-4">
                            <h4>Tag</h4>
                            <div class="d-flex flex-wrap">
                                @foreach ($tag_lop as $item)
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
        @include('front.layouts.footer')

    </main>
@endsection

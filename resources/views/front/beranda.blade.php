@extends('front.layouts.app')
@section('content')
    <style>
        .btn-detail {
            position: absolute;
            bottom: 10px;
            right: 10px;
            padding: 5px 10px;
            /* Sesuaikan dengan kebutuhan Anda */
        }

        /* CSS untuk bullet pagination */
        .custom-pagination {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .custom-pagination .swiper-pagination-bullet {
            width: 20px;
            height: 20px;
            background-color: hsla(96, 86%, 52%, 0.5);
            margin: 0 5px;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .custom-pagination .swiper-pagination-bullet-active {
            background-color: #27da62e6;
        }



        #g_gallery {
            transition: transform .2s;
        }

        #g_gallery:hover {
            -ms-transform: scale(1.5);
            /* IE 9 */
            -webkit-transform: scale(1.5);
            /* Safari 3-8 */
            transform: scale(1.5);
        }

        a,
        button {
            cursor: pointer;
            user-select: none;
            border: none;
            outline: none;
            background: none;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            /* Mengisi lebar slider */
            height: auto;
            /* Mengatur tinggi sesuai aspek rasio */
            object-fit: cover;
            /* Memastikan gambar tidak terdistorsi */
        }

        /* Elements */
        .section {
            margin: 0 auto;
            padding-block: 5rem;
        }

        .container {
            max-width: 75rem;
            height: auto;
            margin-inline: auto;
            padding-inline: 1.25rem;
        }

        .swiper {

            &-button-next::after,
            &-button-prev::after {
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.75rem;
                font-weight: 800;
                padding: 1rem;
                width: 2rem;
                height: 2rem;
                opacity: 0.75;
                border-radius: 50%;
                color: var(--white-100);
                background: var(--black-300);
            }
        }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>


    <!-- Tambahkan juga jQuery jika diperlukan oleh Swiper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Tambahkan skrip untuk memuat library Swiper -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    @include('front.layouts.header')
    <main id="main">
        <!-- ======= Hero Section ======= -->
        {{-- <section id="hero" class="hero d-flex align-items-center" style="background: url({{ asset('gambar/pasbar.png') }})"> --}}
        <section id="hero" class="hero d-flex align-items-center"
            style="background: url('{{ asset('gambar/pasbar.png') }}'); background-repeat: no-repeat; background-size: cover; ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-content-center ">

                        <h1 data-aos="fade-up" class="text-white">OPD PASAMAN BARAT</h1>


                    </div>
                    {{-- <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
                        <img src="{{ asset('gambar/pasbar.png') }}" class="img-fluid" alt="">
                      </div> --}}
                </div>
            </div>
        </section>

        <section id="instansi">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 text-center justify-content-center">
                        <h2>Instansi</h2>
                        <div class="card p-2 border-0">
                            <img src="{{ asset($instansi->foto_instansi) }}"
                                style="height: 500px; width:400px; margin-left: auto;
                            margin-right: auto;"
                                class="img-fluid " alt="">
                        </div>
                    </div>

                    <div class="col-md-4 text-center">
                        <h2>Kepala Instansi</h2>
                        <div class="card p-2">
                            <img src="{{ asset($instansi->foto_kepala) }}" class="img-fluid" alt="">
                            <h4>{{ $instansi->nama }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>


            @if (count($berita_terbaru) > 0)
                <div class="container" data-aos="fade-up">
                    <section id="recent-blog-posts" class="recent-blog-posts">
                        <div class="container" data-aos="fade-up">
                            <header class="section-header">
                                <p>Berita Utama</p>
                            </header>
                            <div class="row">
                                @foreach ($berita_terbaru as $key => $item)
                                    <div class="col-lg-4 mb-2">
                                        <div class="post-box">
                                            <div class="post-img"><img src="{{ asset($item->gambar_artikel) }}"
                                                    class="img-fluid" alt=""></div>
                                            <span>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('j, F Y') }}
                                                <i class="fa-solid fa-eye"></i> {{ $item->views }}</span>
                                            <h3 class="post-title">{{ $item->judul }}</h3>
                                            <a href="{{ route('detail', $item->slug) }}"
                                                class="readmore stretched-link mt-auto"><span>Selengkapnya</span><i
                                                    class="bi bi-arrow-right"></i></a>
                                        </div>
                                    </div>
                                @endforeach
                                <a class="btn btn-success" href="{{ route('berita_lengkap') }}">Lihat Selengkapnya</a>
                            </div>
                        </div>
                    </section>
                </div>
            @endif





            </div>
            @if (count($berita_populer) > 0)
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="container slider-column ">
                                <header class="section-header">
                                    <p>Berita Popular</p>
                                </header>
                                <div class="swiper swiper-slider ">
                                    <div class="swiper-wrapper h-100">
                                        @foreach ($berita_populer as $key => $item)
                                            <div class="swiper-slide h-100">
                                                <img src="{{ asset($item->gambar_artikel) }}" alt="Swiper"
                                                    class="img-fluid rounded h-100">
                                                <div class="card-body mt-1 ">
                                                    <strong>
                                                        <h2 style="font-size: 20px;">{{ $item->judul }}</h2>
                                                    </strong>
                                                    <p>
                                                        <i class="fa-solid fa-user"></i> {{ $item->users->name }}
                                                        <i class="fa-regular fa-calendar-days"></i>
                                                        {{ $item->created_at->format('d-m-Y') }}
                                                        <span><i class="fa-solid fa-eye"></i> {{ $item->views }}</span>
                                                    </p>
                                                </div>
                                                <a href="{{ route('detail', $item->slug) }}"
                                                    class="btn btn-dark bg-gradient btn-sm btn-detail"
                                                    target="_blank">Detail <i class="fa-solid fa-arrow-right"></i></a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-4">
                                        <div class="swiper-pagination custom-pagination "></div>
                                    </div>
                                    {{-- <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div> --}}
                                </div>

                            </div>

                        </div>
            @endif
            {{-- <div class="col-md-4">
                            <form action="{{ route('search_berita') }}" method="GET">
                                <div class="input-group mt-2 mb-3 rounded">

                                    <input type="text" class="form-control" name="cari_berita" placeholder="Search Keyword"
                                        autocomplete="off">
                                    <div class="input-group-append p-2">
                                        <button class="btn btn-outline-success mr-2 ml-2" type="submit">Search</button>
                                    </div>

                                </div>
                            </form>
                            <h3>Berita Populer</h3>
                            <div class="card p-2">
                                <div class="row">
                                    @foreach ($berita_populer as $berita => $populer)
                                        <div class="col-md-12">
                                            <div class=" p-2">
                                                <div class="card  p-2 h-100 border-1">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <a href="{{ route('detail', $populer->slug) }}">
                                                                    <img class="card-img-top"
                                                                        src="{{ asset($populer->gambar_artikel) }}"
                                                                        alt="Card image cap"
                                                                        style="max-width: 100%; height: auto;">
                                                                </a>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p style="font-size: 15px">{{ $populer->judul }}</p>
                                                                <p style="font-size: 15px"><i
                                                                        class="fa-regular fa-calendar-days"></i>
                                                                    {{ $populer->created_at->format('d M Y') }}</p>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach


                                </div>
                            </div>

                            <div class="card mt-2 p-2">
                                <div class="card-title text-center">Bupati dan Wakil Bupati Pasaman Barat</div>
                                <img src="{{ asset('gambar/bupati.png') }}" class="img-fluid">
                            </div>
                        </div> --}}
            </div>
            </div>

     






        <section class="gallery" id="gallery">
            <div class="container">
                <div class="card p-2 border-0">

                    <header class="section-header">

                        <p>Galeri</p>
                    </header>
                    <div class="row">
                        @foreach ($galeri as $item)
                            <div class="col-md-4 mb-2 mt-2">
                                <div class="card h-100">
                                    <img src="{{ asset($item->gambar_galery) }}" class="card-img-top img-fluid"
                                        alt="" data-toggle="modal" data-target="#galleryModal{{ $item->id }}">

                                    <div class="card-body">

                                        <h4 class="card-text">{{ $item->nama }}</h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="galleryModal{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="galleryModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="galleryModalLabel{{ $item->id }}">
                                                {{ $item->nama }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ asset($item->gambar_galery) }}" class="img-fluid"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>








    </main>

    @include('front.layouts.footer')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const swiper = new Swiper(".swiper-slider", {
                // Optional parameters
                centeredSlides: true,
                slidesPerView: 2,
                spaceBetween: 20,
                grabCursor: true,
                freeMode: false,
                loop: true,
                mousewheel: false,
                keyboard: {
                    enabled: true
                },

                // Enabled autoplay mode
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false
                },

                // If we need pagination
                pagination: {
                    el: ".swiper-pagination",
                    dynamicBullets: false,
                    clickable: true
                },

                // If we need navigation
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev"
                },

                // Responsive breakpoints
                breakpoints: {
                    // when window width is >= 320px
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    // when window width is >= 480px
                    480: {
                        slidesPerView: 2,
                        spaceBetween: 15
                    },
                    // when window width is >= 640px
                    // 640: {
                    //     slidesPerView: 3,
                    //     spaceBetween: 20
                    // }
                }
            });
        });
    </script>
@endsection
{{-- <script src="@@path/vendor/owl.carousel/dist/owl.carousel.min.js"></script> --}}

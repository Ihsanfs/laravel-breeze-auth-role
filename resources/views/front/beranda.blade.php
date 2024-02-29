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

            -webkit-transform: scale(1.5);

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


        #g_gal {
            width: 100%;
            height: 400px;
            position: relative;
            overflow: hidden;
        }

        #g_gal img {

            object-fit: cover;
            width: calc(100% - 20px);

            height: calc(100% - 70px);

            position: absolute;
            top: 70px;

            left: 8px;

            right: 12px;

        }

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

        .gambar-container {
            width: 640px;
            height: 260px;
            overflow: hidden;
        }


        .image-container {
            width: 100%;
            height: 0;
            padding-top: 60%;

            position: relative;
            overflow: hidden;
        }

        .swiper-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
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

        @if ($instansi)
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
        @endif

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
                                        <div class="post-img">
                                            <div class="gambar-container">
                                                <img src="{{ asset($item->gambar_artikel) }}" class="img-fluid"
                                                    alt="">
                                            </div>
                                        </div>
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
                        <div class="container slide-container">
                            <header class="section-header">
                                <p>Berita Popular</p>
                            </header>
                            <div class="swiper swiper-slider">
                                <div class="swiper-wrapper">
                                    @foreach ($berita_populer as $key => $item)
                                        <div class="swiper-slide">
                                            <div class="image-container">
                                                <img src="{{ asset($item->gambar_artikel) }}" alt="Swiper"
                                                    class="swiper-image">
                                            </div>
                                            <div class="card-body mt-1">
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
                                                class="btn btn-dark bg-gradient btn-sm btn-detail" target="_blank">Detail <i
                                                    class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4">
                                    <div class="swiper-pagination custom-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif



        </div>
        </div>


        @if (count($galeri) > 0)
            <section class="gallery" id="gallery">
                <div class="container">
                    <div class="card p-2 border-0">

                        <header class="section-header">

                            <p>Galeri</p>
                        </header>
                        <div class="row">
                            @foreach ($galeri as $item)
                                <div class="col-md-4 mb-2 mt-2">
                                    <div class="card h-100 p-2">
                                        <a href="#" class="album-link" data-toggle="modal"  data-target="#modalalbum"
                                            data-album-id="{{ $item->id }}">
                                            <img src="{{ asset($item->album_image) }}" id="g_gal" alt="" />
                                        </a>


                                        <div class="card-body">
                                            <h4 class="card-text">{{ $item->nama_album }}</h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal fade" id="modalalbum" tabindex="-1" role="dialog" aria-labelledby="modalalbumLabel"
                        aria-hidden="true" data-backdrop="static"  >
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalalbumLabel">Gallery</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div id="galeri" class="row"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        @endif







    </main>

    @include('front.layouts.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

    <script>
        $(document).ready(function() {
            $('.album-link').on('click', function(e) {
                e.preventDefault();

                var albumId = $(this).data('album-id');

                $.ajax({
                    url: "{{ route('album_tampil', '') }}/" + albumId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var galeri = $('#galeri');
                        galeri.empty();

                        if (response.length === 0) {
                            galeri.append(
                                '<div class="col-md-12 text-center">No images found</div>');
                        } else {
                            $.each(response, function(index, image) {
                                var imageUrl =
                                    `{{ asset('') }}${image.gambar_galery}`;
                                galeri.append(`
                                    <div class="col-md-6 mb-2 mt-2 p-2">
                                        <div class="card p-2">
                                            ${image.is_active == 0 ? '<p class="text-center text-white bg-dark">Draft</p>' : ''}
                                            <a data-fancybox="${image.id_album}" href="${imageUrl}" data-caption="${image.nama}" data-sizes="(max-width: 600px) 480px, 800px">
                                                <img src="${imageUrl}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;" alt="" />
                                            </a>
                                        </div>
                                    </div>
                                `);
                            });
                            Fancybox.bind('[data-fancybox]', {});
                        }
                    },
                    error: function(xhr, status, error) {

                    }
                });
            });


        });
    </script>

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

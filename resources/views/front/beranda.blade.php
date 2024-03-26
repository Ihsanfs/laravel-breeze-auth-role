@extends('front.layouts.app')
@section('content')
    <style>
        .btn-detail {
            position: absolute;
            bottom: 10px;
            right: 10px;
            padding: 5px 10px;

        }


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
            background-color: hsla(61, 100%, 50%, 0.5);
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
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    @include('front.layouts.header')
    <main id="main">

        {{-- <section id="hero" class="hero d-flex align-items-center" style="background: url({{ asset('gambar/pasbar.png') }})"> --}}
        <section id="hero" class="hero d-flex align-items-center"
            style="background: url('{{ asset('gambar/walisalingka.jpg') }}'); background-repeat: no-repeat; background-size: cover; ">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 d-flex flex-column justify-content-center ">

                        <h1 data-aos="fade-up" style="color: #ffffff">Selamat datang di Nagari Salingka Muaro</h1>


                    </div>
                    <div class="col-md-4" data-aos="zoom-out" data-aos-delay="200">
                        {{-- <img src="{{ asset('gambar/pasbar.png') }}" class="img-fluid" alt=""> --}}
                        <div class="card  " style="background: none; border: none;">
                            <img src="{{ asset($instansi->foto_kepala) }}" class="img-fluid" alt="">
                            <div class="card p-1">
                                <span class="text-center" style="font-size: 25px"> {{ $instansi->nama }} </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        @if ($instansi)
            <section id="instansi">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 text-center justify-content-center">
                            <h2>Kantor</h2>
                            <div class="card p-2 border-0 ">
                                <img src="{{ asset($instansi->foto_instansi) }}"
                                    style="height: 500px; width:100%; margin-left: auto;
                            margin-right: auto;"
                                    class="img-fluid rounded" alt="">
                            </div>
                        </div>

                        <div class="col-md-6 justify-content-center  ">
                            <h2 class="text-center">Profil Nagari</h2>
                            <div class="card p-2" style="border: none">
                                <p class="text-justify">Nagari Salingka Muaro adalah salah satu nagari pemekaran dari Nagari
                                    Sungai Aua pada tahun 2017 dan menjadi Nagari Defenitif pada tahun 2023. Nagari Salingka
                                    Muara terletak di Kecamatan Sungai Aur Kabupaten Pasaman Barat Provinsi Sumatera Barat.
                                    Nagari ini memiliki luas 48.573 Km2, dan secara geografis berbatasan dengan wilayah
                                    sebagai berikut:
                                    Sebelah utara berbatasan dengan Nagari Ranah Malintang
                                    Sebelah selatan berbatasan dengan Sikilang Sungai Aur Selatan
                                    Sebelah timur berbatasan dengan Nagari Sungai Aua dan Nagari Ranah Air Haji
                                    Sebelah barat berbatasan dengan Nagari Salido Saroha dan Nagari Koto Gunung
                                    Secara administratif wilayah Nagari Salingka Muaro terdiri dari 5 kejorongan yaitu
                                    Jorong Situmang, Jorong Muara Tapus, Jorong Tombang Padang Hilir, Jorong Padang Timbalun
                                    dan Jorong Sungai Aur. Jumlah penduduk Nagari Salingka Muara berdasarkan data Sistem
                                    Administrasi Kependudukan (SIAK) tahun 2023 sebanyak 6.603 jiwa yang terdiri dari 3.295
                                    penduduk laki-laki dan 3.308 penduduk perempuan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @if (count($slidertampil) > 0)
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <div class="col-md-8 offset-md-2">
                    <div class="container slide-container">
                        <header class="section-header">
                            <p>slider</p>
                        </header>
                        <div class="swiper swiper-gambar ">
                            <div class="swiper-wrapper mb-2">
                                @foreach ($slidertampil as $key => $item)
                                    <div class="swiper-slide">
                                        <div class="image-container">
                                            <img src="{{ asset($item->gambar_slider) }}" alt="Swiper"
                                                class="swiper-image rounded">
                                        </div>
                                        <div class="mt-2">
                                        </div>
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
        </div>
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
                                        <span><i class="fa-regular fa-calendar-days"></i>
                                            {{ $item->created_at->format('d M Y') }}
                                            <i class="fa-solid fa-eye"></i> {{ $item->views }} <i
                                                class="fa-solid fa-user"></i> {{ $item->users->name }}</span>
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
        {{-- </div> --}}


        @if (count($berita_populer) > 0)
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container slide-container">
                            <header class="section-header">
                                <p>Berita Popular</p>
                            </header>
                            <div class="swiper swiper-slider">
                                <div class="swiper-wrapper mb-2">
                                    @foreach ($berita_populer as $key => $item)
                                        <div class="swiper-slide">
                                            <div class="image-container">
                                                <img src="{{ asset($item->gambar_artikel) }}" alt="Swiper"
                                                    class="swiper-image rounded">
                                            </div>
                                            <div class="card-body mt-1">
                                                <strong>
                                                    <h2 style="font-size: 20px;">{{ $item->judul }}</h2>
                                                </strong>
                                                <p> <i class="fa-regular fa-calendar-days"></i>
                                                    {{ $item->created_at->format('d-m-Y') }}
                                                    <span><i class="fa-solid fa-eye"></i> {{ $item->views }}</span>

                                                    <i class="fa-solid fa-user"></i> {{ $item->users->name }}

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
                                        <div class="card-header" style="background-color:  rgb(13, 100, 253)">
                                            <h4 class="card-text text-white">{{ $item->nama_album }}</h4>
                                        </div>


                                        <div class="card-body">
                                            <a href="{{ route('album_tampil', $item->slug) }}">
                                                <img src="{{ asset($item->album_image) }}" id="g_gal" alt="" />
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </section>
        @endif


    </main>

    @include('front.layouts.footer')



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const swiper = new Swiper(".swiper-slider", {

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


                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false
                },


                pagination: {
                    el: ".swiper-pagination",
                    dynamicBullets: false,
                    clickable: true
                },

                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev"
                },


                breakpoints: {

                    320: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },

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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const swiper = new Swiper(".swiper-gambar", {

            centeredSlides: true,
            slidesPerView: 1,
            spaceBetween: 30,
            grabCursor: true,
            freeMode: false,
            loop: true,
            mousewheel: false,
            keyboard: {
                enabled: true
            },


            autoplay: {
                delay: 2000,
                disableOnInteraction: false
            },


            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: false,
                clickable: true
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },


            // breakpoints: {

            //     320: {
            //         slidesPerView: 1,
            //         spaceBetween: 10
            //     },

            //     480: {
            //         slidesPerView: 2,
            //         spaceBetween: 15
            //     },
            //     // when window width is >= 640px
            //     // 640: {
            //     //     slidesPerView: 3,
            //     //     spaceBetween: 20
            //     // }
            // }
        });
    });
</script>
@endsection

<header id="header" class="header fixed-top" >
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <a href="/" class="logo d-flex align-items-center">
            <img src="{{asset('gambar/icosalingka.jpg')}}" class="rounded" alt="">
            {{-- <span>SALINGKA MUARO</span> --}}
        </a>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="{{ route('beranda') }}">Home</a></li>
                <li><a class="nav-link scrollto" href="#gallery">Gallery</a></li>

                @foreach ($menu as $key => $data)
                    @if ($data->status == 4)
                        <a href="{{ route('halaman', $data->slug) }}">{{ $data->nama }}</a>
                    @elseif ($data->url)
                        <a href="{{ $data->url }}"><span>{{ $data->nama }}</span></a>
                    @else
                        @if ($grouphalaman->has($data->id))
                            <li class="dropdown">
                                <a href="#"><span>{{ $data->nama }}</span> <i
                                        class="bi bi-chevron-down"></i></a>
                                <ul>
                                    @foreach ($grouphalaman[$data->id] as $item)
                                        <li>
                                            @if ($item->deskripsi)
                                                <a href="{{ route('halaman', $item->slug) }}">{{ $item->nama }}</a>
                                            @elseif ($item->url)
                                                <a href="{{ $item->url }}">{{ $item->nama }}</a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endif
                @endforeach










                {{-- <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                <li><a class="getstarted scrollto" href="#about">Get Started</a></li> --}}
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->

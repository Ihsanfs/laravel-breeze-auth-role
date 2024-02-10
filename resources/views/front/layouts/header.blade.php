<header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <a href="index.html" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="">
            <span>OOT</span>
        </a>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="{{route('beranda')}}">Home</a></li>
                <li><a class="nav-link scrollto" href="#gallery">Gallery</a></li>
                {{-- <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#services">Services</a></li>
          <li><a class="nav-link scrollto" href="#portfolio">Portfolio</a></li>
          <li><a class="nav-link scrollto" href="#team">Team</a></li> --}}
                {{-- <li><a href="blog.html">Blog</a></li> --}}
                @foreach ($menu as $key => $data)
                <li class="dropdown">
                    <a href="#"><span> {{ $data->nama }}</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>

                            @foreach ($grouphalaman[$data->id] as $item)
                                <li><a href="{{ route('halaman', $item->slug) }}"> {{ $item->nama }}</a></li>
                            @endforeach

                    </ul>
                </li>
            @endforeach





                {{-- <li><a class="nav-link scrollto" href="#contact">Contact</a></li> --}}
                {{-- <li><a class="getstarted scrollto" href="#about">Get Started</a></li> --}}
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->

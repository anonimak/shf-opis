<nav class="navbar navbar-expand-lg navbar-dark bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{asset('img/brand.png')}}" alt="" width="260px">
            {{-- <i class="fas fa-anchor mr-2"></i><strong>{{ config('app.name', 'Laravel') }}</strong> --}}
        </a>
        <ul class="navbar-nav ml-auto d-flex align-items-center">
            <li class="nav-item">
            <span class="nav-link" href="#">
            <a class="btn btn-light btn-round shadow-sm" href="#" data-toggle="modal" data-target="#modal_newsletter"><i class="fas fa-cloud-download-alt"></i> Download UI Kit <a href="https://github.com/wowthemesnet/Anchor-Bootstrap-UI-Kit/archive/master.zip" class="downloadzip" class="hidden"></a>
            </a>
            </span>
            </li>
        </ul>
    </div>
</nav>
<nav class="topnav navbar navbar-expand-lg navbar-light bg-secondary py-0">
    <div class="container">
            <a class="navbar-brand topnav-brand d-none" href="{{ url('/') }}">
                <img src="{{asset('img/brand.png')}}" alt="" width="200px">
            </a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        <div class="navbar-collapse collapse" id="navbarColor02">
            <ul class="navbar-nav navbar-bottom-nav mr-auto d-flex align-items-center">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Produk
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('produk/simulasi_kredit') }}">Simulasi Kredit</a>
                        <a class="dropdown-item" href="{{ url('/') }}">Promo</a>
                        <a class="dropdown-item" href="{{ url('/') }}">Kendaraan Bermotor</a>
                        <a class="dropdown-item" href="{{ url('/') }}">Pinjaman Dana</a>
                        <a class="dropdown-item" href="{{ url('/') }}">Umrah</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Profil
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="./landing.html">Tentang Perusahaan</a>
                        <a class="dropdown-item" href="./landing.html">Strategi Perusahaan</a>
                        <a class="dropdown-item" href="./landing.html">Tim Management</a>
                        <a class="dropdown-item" href="./login.html">Pemegang Saham</a>
                        <a class="dropdown-item" href="./blog.html">Tanggung Jawab Sosial</a>
                        <a class="dropdown-item" href="./page.html">Penghargaan</a>
                    </div>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="./docs.html">Docs</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<nav class="navbar navbar-light bg-white border-bottom fixed-top">
    <div class="container-fluid">

        {{-- Logo --}}
        <a class="navbar-brand" href="#">
            <img src="{{ asset('gambar/logo_foodty.png') }}" alt="FoodTY" height="44">

        </a>

        {{-- Hamburger (Mobile Only) --}}
        <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
            <i class="fa-solid fa-bars fs-4"></i>
        </button>

        {{-- Desktop Icons --}}

    </div>
</nav>

{{-- ================= MOBILE OFFCANVAS ================= --}}
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="mobileMenu">

    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column">

        {{-- Profile --}}
        <div class="mb-3">
            @include('partials.profileCard')
        </div>

        {{-- Menu Role --}}
        <div class="flex-grow-1">
            @yield('sidebar-menu')
        </div>

        {{-- Logout --}}
        <div class="p-3 border-top">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100">
                    <i class="fa-solid fa-right-from-bracket me-2"></i>
                    Logout
                </button>
            </form>
        </div>

    </div>
</div>

<aside class="sidebar d-none d-lg-flex flex-column border-end">

    {{-- PROFILE --}}
    <div class="p-4 border-bottom text-center">
        <i class="fa-solid fa-circle-user fa-3x profile-icon mb-2"></i>
        <div class="fw-semibold">Selamat Datang</div>
        <div class="fw-bold">[User]</div>
        <small class="text-muted">[Role]</small>
    </div>

    {{-- MENU --}}
    <div class="list-group list-group-flush flex-grow-1">
        @yield('sidebar-menu')
    </div>

    {{-- LOGOUT --}}
    <div class="p-3 border-top">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100">
                <i class="fa-solid fa-right-from-bracket me-2"></i>
                Logout
            </button>
        </form>
    </div>

</aside>

<aside class="sidebar d-none d-lg-flex flex-column border-end">

    {{-- PROFILE --}}
    <div class="p-3 border-bottom text-center" style="margin-top: 70px;">
        @php
            $user = auth()->user();

            // status verifikasi penerima: ambil attempt terakhir
            $status = $user?->latestRecipientVerification?->verification_status ?? 'pending';

            // foto khusus petugas (kalau penerima ga punya foto, otomatis fallback)
            $photo = $user?->petugas?->file_path ? asset('storage/' . $user->petugas->file_path) : null;
        @endphp

        {{-- FOTO PROFIL --}}
        @if ($photo)
            <img src="{{ $photo }}" alt="Foto Profil" class="rounded-circle shadow-sm mb-2"
                style="width:90px;height:90px;object-fit:cover;">
        @else
            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center shadow-sm mb-2"
                style="width:90px;height:90px;">
                <span class="fw-bold text-muted" style="font-size:28px;">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </span>
            </div>
        @endif

        {{-- NAMA & ROLE --}}
        <div class="fw-semibold">Selamat Datang</div>
        <div class="fw-bold">{{ $user->name ?? '-' }}</div>
        <small class="text-muted text-capitalize">{{ $user->role ?? '-' }}</small>

        {{-- BADGE VERIFIKASI (KHUSUS PENERIMA) --}}
        @if (($user->role ?? '') === 'penerima')
            @php
                $badgeClass = match ($status) {
                    'approved' => 'success',
                    'rejected' => 'danger',
                    default => 'warning',
                };
                $badgeText = match ($status) {
                    'approved' => 'Terverifikasi',
                    'rejected' => 'Ditolak',
                    default => 'Menunggu Verifikasi',
                };
            @endphp

            <div class="mt-2">
                <span class="badge bg-{{ $badgeClass }} rounded-pill px-3 py-2">
                    {{ $badgeText }}
                </span>
            </div>
        @endif
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

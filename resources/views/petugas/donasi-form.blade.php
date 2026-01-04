@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'donasi'])
@endsection

@section('content')

    {{-- HEADER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                    style="width:44px;height:44px;">
                    <i class="fa-solid fa-plus text-primary"></i>
                </div>
                <div>
                    <h5 class="mb-1">Tambah Donasi</h5>
                    <small class="text-muted">Satu donatur bisa memiliki banyak item donasi</small>
                </div>
            </div>

            <a href="{{ route('petugas.data-donasi') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <div class="fw-semibold mb-1">Gagal:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="{{ route('petugas.donasi.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- SECTION: HEADER DONASI --}}
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="fw-semibold">
                        <i class="fa-solid fa-circle-info text-primary me-1"></i> Header Donasi
                    </div>
                    <span class="text-muted small">Isi data umum donasi</span>
                </div>

                <div class="row g-3 mb-3">
                    {{-- DONATUR --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-user me-1"></i> Donatur
                        </label>

                        {{-- hidden buat dikirim ke backend --}}
                        <input type="hidden" name="donor_id" id="donor_id" value="{{ old('donor_id') }}" required>

                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" id="donor_search" class="form-control"
                                placeholder="Ketik nama / no telp donatur..." autocomplete="off">
                        </div>

                        {{-- hasil search --}}
                        <div id="donor_results" class="list-group mt-2" style="display:none;"></div>

                        <small class="text-muted ms-1">Cari donatur lewat nama atau nomor telepon.</small>
                    </div>

                    {{-- WAKTU --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fa-regular fa-clock me-1"></i> Waktu Donasi (opsional)
                        </label>
                        <input type="datetime-local" name="donated_at" class="form-control" value="{{ old('donated_at') }}">
                        <small class="text-muted ms-1">Kosongkan kalau mau otomatis sekarang.</small>
                    </div>

                    {{-- BUKTI --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fa-regular fa-file-lines me-1"></i> Bukti (opsional)
                        </label>
                        <input type="file" name="evidence" class="form-control">
                        <small class="text-muted ms-1">jpg/png/pdf (max 2MB)</small>
                    </div>

                    {{-- CATATAN --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fa-regular fa-note-sticky me-1"></i> Catatan Header (opsional)
                        </label>
                        <input type="text" name="note" class="form-control" value="{{ old('note') }}"
                            placeholder="Contoh: diantar langsung ke gudang">
                    </div>
                </div>

                <hr class="my-4">

                {{-- SECTION: ITEM DONASI --}}
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-2">
                    <div>
                        <div class="fw-semibold">
                            <i class="fa-solid fa-boxes-stacked text-primary me-1"></i> Item Donasi
                        </div>
                        <small class="text-muted">Tambah item sesuai barang yang diterima.</small>
                    </div>

                    <button type="button" class="btn btn-success btn-sm rounded-pill px-3" id="btnAddItem">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Item
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm align-middle" id="itemsTable">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Item</th>
                                <th>Kategori</th>
                                <th style="width:120px;">Qty</th>
                                <th style="width:120px;">Unit</th>
                                <th style="width:170px;">Kondisi</th>
                                <th style="width:160px;">Expired</th>
                                <th class="text-end" style="width:110px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- kalau old items ada --}}
                            @php $oldItems = old('items', [ [] ]); @endphp
                            @foreach ($oldItems as $i => $it)
                                <tr>
                                    <td>
                                        <div class="position-relative">
                                            <input class="form-control form-control-sm item-name"
                                                name="items[{{ $i }}][item_name]"
                                                value="{{ $it['item_name'] ?? '' }}" autocomplete="off" required>
                                            <div class="suggestion-box list-group position-absolute w-100 shadow-sm"
                                                style="z-index:9999; display:none; max-height:220px; overflow:auto;"></div>
                                        </div>
                                    </td>

                                    <td>
                                        <select class="form-select form-select-sm item-category"
                                            name="items[{{ $i }}][category]" required>
                                            <option value="pangan_kemasan" @selected(($it['category'] ?? '') === 'pangan_kemasan')>pangan_kemasan
                                            </option>
                                            <option value="pangan_segar" @selected(($it['category'] ?? '') === 'pangan_segar')>pangan_segar</option>
                                            <option value="non_pangan" @selected(($it['category'] ?? '') === 'non_pangan')>non_pangan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" min="0.01"
                                            class="form-control form-control-sm" name="items[{{ $i }}][qty]"
                                            value="{{ $it['qty'] ?? 1 }}" required>
                                    </td>
                                    <td>
                                        <input class="form-control form-control-sm"
                                            name="items[{{ $i }}][unit]" value="{{ $it['unit'] ?? 'pcs' }}"
                                            required>
                                    </td>
                                    <td>
                                        <select class="form-select form-select-sm"
                                            name="items[{{ $i }}][condition]" required>
                                            <option value="baik" @selected(($it['condition'] ?? '') === 'baik')>baik</option>
                                            <option value="rusak_ringan" @selected(($it['condition'] ?? '') === 'rusak_ringan')>rusak_ringan</option>
                                            <option value="tidak_layak" @selected(($it['condition'] ?? '') === 'tidak_layak')>tidak_layak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="date" class="form-control form-control-sm"
                                            name="items[{{ $i }}][expired_at]"
                                            value="{{ $it['expired_at'] ?? '' }}">
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 btnRemove">
                                            <i class="fa-solid fa-trash me-1"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ACTION --}}
                <div class="mt-4 d-flex flex-column flex-md-row gap-2">
                    <button class="btn btn-success rounded-pill px-4" type="submit">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan
                    </button>
                    <a href="{{ route('petugas.data-donasi') }}" class="btn btn-secondary rounded-pill px-4">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>

    <style>
        /* Fix autocomplete kepotong di table */
        .table-responsive {
            overflow: visible !important;
        }

        /* Biar suggestion tampil rapi */
        .suggestion-box {
            background: #fff;
            border-radius: .5rem;
        }

        /* Optional: hover effect */
        .suggestion-box .list-group-item:hover {
            background-color: #f1f5f9;
        }
    </style>

    <script>
        (function() {
            /* =========================
             * A) ITEM DONASI (ADD/REMOVE)
             * ========================= */
            const tableBody = document.querySelector('#itemsTable tbody');
            const btnAdd = document.getElementById('btnAddItem');

            function reindex() {
                const rows = tableBody.querySelectorAll('tr');
                rows.forEach((row, idx) => {
                    row.querySelectorAll('input, select, textarea').forEach(el => {
                        if (!el.name) return;
                        el.name = el.name.replace(/items\[\d+\]/, `items[${idx}]`);
                    });
                });
            }

            function newRow(index) {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                <td>
                    <div class="position-relative">
                        <input class="form-control form-control-sm item-name" name="items[${index}][item_name]" autocomplete="off" required>
                        <div class="suggestion-box list-group position-absolute w-100 shadow-sm"
                            style="z-index:9999; display:none; max-height:220px; overflow:auto;"></div>
                    </div>
                </td>
                <td>
                    <select class="form-select form-select-sm item-category" name="items[${index}][category]" required>
                        <option value="pangan_kemasan">pangan_kemasan</option>
                        <option value="pangan_segar">pangan_segar</option>
                        <option value="non_pangan">non_pangan</option>
                    </select>
                </td>
                <td><input type="number" step="0.01" min="0.01" class="form-control form-control-sm" name="items[${index}][qty]" value="1" required></td>
                <td><input class="form-control form-control-sm" name="items[${index}][unit]" value="pcs" required></td>
                <td>
                    <select class="form-select form-select-sm" name="items[${index}][condition]" required>
                        <option value="baik">baik</option>
                        <option value="rusak_ringan">rusak_ringan</option>
                        <option value="tidak_layak">tidak_layak</option>
                    </select>
                </td>
                <td><input type="date" class="form-control form-control-sm" name="items[${index}][expired_at]"></td>
                <td class="text-end">
                    <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 btnRemove">
                        <i class="fa-solid fa-trash me-1"></i> Hapus
                    </button>
                </td>
            `;
                return tr;
            }

            if (btnAdd && tableBody) {
                btnAdd.addEventListener('click', () => {
                    const index = tableBody.querySelectorAll('tr').length;
                    tableBody.appendChild(newRow(index));
                });

                tableBody.addEventListener('click', (e) => {
                    if (e.target.classList.contains('btnRemove') || e.target.closest('.btnRemove')) {
                        (e.target.closest('tr')).remove();
                        if (tableBody.querySelectorAll('tr').length === 0) {
                            tableBody.appendChild(newRow(0));
                        }
                        reindex();
                    }
                });
            }

            /* =========================
             * B) SEARCH DONATUR (AJAX)
             * ========================= */
            const donorInput = document.getElementById('donor_search');
            const donorIdInput = document.getElementById('donor_id');
            const donorResults = document.getElementById('donor_results');

            let timer = null;

            function hideResults() {
                if (!donorResults) return;
                donorResults.style.display = 'none';
                donorResults.innerHTML = '';
            }

            function renderDonors(items) {
                if (!donorResults) return;

                if (!items || items.length === 0) {
                    donorResults.innerHTML = `<div class="list-group-item text-muted">Tidak ada hasil</div>`;
                    donorResults.style.display = 'block';
                    return;
                }

                donorResults.innerHTML = items.map(d => `
                <button type="button" class="list-group-item list-group-item-action"
                        data-id="${d.id}"
                        data-label="${d.name} - ${(d.phone ?? '-')}"
                >
                    <div class="fw-semibold">${d.name}</div>
                    <small class="text-muted">${(d.phone ?? '-')} • ${d.type}</small>
                </button>
            `).join('');

                donorResults.style.display = 'block';
            }

            async function fetchDonors(q) {
                const url = `{{ route('petugas.donatur.search') }}?q=${encodeURIComponent(q)}`;
                const res = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (!res.ok) return [];
                return await res.json();
            }

            if (donorInput && donorIdInput && donorResults) {
                donorInput.addEventListener('input', () => {
                    clearTimeout(timer);
                    const q = donorInput.value.trim();

                    if (q.length === 0) {
                        donorIdInput.value = '';
                        hideResults();
                        return;
                    }

                    timer = setTimeout(async () => {
                        if (q.length < 2) {
                            hideResults();
                            return;
                        }

                        const data = await fetchDonors(q);
                        renderDonors(data);
                    }, 250);
                });

                donorResults.addEventListener('click', (e) => {
                    const btn = e.target.closest('button[data-id]');
                    if (!btn) return;

                    donorIdInput.value = btn.dataset.id;
                    donorInput.value = btn.dataset.label;
                    hideResults();
                });

                document.addEventListener('click', (e) => {
                    if (!donorResults.contains(e.target) && e.target !== donorInput) {
                        hideResults();
                    }
                });
            }

            /* =========================
             * C) AUTOCOMPLETE ITEM NAME
             * ========================= */
            const suggestEndpoint = @json(route('petugas.donasi.item-suggest'));

            function debounce(fn, delay = 200) {
                let t;
                return (...args) => {
                    clearTimeout(t);
                    t = setTimeout(() => fn(...args), delay);
                };
            }

            function closeBox(box) {
                if (!box) return;
                box.style.display = 'none';
                box.innerHTML = '';
            }

            async function fetchSuggest(q, category) {
                const url = new URL(suggestEndpoint, window.location.origin);
                url.searchParams.set('q', q);
                if (category) url.searchParams.set('category', category);

                const res = await fetch(url.toString(), {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (!res.ok) return [];
                return await res.json();
            }

            function renderBox(box, input, items) {
                box.innerHTML = '';
                if (!items.length) return closeBox(box);

                items.forEach(it => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'list-group-item list-group-item-action';
                    btn.textContent = it.label;

                    btn.addEventListener('click', () => {
                        input.value = it.value;
                        closeBox(box);
                        input.dispatchEvent(new Event('change'));
                    });

                    box.appendChild(btn);
                });

                box.style.display = 'block';
            }

            // typing in item name
            document.addEventListener('input', debounce(async (e) => {
                const input = e.target.closest('.item-name');
                if (!input) return;

                const wrapper = input.closest('.position-relative');
                const box = wrapper?.querySelector('.suggestion-box');
                if (!box) return;

                const q = input.value.trim();
                if (q.length < 2) return closeBox(box);

                const row = input.closest('tr');
                const categoryEl = row?.querySelector('.item-category');
                const category = categoryEl ? categoryEl.value : '';

                const items = await fetchSuggest(q, category);
                renderBox(box, input, items);
            }, 200));

            // when category changed: close box + optional refresh suggestions
            document.addEventListener('change', (e) => {
                const sel = e.target.closest('.item-category');
                if (!sel) return;

                const row = sel.closest('tr');
                const input = row?.querySelector('.item-name');
                const box = row?.querySelector('.suggestion-box');
                closeBox(box);

                if (input && input.value.trim().length >= 2) {
                    input.dispatchEvent(new Event('input'));
                }
            });

            // close on click outside
            document.addEventListener('click', (e) => {
                document.querySelectorAll('.suggestion-box').forEach(box => {
                    const wrapper = box.closest('.position-relative');
                    if (wrapper && !wrapper.contains(e.target)) closeBox(box);
                });
            });

            // close on esc
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.suggestion-box').forEach(closeBox);
                }
            });

        })();
    </script>

@endsection

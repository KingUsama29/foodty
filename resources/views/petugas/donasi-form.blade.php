@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'donasi'])
@endsection

@section('content')

    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-plus fa-lg text-primary me-3"></i>
                <div>
                    <h5 class="mb-1">Tambah Donasi</h5>
                    <small class="text-muted">Satu donatur bisa memiliki banyak item donasi</small>
                </div>
            </div>

            <a href="{{ route('petugas.data-donasi') }}" class="btn btn-secondary btn-sm rounded-pill px-3">Kembali</a>
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

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Donatur</label>

                        {{-- hidden buat dikirim ke backend --}}
                        <input type="hidden" name="donor_id" id="donor_id" value="{{ old('donor_id') }}" required>

                        <input type="text" id="donor_search" class="form-control"
                            placeholder="Ketik nama / no telp donatur..." autocomplete="off">

                        <div id="donor_results" class="list-group mt-2" style="display:none;"></div>

                        <small class="text-muted ms-1">Cari donatur lewat nama atau nomor telepon.</small>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label">Waktu Donasi (opsional)</label>
                        <input type="datetime-local" name="donated_at" class="form-control" value="{{ old('donated_at') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Bukti (opsional)</label>
                        <input type="file" name="evidence" class="form-control">
                        <small class="text-muted">jpg/png/pdf (max 2MB)</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Catatan Header (opsional)</label>
                        <input type="text" name="note" class="form-control" value="{{ old('note') }}"
                            placeholder="Contoh: diantar langsung ke gudang">
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="fw-semibold mb-0">Item Donasi</h6>
                    <button type="button" class="btn btn-success btn-sm rounded-pill px-3" id="btnAddItem">
                        + Tambah Item
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle" id="itemsTable">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Item</th>
                                <th>Kategori</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Kondisi</th>
                                <th>Expired</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- kalau old items ada --}}
                            @php $oldItems = old('items', [ [] ]); @endphp
                            @foreach ($oldItems as $i => $it)
                                <tr>
                                    <td>
                                        <input class="form-control" name="items[{{ $i }}][item_name]"
                                            value="{{ $it['item_name'] ?? '' }}" required>
                                    </td>
                                    <td>
                                        <select class="form-select" name="items[{{ $i }}][category]" required>
                                            <option value="pangan_kemasan" @selected(($it['category'] ?? '') === 'pangan_kemasan')>pangan_kemasan
                                            </option>
                                            <option value="pangan_segar" @selected(($it['category'] ?? '') === 'pangan_segar')>pangan_segar</option>
                                            <option value="non_pangan" @selected(($it['category'] ?? '') === 'non_pangan')>non_pangan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" min="0.01" class="form-control"
                                            name="items[{{ $i }}][qty]" value="{{ $it['qty'] ?? 1 }}" required>
                                    </td>
                                    <td>
                                        <input class="form-control" name="items[{{ $i }}][unit]"
                                            value="{{ $it['unit'] ?? 'pcs' }}" required>
                                    </td>
                                    <td>
                                        <select class="form-select" name="items[{{ $i }}][condition]" required>
                                            <option value="baik" @selected(($it['condition'] ?? '') === 'baik')>baik</option>
                                            <option value="rusak_ringan" @selected(($it['condition'] ?? '') === 'rusak_ringan')>rusak_ringan</option>
                                            <option value="tidak_layak" @selected(($it['condition'] ?? '') === 'tidak_layak')>tidak_layak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="date" class="form-control"
                                            name="items[{{ $i }}][expired_at]"
                                            value="{{ $it['expired_at'] ?? '' }}">
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 btnRemove">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-success rounded-pill px-4" type="submit">Simpan</button>
                    <a href="{{ route('petugas.data-donasi') }}" class="btn btn-secondary rounded-pill px-4">Batal</a>
                </div>
            </form>

        </div>
    </div>

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
                <td><input class="form-control" name="items[${index}][item_name]" required></td>
                <td>
                    <select class="form-select" name="items[${index}][category]" required>
                        <option value="pangan_kemasan">pangan_kemasan</option>
                        <option value="pangan_segar">pangan_segar</option>
                        <option value="non_pangan">non_pangan</option>
                    </select>
                </td>
                <td><input type="number" step="0.01" min="0.01" class="form-control" name="items[${index}][qty]" value="1" required></td>
                <td><input class="form-control" name="items[${index}][unit]" value="pcs" required></td>
                <td>
                    <select class="form-select" name="items[${index}][condition]" required>
                        <option value="baik">baik</option>
                        <option value="rusak_ringan">rusak_ringan</option>
                        <option value="tidak_layak">tidak_layak</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="items[${index}][expired_at]"></td>
                <td class="text-end">
                    <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 btnRemove">Hapus</button>
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
                    if (e.target.classList.contains('btnRemove')) {
                        e.target.closest('tr').remove();
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

                    // reset kalau input dihapus
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

                // klik di luar menutup dropdown hasil
                document.addEventListener('click', (e) => {
                    if (!donorResults.contains(e.target) && e.target !== donorInput) {
                        hideResults();
                    }
                });
            }
        })();
    </script>


@endsection

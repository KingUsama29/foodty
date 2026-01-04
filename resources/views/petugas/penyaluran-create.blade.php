@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'penyaluran'])
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                    style="width:44px;height:44px;">
                    <i class="fa-solid fa-truck-ramp-box"></i>
                </div>
                <div>
                    <h5 class="mb-1">Tambah Penyaluran</h5>
                    <small class="text-muted">Ambil dari stok cabang dan catat movement <span
                            class="fw-semibold">OUT</span></small>
                </div>
            </div>

            <a href="{{ route('petugas.data-penyaluran') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <div class="fw-semibold mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i>Gagal:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('petugas.penyaluran.store') }}" id="formPenyaluran">
                @csrf

                {{-- STEP 1 --}}
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="fw-semibold">
                        <i class="fa-solid fa-1 me-2 text-primary"></i>Data Penyaluran
                    </div>
                    <span class="badge text-bg-light border">
                        <i class="fa-solid fa-location-dot me-1"></i> Cabang ID: {{ $cabangId }}
                    </span>
                </div>

                <div class="row g-3">
                    <div class="col-lg-8">
                        <label class="form-label fw-semibold">Pilih Food Request (Approved)</label>
                        <select class="form-select" name="food_request_id" id="foodRequestSelect" required>
                            <option value="">- pilih -</option>
                            @foreach ($requests as $r)
                                <option value="{{ $r->id }}" @selected(old('food_request_id', $selectedRequest->id ?? '') == $r->id)>
                                    #{{ $r->id }} • {{ $r->user->name ?? '-' }} • kebutuhan: {{ $r->main_needs }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">
                            <i class="fa-solid fa-link me-1"></i>Penyaluran akan ditautkan ke <code>food_requests</code>.
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">Jadwal Pengantaran</label>
                        <input type="datetime-local" class="form-control" name="scheduled_at"
                            value="{{ old('scheduled_at') }}" required>
                        <div class="form-text">
                            <i class="fa-regular fa-clock me-1"></i>Estimasi waktu petugas mengantar ke alamat penerima.
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan Penyaluran (opsional)</label>
                        <input class="form-control" name="note" value="{{ old('note') }}" maxlength="500"
                            placeholder="Contoh: titip satpam / hubungi sebelum sampai / dsb.">
                    </div>
                </div>

                {{-- Ringkasan penerima (auto update via JS) --}}
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-header bg-white">
                        <div class="fw-semibold">
                            <i class="fa-solid fa-user-check me-2 text-primary"></i>Ringkasan Penerima
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="recipientEmpty" class="text-muted">
                            <i class="fa-solid fa-circle-info me-1"></i>Pilih food request dulu untuk melihat data penerima.
                        </div>

                        <div id="recipientBox" class="row g-3 d-none">
                            <div class="col-md-4">
                                <div class="text-muted small mb-1">Nama</div>
                                <div class="fw-semibold" id="rvName">-</div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-muted small mb-1">No. Telp</div>
                                <div class="fw-semibold" id="rvPhone">-</div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-muted small mb-1">Kebutuhan Utama</div>
                                <div class="fw-semibold" id="rvNeeds">-</div>
                            </div>
                            <div class="col-12">
                                <div class="text-muted small mb-1">Alamat</div>
                                <div class="fw-semibold" id="rvAddress">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- STEP 2 --}}
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="fw-semibold">
                        <i class="fa-solid fa-2 me-2 text-primary"></i>Item Penyaluran
                    </div>
                    <button type="button" class="btn btn-success btn-sm rounded-pill px-3" id="btnAdd">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Item
                    </button>
                </div>

                <div class="alert alert-info small mb-3">
                    <i class="fa-solid fa-circle-info me-1"></i>
                    Pilih <b>barang</b> lalu pilih <b>batch/expired</b>. Qty otomatis dibatasi sesuai stok tersedia.
                    Unit mengikuti stok (dikunci).
                </div>

                <div class="table-responsive">
                    <table class="table align-middle" id="itemsTable">
                        <thead class="table-light">
                            <tr>
                                <th>Barang</th>
                                <th style="width:260px;">Batch / Expired</th>
                                <th style="width:160px;">Qty</th>
                                <th style="width:140px;">Unit</th>
                                <th>Catatan Item</th>
                                <th class="text-end" style="width:120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $oldItems = old('items', [
                                    [
                                        'warehouse_item_id' => '',
                                        'expired_at' => '',
                                        'qty' => 1,
                                        'unit' => 'pcs',
                                        'note' => '',
                                    ],
                                ]);
                            @endphp

                            @foreach ($oldItems as $i => $it)
                                <tr>
                                    <td>
                                        <select class="form-select form-select-sm itemSelect"
                                            name="items[{{ $i }}][warehouse_item_id]" required>
                                            <option value="">- pilih barang -</option>
                                            @foreach ($stocks->groupBy('warehouse_item_id') as $wid => $rows)
                                                @php $name = $rows->first()->warehouseItem->name ?? 'Item'; @endphp
                                                <option value="{{ $wid }}" @selected(($it['warehouse_item_id'] ?? '') == $wid)>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="text-muted small mt-1 stockHint d-none">
                                            <i class="fa-solid fa-box-open me-1"></i><span class="hintText">-</span>
                                        </div>
                                    </td>

                                    <td>
                                        <select class="form-select form-select-sm expSelect"
                                            name="items[{{ $i }}][expired_at]">
                                            <option value="">- pilih batch -</option>
                                        </select>
                                    </td>

                                    <td>
                                        <input type="number" step="0.01" min="0.01"
                                            class="form-control form-control-sm qtyInput"
                                            name="items[{{ $i }}][qty]" value="{{ $it['qty'] ?? 1 }}"
                                            required>
                                    </td>

                                    <td>
                                        <input class="form-control form-control-sm unitInput"
                                            name="items[{{ $i }}][unit]" value="{{ $it['unit'] ?? 'pcs' }}"
                                            readonly required>
                                    </td>

                                    <td>
                                        <input class="form-control form-control-sm"
                                            name="items[{{ $i }}][note]" value="{{ $it['note'] ?? '' }}"
                                            maxlength="500" placeholder="Opsional: catatan item">
                                    </td>

                                    <td class="text-end">
                                        <button type="button"
                                            class="btn btn-outline-danger btn-sm rounded-pill px-3 btnRemove">
                                            <i class="fa-solid fa-trash me-1"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex flex-wrap gap-2">
                    <button class="btn btn-success rounded-pill px-4" type="submit">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan
                    </button>
                    <a href="{{ route('petugas.data-penyaluran') }}"
                        class="btn btn-secondary rounded-pill px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>

    @php
        // Data request untuk ringkasan penerima (tanpa API)
        $requestsJs = $requests
            ->map(function ($r) {
                return [
                    'id' => $r->id,
                    'name' => $r->user->name ?? null,
                    'phone' => $r->user->no_telp ?? null,
                    'address' => $r->address_detail ?? null,
                    'needs' => $r->main_needs ?? null,
                ];
            })
            ->values()
            ->toArray();

        // Data stok untuk batch dropdown
        $stocksJs = $stocks
            ->map(function ($s) {
                return [
                    'warehouse_item_id' => $s->warehouse_item_id,
                    'expired_at' => $s->expired_at ? $s->expired_at->format('Y-m-d') : null,
                    'qty' => (float) $s->qty,
                    'unit' => $s->unit,
                    'label' =>
                        ($s->expired_at ? $s->expired_at->format('Y-m-d') : 'tanpa expired') .
                        ' • stok: ' .
                        (float) $s->qty .
                        ' ' .
                        $s->unit,
                ];
            })
            ->values()
            ->toArray();
    @endphp

    <script>
        (function() {
            const requests = @json($requestsJs);
            const stocks = @json($stocksJs);

            const tbody = document.querySelector('#itemsTable tbody');
            const btnAdd = document.getElementById('btnAdd');

            // ringkasan penerima
            const foodSel = document.getElementById('foodRequestSelect');
            const recipientEmpty = document.getElementById('recipientEmpty');
            const recipientBox = document.getElementById('recipientBox');
            const rvName = document.getElementById('rvName');
            const rvPhone = document.getElementById('rvPhone');
            const rvAddress = document.getElementById('rvAddress');
            const rvNeeds = document.getElementById('rvNeeds');

            function renderRecipient(foodRequestId) {
                const r = requests.find(x => String(x.id) === String(foodRequestId));
                if (!r) {
                    recipientBox.classList.add('d-none');
                    recipientEmpty.classList.remove('d-none');
                    rvName.textContent = '-';
                    rvPhone.textContent = '-';
                    rvAddress.textContent = '-';
                    rvNeeds.textContent = '-';
                    return;
                }
                recipientEmpty.classList.add('d-none');
                recipientBox.classList.remove('d-none');
                rvName.textContent = r.name ?? '-';
                rvPhone.textContent = r.phone ?? '-';
                rvAddress.textContent = r.address ?? '-';
                rvNeeds.textContent = r.needs ?? '-';
            }

            foodSel.addEventListener('change', () => renderRecipient(foodSel.value));
            renderRecipient(foodSel.value);

            function reindex() {
                tbody.querySelectorAll('tr').forEach((tr, idx) => {
                    tr.querySelectorAll('input, select').forEach(el => {
                        if (!el.name) return;
                        el.name = el.name.replace(/items\[\d+\]/, `items[${idx}]`);
                    });
                });
            }

            function rowsByWid(wid) {
                return stocks.filter(s => String(s.warehouse_item_id) === String(wid));
            }

            function getAvailableStock(wid, expiredAt) {
                return stocks.find(s =>
                    String(s.warehouse_item_id) === String(wid) &&
                    String(s.expired_at ?? '') === String(expiredAt ?? '')
                );
            }

            function fillExpired(tr) {
                const itemSel = tr.querySelector('.itemSelect');
                const expSel = tr.querySelector('.expSelect');
                const unitInp = tr.querySelector('.unitInput');
                const qtyInp = tr.querySelector('.qtyInput');
                const hintWrap = tr.querySelector('.stockHint');
                const hintText = tr.querySelector('.hintText');

                const wid = itemSel.value;
                expSel.innerHTML = `<option value="">- pilih batch -</option>`;
                hintWrap.classList.add('d-none');
                hintText.textContent = '-';

                if (!wid) return;

                const rows = rowsByWid(wid);

                rows.forEach(r => {
                    const opt = document.createElement('option');
                    opt.value = r.expired_at ?? '';
                    opt.textContent = r.label;
                    expSel.appendChild(opt);
                });

                // set unit default sesuai stok pertama
                if (rows[0] && rows[0].unit) unitInp.value = rows[0].unit;

                // jika sudah ada pilihan expired (old), keep. kalau belum, pilih yang pertama setelah placeholder
                if (!expSel.value && expSel.options.length > 1) expSel.selectedIndex = 1;

                // update hint berdasarkan expired terpilih
                const stock = getAvailableStock(wid, expSel.value);
                if (stock) {
                    hintWrap.classList.remove('d-none');
                    hintText.textContent = `Stok tersedia: ${stock.qty} ${stock.unit}`;
                    // clamp qty
                    const max = parseFloat(stock.qty);
                    const val = parseFloat(qtyInp.value || 0);
                    if (val > max) qtyInp.value = max;
                }
            }

            function onExpiredChange(tr) {
                const itemSel = tr.querySelector('.itemSelect');
                const expSel = tr.querySelector('.expSelect');
                const unitInp = tr.querySelector('.unitInput');
                const qtyInp = tr.querySelector('.qtyInput');
                const hintWrap = tr.querySelector('.stockHint');
                const hintText = tr.querySelector('.hintText');

                if (!itemSel.value) return;

                const stock = getAvailableStock(itemSel.value, expSel.value);
                if (!stock) return;

                unitInp.value = stock.unit;
                hintWrap.classList.remove('d-none');
                hintText.textContent = `Stok tersedia: ${stock.qty} ${stock.unit}`;

                const max = parseFloat(stock.qty);
                const val = parseFloat(qtyInp.value || 0);
                if (val > max) qtyInp.value = max;
            }

            function newRow() {
                const tpl = tbody.querySelector('tr');
                const tr = document.createElement('tr');
                tr.innerHTML = tpl.innerHTML;
                tbody.appendChild(tr);
                reindex();
                return tr;
            }

            tbody.addEventListener('change', (e) => {
                const tr = e.target.closest('tr');
                if (!tr) return;

                if (e.target.classList.contains('itemSelect')) {
                    fillExpired(tr);
                }
                if (e.target.classList.contains('expSelect')) {
                    onExpiredChange(tr);
                }
            });

            btnAdd.addEventListener('click', () => {
                const tr = newRow();
                fillExpired(tr);
            });

            tbody.addEventListener('click', (e) => {
                if (e.target.classList.contains('btnRemove') || e.target.closest('.btnRemove')) {
                    e.target.closest('tr').remove();
                    if (tbody.querySelectorAll('tr').length === 0) {
                        const tr = newRow();
                        fillExpired(tr);
                    }
                    reindex();
                }
            });

            // clamp qty realtime
            tbody.addEventListener('input', function(e) {
                if (!e.target.classList.contains('qtyInput')) return;

                const tr = e.target.closest('tr');
                const qtyInput = e.target;
                const itemSel = tr.querySelector('.itemSelect');
                const expSel = tr.querySelector('.expSelect');

                if (!itemSel.value) return;

                const stock = getAvailableStock(itemSel.value, expSel.value);
                if (!stock) return;

                const max = parseFloat(stock.qty);
                const val = parseFloat(qtyInput.value || 0);
                if (val > max) qtyInput.value = max;
            });

            // init existing rows
            tbody.querySelectorAll('tr').forEach(tr => fillExpired(tr));
        })();
    </script>
@endsection

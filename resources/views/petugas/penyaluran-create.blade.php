@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'penyaluran'])
@endsection

@section('content')

    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div>
                <h5 class="mb-1">Tambah Penyaluran</h5>
                <small class="text-muted">Ambil dari stok cabang dan catat movement out</small>
            </div>
            <a href="{{ route('petugas.data-penyaluran') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
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

    @if (session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('petugas.penyaluran.store') }}">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Pilih Food Request (approved)</label>
                        <select class="form-select" name="food_request_id" required>
                            <option value="">- pilih -</option>
                            @foreach ($requests as $r)
                                <option value="{{ $r->id }}" @selected(old('food_request_id', $selectedRequest->id ?? '') == $r->id)>
                                    #{{ $r->id }} • {{ $r->user->name ?? '-' }} • kebutuhan: {{ $r->main_needs }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Penyaluran akan ditautkan ke food_requests.</small>
                    </div>
                    @if ($selectedRequest)
                        <div class="alert alert-info mt-3">
                            <div class="fw-semibold mb-1">Ringkasan Penerima</div>
                            <div>Nama: <b>{{ $selectedRequest->user->name ?? '-' }}</b></div>
                            <div>No HP: <b>{{ $selectedRequest->user->no_telp ?? '-' }}</b></div>
                            <div>Alamat: <b>{{ $selectedRequest->address_detail }}</b></div>
                            <div>Kebutuhan: <b>{{ $selectedRequest->main_needs }}</b></div>
                            <div class="text-muted small mt-1">Petugas tinggal isi item stok & jadwal.</div>
                        </div>
                    @endif

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jadwal Pengiriman</label>
                        <input type="datetime-local" class="form-control" name="scheduled_at"
                            value="{{ old('scheduled_at') }}" required>
                        <small class="text-muted">Tentukan kapan akan dikirim.</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Catatan (opsional)</label>
                        <input class="form-control" name="note" value="{{ old('note') }}" maxlength="500">
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="fw-semibold">Item Penyaluran</div>
                    <button type="button" class="btn btn-success btn-sm rounded-pill px-3" id="btnAdd">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Item
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm align-middle" id="itemsTable">
                        <thead class="table-light">
                            <tr>
                                <th>Barang (stok)</th>
                                <th style="width:190px;">Batch/Expired</th>
                                <th style="width:140px;">Qty</th>
                                <th style="width:120px;">Unit</th>
                                <th class="text-end" style="width:120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $oldItems = old('items', [
                                    ['warehouse_item_id' => '', 'expired_at' => '', 'qty' => 1, 'unit' => 'pcs'],
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
                                            name="items[{{ $i }}][qty]" value="{{ $it['qty'] ?? 1 }}" required>
                                    </td>
                                    <td>
                                        <input class="form-control form-control-sm unitInput"
                                            name="items[{{ $i }}][unit]" value="{{ $it['unit'] ?? 'pcs' }}"
                                            required>
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

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-success rounded-pill px-4" type="submit">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan
                    </button>
                    <a href="{{ route('petugas.data-penyaluran') }}" class="btn btn-secondary rounded-pill px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>

    @php
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
            const stocks = @json($stocksJs);

            const tbody = document.querySelector('#itemsTable tbody');
            const btnAdd = document.getElementById('btnAdd');

            function reindex() {
                tbody.querySelectorAll('tr').forEach((tr, idx) => {
                    tr.querySelectorAll('input, select').forEach(el => {
                        if (!el.name) return;
                        el.name = el.name.replace(/items\[\d+\]/, `items[${idx}]`);
                    });
                });
            }

            function fillExpired(tr) {
                const itemSel = tr.querySelector('.itemSelect');
                const expSel = tr.querySelector('.expSelect');
                const unitInp = tr.querySelector('.unitInput');

                const wid = itemSel.value;
                expSel.innerHTML = `<option value="">- pilih batch -</option>`;
                if (!wid) return;

                const rows = stocks.filter(s => String(s.warehouse_item_id) === String(wid));

                rows.forEach(r => {
                    const opt = document.createElement('option');
                    opt.value = r.expired_at ?? '';
                    opt.textContent = r.label;
                    expSel.appendChild(opt);
                });

                if (rows[0] && rows[0].unit) unitInp.value = rows[0].unit;
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
                if (e.target.classList.contains('itemSelect')) {
                    fillExpired(e.target.closest('tr'));
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

            tbody.querySelectorAll('tr').forEach(tr => fillExpired(tr));

            function getAvailableStock(wid, expiredAt) {
                return stocks.find(s =>
                    String(s.warehouse_item_id) === String(wid) &&
                    String(s.expired_at ?? '') === String(expiredAt ?? '')
                );
            }

            document.querySelector('#itemsTable').addEventListener('input', function(e) {
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

                if (val > max) {
                    qtyInput.value = max;
                    alert(`⚠️ Stok tidak cukup!\n\nStok tersedia: ${max} ${stock.unit}`);
                }
            });
        })();
    </script>



@endsection

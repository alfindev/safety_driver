@extends('layouts.app')
@section('title', 'Check Sheet Baru')
@section('topbar_icon', '📋')
@section('topbar_title', 'Check Sheet Baru')
@section('topbar_sub', \Carbon\Carbon::today()->isoFormat('dddd, D MMM Y'))

@section('topbar_extra')
{{-- Progress Bar --}}
<div class="bg-[#163a7a] px-4 pb-2.5 flex items-center gap-3">
    <span class="text-[10px] text-white/40 font-bold uppercase tracking-wide whitespace-nowrap">Progress</span>
    <div class="flex gap-1 flex-1" id="progressDots">
        @for($i = 0; $i < 6; $i++)
        <div class="flex-1 h-1 rounded-full bg-white/15 transition-all duration-300"
             id="dot-{{ $i }}"></div>
        @endfor
    </div>
    <span class="text-[11px] text-white/50 font-bold whitespace-nowrap" id="progressPct">0%</span>
</div>
@endsection

@section('content')
<form method="POST" action="{{ route('checksheet.store') }}"
      enctype="multipart/form-data" id="checksheetForm">
@csrf

<div class="p-4 space-y-4 pb-28">

{{-- ══════════════════════════════════════
     SECTION 1 — DATA PENGEMUDI
══════════════════════════════════════ --}}
<div class="section-block" data-section="0">
    <div class="flex items-center gap-2 mb-2.5">
        <div class="w-5 h-5 bg-[#0d2b5e] text-white text-[10px] font-black rounded flex items-center justify-center">1</div>
        <span class="text-[11px] font-black text-[#0d2b5e] uppercase tracking-widest">Data Pengemudi</span>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-3.5 space-y-3 shadow-sm border-t-4 border-t-[#1e4fa3]">

        {{-- Pilih Driver --}}
        <div>
            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                Pilih Driver <span class="text-red-500">*</span>
            </label>
            <select name="user_id" required
                    class="w-full bg-[#eef3fb] border border-slate-200 rounded-xl px-3 py-2.5
                           text-sm outline-none focus:border-[#1e4fa3] focus:ring-2 focus:ring-blue-100">
                <option value="">-- Pilih Driver --</option>
                @foreach($drivers as $driver)
                <option value="{{ $driver->id }}">
                    {{ $driver->name }} ({{ $driver->employee_id }})
                </option>
                @endforeach
            </select>
        </div>

        {{-- Pilih Kendaraan --}}
        <div>
            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                Kendaraan <span class="text-red-500">*</span>
            </label>
            <select name="vehicle_id" required
                    class="w-full bg-[#eef3fb] border border-slate-200 rounded-xl px-3 py-2.5
                           text-sm outline-none focus:border-[#1e4fa3] focus:ring-2 focus:ring-blue-100">
                <option value="">-- Pilih Kendaraan --</option>
                @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}">
                    {{ $vehicle->plate_number }} — {{ $vehicle->type }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal & Waktu --}}
        <div class="grid grid-cols-2 gap-2.5">
            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                    Tanggal <span class="text-red-500">*</span>
                </label>
                <input type="date" name="check_date"
                       value="{{ date('Y-m-d') }}" required
                       class="w-full bg-[#eef3fb] border border-slate-200 rounded-xl px-3 py-2.5
                              text-sm outline-none focus:border-[#1e4fa3]">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                    Jam Berangkat
                </label>
                <input type="time" name="departure_time"
                       class="w-full bg-[#eef3fb] border border-slate-200 rounded-xl px-3 py-2.5
                              text-sm outline-none focus:border-[#1e4fa3]">
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     SECTION 2-6 — 40 ITEM CHECKLIST
══════════════════════════════════════ --}}
@php
$sectionIcons = [
    'MAN'              => ['icon' => '👷', 'color' => 'border-t-[#22a05e]', 'num' => 1],
    'Machine'          => ['icon' => '🚛', 'color' => 'border-t-[#1e4fa3]', 'num' => 2],
    'Material'         => ['icon' => '🧰', 'color' => 'border-t-[#22a05e]', 'num' => 3],
    'Document Control' => ['icon' => '📄', 'color' => 'border-t-[#1e4fa3]', 'num' => 4],
    'Environment'      => ['icon' => '🌿', 'color' => 'border-t-[#22a05e]', 'num' => 5],
    'Safety Warning'   => ['icon' => '⚠️', 'color' => 'border-t-amber-500',  'num' => 6],
];
@endphp

@foreach($items as $category => $categoryItems)
@php $cfg = $sectionIcons[$category] ?? ['icon' => '📋', 'color' => 'border-t-slate-400', 'num' => 2]; @endphp

<div class="section-block" data-section="{{ $cfg['num'] - 1 }}">
    <div class="flex items-center gap-2 mb-2.5">
        <div class="w-5 h-5 bg-[#0d2b5e] text-white text-[10px] font-black rounded flex items-center justify-center">
            {{ $cfg['num'] }}
        </div>
        <span class="text-[11px] font-black text-[#0d2b5e] uppercase tracking-widest">
            {{ $cfg['icon'] }} {{ $category }}
        </span>
        <span class="ml-auto text-[10px] font-bold text-slate-400">
            {{ $categoryItems->count() }} item
        </span>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden {{ $cfg['color'] }} border-t-4">
        @foreach($categoryItems as $i => $item)
        <div class="check-item p-3 {{ $i < $categoryItems->count() - 1 ? 'border-b border-slate-100' : '' }}"
             id="item-{{ $item->id }}">

            {{-- Item Header --}}
            <div class="flex items-start gap-2.5">
                {{-- Nomor --}}
                <div class="w-6 h-6 rounded-lg bg-slate-100 text-slate-500 text-[10px] font-black
                            flex items-center justify-center flex-shrink-0 mt-0.5">
                    {{ $item->item_number }}
                </div>

                {{-- Nama & Standar --}}
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-bold text-slate-800">{{ $item->item_name }}</div>
                    <div class="text-xs text-slate-400 mt-0.5 leading-relaxed">{{ $item->standard }}</div>
                </div>

                {{-- OK / NOK / NA Toggle --}}
                <div class="flex gap-1 flex-shrink-0">
                    @foreach(['ok' => ['OK','emerald'], 'nok' => ['NOK','red'], 'na' => ['N/A','slate']] as $status => $sc)
                    <label class="cursor-pointer">
                        <input type="radio"
                               name="results[{{ $item->id }}][status]"
                               value="{{ $status }}"
                               class="sr-only peer"
                               onchange="updateItemStatus({{ $item->id }}, '{{ $status }}')"
                               {{ $status === 'na' ? 'checked' : '' }}>
                        <div class="px-2 py-1 rounded-lg border-2 text-[10px] font-black
                                    border-slate-200 text-slate-400
                                    peer-checked:border-{{ $sc[1] }}-500
                                    peer-checked:bg-{{ $sc[1] }}-500
                                    peer-checked:text-white
                                    transition-all select-none">
                            {{ $sc[0] }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- NOK Notes + Foto (muncul kalau NOK) --}}
            <div class="nok-detail hidden mt-2.5 space-y-2" id="nok-{{ $item->id }}">
                <input type="text"
                       name="results[{{ $item->id }}][notes]"
                       placeholder="Keterangan masalah yang ditemukan..."
                       class="w-full bg-red-50 border border-red-200 rounded-xl px-3 py-2
                              text-xs outline-none focus:border-red-400 text-red-900">
                <label class="flex items-center gap-2 px-3 py-2 bg-red-50 border border-dashed
                              border-red-200 rounded-xl cursor-pointer hover:bg-red-100 transition-all">
                    <span class="text-base">📷</span>
                    <span class="text-xs font-bold text-red-500">Tambah Foto Bukti</span>
                    <input type="file" name="photos[{{ $item->id }}]"
                           accept="image/*" capture="environment" class="hidden"
                           onchange="showPhotoPreview(this, {{ $item->id }})">
                </label>
                <img id="preview-{{ $item->id }}"
                     class="hidden w-full rounded-xl object-cover max-h-40 border border-red-200">
            </div>
        </div>
        @endforeach
    </div>
</div>
@endforeach

{{-- ══════════════════════════════════════
     SECTION TERAKHIR — CATATAN & TTD
══════════════════════════════════════ --}}
<div class="section-block" data-section="5">
    <div class="flex items-center gap-2 mb-2.5">
        <div class="w-5 h-5 bg-[#0d2b5e] text-white text-[10px] font-black rounded flex items-center justify-center">7</div>
        <span class="text-[11px] font-black text-[#0d2b5e] uppercase tracking-widest">Catatan & Tanda Tangan</span>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-3.5 shadow-sm border-t-4 border-t-[#22a05e] space-y-3">
        <div>
            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                Catatan Tambahan
            </label>
            <textarea name="notes" rows="3"
                      placeholder="Kondisi khusus, temuan, atau hal yang perlu diperhatikan..."
                      class="w-full bg-[#eef3fb] border border-slate-200 rounded-xl px-3 py-2.5
                             text-sm outline-none focus:border-[#1e4fa3] resize-none leading-relaxed">
            </textarea>
        </div>

        {{-- Summary Status --}}
        <div class="bg-slate-50 rounded-xl p-3 border border-slate-200">
            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Ringkasan Hasil</div>
            <div class="grid grid-cols-3 gap-2 text-center">
                <div>
                    <div class="text-xl font-black text-emerald-600" id="count-ok">0</div>
                    <div class="text-[10px] text-slate-400 font-bold">OK</div>
                </div>
                <div>
                    <div class="text-xl font-black text-red-600" id="count-nok">0</div>
                    <div class="text-[10px] text-slate-400 font-bold">NOK</div>
                </div>
                <div>
                    <div class="text-xl font-black text-slate-400" id="count-na">40</div>
                    <div class="text-[10px] text-slate-400 font-bold">Belum</div>
                </div>
            </div>
        </div>

        {{-- GPS Info --}}
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 bg-blue-50 border border-blue-200
                         text-blue-600 text-[10px] font-bold px-2.5 py-1.5 rounded-full">
                📍 GPS Otomatis
            </span>
            <span class="text-[11px] text-slate-400">Lokasi dicatat saat submit</span>
        </div>
        <input type="hidden" name="latitude" id="lat">
        <input type="hidden" name="longitude" id="lng">
    </div>
</div>

</div>{{-- end content padding --}}

{{-- ══════════════════════════════════════
     BOTTOM ACTION BAR
══════════════════════════════════════ --}}
{{-- BOTTOM ACTION BAR --}}
<div class="fixed bottom-16 left-1/2 -translate-x-1/2 w-full max-w-[430px]
            bg-white border-t border-slate-200 px-4 py-3 z-40 shadow-lg">
    <div class="grid grid-cols-2 gap-2.5">
        <button type="submit" name="action" value="draft"
                class="py-4 bg-white border-2 border-slate-200 text-slate-600
                       font-bold text-sm rounded-2xl shadow-sm active:scale-95
                       transition-transform">
            💾 Simpan Draft
        </button>
        <button type="submit" name="action" value="submit"
                class="py-4 bg-[#0d2b5e] text-white font-black text-sm
                       rounded-2xl shadow-lg active:scale-95 transition-transform">
            📤 Submit
        </button>
    </div>
</div>

</form>
@endsection

@push('scripts')
<script>
// ── Counter
let counts = { ok: 0, nok: 0, na: 40 };

function updateItemStatus(itemId, status) {
    const el = document.getElementById('item-' + itemId);
    const nokDetail = document.getElementById('nok-' + itemId);

    // Update visual
    el.classList.remove('bg-emerald-50', 'bg-red-50');
    if (status === 'ok')  el.classList.add('bg-emerald-50');
    if (status === 'nok') el.classList.add('bg-red-50');

    // Tampilkan/sembunyikan field NOK
    if (status === 'nok') {
        nokDetail.classList.remove('hidden');
    } else {
        nokDetail.classList.add('hidden');
    }

    // Hitung ulang counter
    recountStatuses();
}

function recountStatuses() {
    const radios = document.querySelectorAll('input[type="radio"][name*="[status]"]:checked');
    counts = { ok: 0, nok: 0, na: 0 };
    radios.forEach(r => { if (counts[r.value] !== undefined) counts[r.value]++; });

    document.getElementById('count-ok').textContent  = counts.ok;
    document.getElementById('count-nok').textContent = counts.nok;
    document.getElementById('count-na').textContent  = counts.na;

    updateProgress();
}

// ── Progress Bar
function updateProgress() {
    const total   = counts.ok + counts.nok + counts.na;
    const checked = counts.ok + counts.nok;
    const pct     = Math.round((checked / total) * 100);

    document.getElementById('progressPct').textContent = pct + '%';

    const dots = document.querySelectorAll('[id^="dot-"]');
    dots.forEach((dot, i) => {
        const threshold = (i + 1) * (100 / dots.length);
        dot.classList.remove('bg-white/15', 'bg-[#22a05e]', 'bg-blue-400');
        if (pct >= threshold) {
            dot.classList.add('bg-[#22a05e]');
        } else if (pct >= threshold - (100 / dots.length)) {
            dot.classList.add('bg-blue-400');
        } else {
            dot.classList.add('bg-white/15');
        }
    });
}

// ── Preview foto
function showPhotoPreview(input, itemId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('preview-' + itemId);
            img.src = e.target.result;
            img.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// ── GPS
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(pos => {
        document.getElementById('lat').value = pos.coords.latitude;
        document.getElementById('lng').value = pos.coords.longitude;
    });
}

// ── Init
recountStatuses();
</script>
@endpush
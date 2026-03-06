@extends('layouts.app')
@section('title', 'Detail Laporan')
@section('topbar_title', 'Detail Check Sheet')
@section('topbar_sub', $sheet->check_date->format('d M Y'))

@section('content')
<div class="p-4 space-y-4">
    
    {{-- STATUS CARD --}}
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-4 text-white">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-xs text-slate-400">Status Laporan</p>
                <h2 class="text-2xl font-extrabold uppercase">
                    @if($sheet->overall_status == 'ok') ✅ OK
                    @elseif($sheet->overall_status == 'nok') ⚠️ NOT OK
                    @else ⏳ DRAFT
                    @endif
                </h2>
            </div>
            <div class="text-right">
                <p class="text-xs text-slate-400">Kendaraan</p>
                <p class="font-bold">{{ $sheet->vehicle->plate_number }}</p>
            </div>
        </div>
    </div>

    {{-- DRIVER INFO --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 flex items-center gap-3">
        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-2xl">🧑</div>
        <div>
            <h3 class="font-bold text-slate-800">{{ $sheet->driver->name }}</h3>
            <p class="text-xs text-slate-500">Driver • {{ $sheet->route }}</p>
        </div>
    </div>

    {{-- CHECK ITEMS --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200">
        <h3 class="font-bold text-slate-800 mb-3">Item Pemeriksaan</h3>
        <div class="space-y-2">
            @foreach($sheet->checkItems as $item)
            <div class="flex justify-between items-center text-sm border-b border-slate-100 pb-2">
                <span class="text-slate-600">{{ $item->item_name }}</span>
                @if($item->status == 'ok')
                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-bold">OK</span>
                @elseif($item->status == 'nok')
                    <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-bold">NOK</span>
                @else
                    <span class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded text-xs">-</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- PHOTOS --}}
    @if($sheet->photos->count() > 0)
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200">
        <h3 class="font-bold text-slate-800 mb-3">Lampiran Foto</h3>
        <div class="grid grid-cols-3 gap-2">
            @foreach($sheet->photos as $photo)
            <img src="{{ Storage::url($photo->file_path) }}" class="rounded-lg aspect-square object-cover bg-slate-100">
            @endforeach
        </div>
    </div>
    @endif

    {{-- ACTIONS --}}
    <div class="grid grid-cols-2 gap-3">
        @if($sheet->overall_status === 'draft')
        <button onclick="submitReport({{ $sheet->id }})" class="w-full py-3 bg-green-600 text-white font-bold rounded-xl text-sm shadow-md">
            ✅ Submit Laporan
        </button>
        @endif
        
        <button onclick="sendEmail({{ $sheet->id }})" class="w-full py-3 bg-blue-600 text-white font-bold rounded-xl text-sm shadow-md">
            📧 Kirim Email
        </button>
    </div>

    {{-- Signature Placeholder --}}
    @if($sheet->signature_path)
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 text-center">
        <p class="text-xs text-slate-500 mb-2">Tanda Tangan Driver</p>
        <img src="{{ Storage::url($sheet->signature_path) }}" class="h-16 mx-auto">
    </div>
    @endif
</div>

<script>
    async function submitReport(id) {
        if(confirm('Yakin submit laporan ini? Setelah submit tidak bisa diedit.')) {
            const res = await fetch(`/checksheet/${id}/submit`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} });
            alert('Laporan berhasil disubmit!');
            location.reload();
        }
    }

    async function sendEmail(id) {
        const res = await fetch(`/checksheet/${id}/send-email`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} });
        alert('Laporan berhasil dikirim ke email PIC!');
    }
</script>
@endsection
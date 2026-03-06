@extends('layouts.app')
@section('topbar_title', 'Safety Check Sheet')
@section('topbar_sub', 'Selamat datang, ' . session('user_name'))

@section('content')
<div class="p-4 space-y-4">

    {{-- WELCOME BANNER --}}
    <div class="bg-gradient-to-br from-[#0d2b5e] to-[#163a7a] rounded-2xl p-4 relative overflow-hidden">
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-5xl opacity-10">🛡️</div>
        <h2 class="text-white font-bold text-lg leading-snug">
            {{ \Carbon\Carbon::today()->isoFormat('dddd, D MMMM Y') }}
        </h2>
        <p class="text-white/50 text-xs mt-1">
            {{ $stats['today_reports'] }} laporan masuk hari ini
        </p>
    </div>

    {{-- STAT GRID --}}
    <div class="grid grid-cols-2 gap-2.5">
        <div class="bg-white border border-slate-200 rounded-2xl p-3.5 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide mb-1">Driver Aktif</p>
            <p class="text-3xl font-extrabold text-[#1a7a4a]">{{ $stats['active_drivers'] }}</p>
            <p class="text-xs text-slate-400 mt-1">dari {{ $stats['total_drivers'] }} terdaftar</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-3.5 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide mb-1">Laporan Hari Ini</p>
            <p class="text-3xl font-extrabold text-[#0d2b5e]">{{ $stats['today_reports'] }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ $stats['draft_reports'] }} belum submit</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-3.5 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide mb-1">Status NOK</p>
            <p class="text-3xl font-extrabold text-amber-600">{{ $stats['nok_today'] }}</p>
            <p class="text-xs text-slate-400 mt-1">perlu tindak lanjut</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-3.5 shadow-sm">
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide mb-1">Dokumen Exp.</p>
            <p class="text-3xl font-extrabold text-red-600">{{ $stats['expiring_sim'] }}</p>
            <p class="text-xs text-slate-400 mt-1">SIM hampir habis</p>
        </div>
    </div>

    {{-- QUICK ACTION --}}
    <a href="{{ route('checksheet.create') }}"
       class="flex items-center justify-center gap-2 w-full py-4 bg-[#0d2b5e]
              text-white font-extrabold rounded-2xl text-sm shadow-lg">
        ➕ Buat Check Sheet Baru
    </a>

    {{-- LAPORAN TERBARU --}}
    <div class="flex items-center justify-between">
        <p class="text-xs font-extrabold text-[#0d2b5e] uppercase tracking-widest">
            Laporan Terbaru
        </p>
        <a href="{{ route('checksheet.index') }}" class="text-xs font-bold text-blue-600">
            Lihat Semua
        </a>
    </div>

    <div class="space-y-2">
    @foreach($recentReports as $report)
        <div class="bg-white border border-slate-200 rounded-xl p-3 flex
                    items-center gap-3 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center
                        justify-center text-lg flex-shrink-0">🧑</div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800 truncate">
                    {{ $report->driver->name }}
                </p>
                <p class="text-xs text-slate-400 mt-0.5 truncate">
                    {{ $report->vehicle->plate_number }} •
                    {{ $report->check_date->format('d M') }} •
                    {{ $report->route }}
                </p>
            </div>
            @if($report->overall_status === 'ok')
                <span class="text-xs font-extrabold bg-emerald-100 text-emerald-700
                             px-2.5 py-1 rounded-full">✓ OK</span>
            @elseif($report->overall_status === 'nok')
                <span class="text-xs font-extrabold bg-red-100 text-red-700
                             px-2.5 py-1 rounded-full">⚠ NOK</span>
            @else
                <span class="text-xs font-extrabold bg-amber-100 text-amber-700
                             px-2.5 py-1 rounded-full">⏳ Draft</span>
            @endif
        </div>
    @endforeach
    </div>

</div>
@endsection
g
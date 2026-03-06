@extends('layouts.app')

@section('title', 'Pengaturan')
@section('topbar_title', 'Settings')
@section('topbar_sub', 'Manajemen Data Master')

@section('content')
<div class="p-4 space-y-4">
    
    {{-- CARD MENU --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        {{-- Menu Data Driver --}}
        <a href="{{ route('driver.index') }}" class="flex items-center justify-between p-4 hover:bg-slate-50 border-b border-slate-100 transition-all active:bg-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-xl">
                    👨‍✈️
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Data Driver</h3>
                    <p class="text-xs text-slate-500">Kelola data pengemudi & SIM</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-slate-400">
                <span class="text-xs font-bold hidden sm:inline">Lihat</span>
                <span class="text-lg">→</span>
            </div>
        </a>

        {{-- Menu Data Kendaraan --}}
        <a href="{{ route('vehicle.index') }}" class="flex items-center justify-between p-4 hover:bg-slate-50 border-b border-slate-100 transition-all active:bg-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-xl">
                    🚚
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Data Kendaraan</h3>
                    <p class="text-xs text-slate-500">Kelola armada & STNK</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-slate-400">
                <span class="text-xs font-bold hidden sm:inline">Lihat</span>
                <span class="text-lg">→</span>
            </div>
        </a>

        {{-- Menu Laporan (Opsional, bisa diarahkan ke route laporan) --}}
        <a href="{{ route('checksheet.index') }}" class="flex items-center justify-between p-4 hover:bg-slate-50 transition-all active:bg-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-xl">
                    📊
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Riwayat Laporan</h3>
                    <p class="text-xs text-slate-500">Lihat semua check sheet</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-slate-400">
                <span class="text-xs font-bold hidden sm:inline">Lihat</span>
                <span class="text-lg">→</span>
            </div>
        </a>
    </div>

    {{-- CARD INFO APLIKASI --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200">
        <h3 class="font-bold text-slate-800 mb-2">Informasi Aplikasi</h3>
        <div class="text-xs text-slate-500 space-y-1">
            <p><strong>Nama:</strong> Safety Driver Check Sheet</p>
            <p><strong>Versi:</strong> 1.0.0</p>
            <p><strong>Database:</strong> SQLite (Lokal)</p>
        </div>
        <div class="mt-3 pt-3 border-t border-slate-100">
            <p class="text-[10px] text-slate-400 leading-relaxed">
                Aplikasi ini berjalan secara offline. Data disimpan secara lokal di perangkat Android. Pastikan melakukan backup data berkala melalui menu ekspor jika tersedia.
            </p>
        </div>
    </div>

    {{-- TOMBOL LOGOUT TAMBAHAN (OPSIONAL) --}}
    <div class="mt-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-3 bg-red-50 text-red-600 font-bold rounded-xl text-sm border border-red-100 hover:bg-red-100 transition-all">
                🚪 Keluar dari Aplikasi
            </button>
        </form>
    </div>

</div>
@endsection
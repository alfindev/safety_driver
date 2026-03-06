<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Safety Driver')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen flex justify-center">
<div class="w-full max-w-[430px] min-h-screen bg-[#f4f7fc] flex flex-col">

    {{-- TOP BAR --}}
    <div class="bg-[#0d2b5e] sticky top-0 z-50 shadow-lg">
        <div class="flex items-center justify-between px-4 py-3">

            {{-- Kiri: ikon + judul --}}
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-[#22a05e] rounded-xl flex items-center justify-center text-base shadow">
                    @yield('topbar_icon', '🛡️')
                </div>
                <div>
                    <div class="text-white font-bold text-sm leading-tight">
                        @yield('topbar_title', 'Safety Driver')
                    </div>
                    <div class="text-white/50 text-xs">
                        @yield('topbar_sub', '')
                    </div>
                </div>
            </div>

            {{-- Kanan: tombol keluar --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="bg-white/10 border border-white/15 text-white/80
                               text-xs font-bold px-2.5 py-1 rounded-lg">
                    Keluar
                </button>
            </form>

        </div>

        {{-- Extra topbar (progress bar, dll) --}}
        @yield('topbar_extra')
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
    <div class="mx-4 mt-3 bg-emerald-50 border border-emerald-200 text-emerald-700
                text-sm rounded-xl px-4 py-3 flex items-center gap-2">
        ✅ {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mx-4 mt-3 bg-red-50 border border-red-200 text-red-700
                text-sm rounded-xl px-4 py-3 flex items-center gap-2">
        ❌ {{ session('error') }}
    </div>
    @endif

    {{-- CONTENT --}}
    <div class="flex-1 pb-20">
        @yield('content')
    </div>

    {{-- BOTTOM NAV --}}
    <nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-[430px]
                bg-white border-t border-slate-200 flex z-50 shadow-lg">

        <a href="{{ route('dashboard') }}"
           class="flex-1 flex flex-col items-center py-2.5 gap-0.5
                  {{ request()->routeIs('dashboard') ? 'text-[#0d2b5e]' : 'text-slate-400' }}">
            <span class="text-xl">🏠</span>
            <span class="text-[10px] font-bold">Home</span>
        </a>

        <a href="{{ route('checksheet.index') }}"
           class="flex-1 flex flex-col items-center py-2.5 gap-0.5
                  {{ request()->routeIs('checksheet.index') ? 'text-[#0d2b5e]' : 'text-slate-400' }}">
            <span class="text-xl">📋</span>
            <span class="text-[10px] font-bold">Laporan</span>
        </a>

        <a href="{{ route('checksheet.create') }}"
           class="flex-1 flex flex-col items-center py-2.5 gap-0.5
                  {{ request()->routeIs('checksheet.create') ? 'text-[#0d2b5e]' : 'text-slate-400' }}">
            <span class="text-xl">➕</span>
            <span class="text-[10px] font-bold">Check Sheet</span>
        </a>

        <a href="{{ route('setting') }}"
           class="flex-1 flex flex-col items-center py-2.5 gap-0.5
                  {{ request()->routeIs('setting*') ? 'text-[#0d2b5e]' : 'text-slate-400' }}">
            <span class="text-xl">⚙️</span>
            <span class="text-[10px] font-bold">Setting</span>
        </a>

    </nav>

</div>

@stack('scripts')
</body>
</html>
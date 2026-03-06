<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen flex justify-center">
<div class="w-full max-w-md min-h-screen bg-white flex flex-col">

    {{-- HERO --}}
    <div class="bg-[#0d2b5e] px-6 pt-14 pb-9 relative overflow-hidden">
        <div class="w-14 h-14 bg-[#22a05e] rounded-2xl flex items-center
                    justify-center text-3xl shadow-lg mb-5">🛡️</div>
        <h1 class="text-white font-bold text-2xl leading-tight">
            Safety <em class="text-emerald-300">Driver</em><br>Check Sheet
        </h1>
        <p class="text-white/50 text-xs mt-2">
            PT. Sakura Java Indonesia
        </p>
    </div>

    {{-- FORM --}}
    <div class="p-6 flex-1">
        <span class="inline-flex items-center gap-1.5 bg-blue-50 border
              border-blue-200 text-blue-700 text-xs font-bold px-3 py-1.5
              rounded-full mb-5">🔐 Login PPIC / Safety Officer</span>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm
                    rounded-xl p-3 mb-4">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-400
                             uppercase tracking-wider mb-1.5">Username</label>
                <input type="text" name="username"
                       class="w-full bg-slate-50 border border-slate-200
                              rounded-xl px-4 py-3 text-sm outline-none
                              focus:border-blue-500 focus:ring-2
                              focus:ring-blue-100"
                       placeholder="Masukkan username" required>
            </div>
            <div class="mb-5">
                <label class="block text-xs font-bold text-slate-400
                             uppercase tracking-wider mb-1.5">Password</label>
                <input type="password" name="password"
                       class="w-full bg-slate-50 border border-slate-200
                              rounded-xl px-4 py-3 text-sm outline-none
                              focus:border-blue-500 focus:ring-2
                              focus:ring-blue-100"
                       placeholder="••••••••" required>
            </div>
            <button type="submit"
                    class="w-full py-4 bg-[#0d2b5e] text-white font-extrabold
                           rounded-2xl text-sm shadow-lg">
                Masuk →
            </button>
        </form>
    </div>
</div>
</body>
</html>

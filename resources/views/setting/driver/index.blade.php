@extends('layouts.app')
@section('title', 'Data Driver')
@section('topbar_title', 'Manajemen Driver')

@section('content')
<div class="p-4">
    <div class="mb-4">
        <a href="{{ route('driver.create') }}" class="w-full flex items-center justify-center gap-2 py-3 bg-[#0d2b5e] text-white font-bold rounded-xl shadow-md">
            ➕ Tambah Driver Baru
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 text-sm rounded-xl p-3 mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="space-y-3">
        @forelse($drivers as $driver)
        <div class="bg-white rounded-xl p-3 shadow-sm border border-slate-200 flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-lg overflow-hidden flex-shrink-0">
                @if($driver->photo_path)
                    <img src="{{ Storage::disk('local')->exists($driver->photo_path) ? 'data:image/jpeg;base64,'.base64_encode(Storage::disk('local')->get($driver->photo_path)) : 'https://via.placeholder.com/100' }}" class="w-full h-full object-cover">
                @else
                    🧑
                @endif
            </div>

            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-slate-800 text-sm">{{ $driver->name }}</h3>
                <p class="text-xs text-slate-500">{{ $driver->employee_id }}</p>
                
                <div class="flex gap-1 mt-1 flex-wrap">
                    @foreach($driver->vehicles as $v)
                        <span class="text-[10px] bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded-full font-bold">
                            {{ $v->plate_number }}
                        </span>
                    @endforeach
                </div>
            </div>

            <span class="text-xs px-2 py-1 rounded-full font-bold uppercase {{ $driver->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $driver->status }}
            </span>

            <div class="flex gap-1">
                <a href="{{ route('driver.edit', $driver->id) }}" class="text-blue-500 text-xs font-bold p-1 border border-blue-200 rounded-lg bg-blue-50">Edit</a> 
                <form action="{{ route('driver.destroy', $driver->id) }}" method="POST" onsubmit="return confirm('Hapus driver ini?')">
                    @csrf @method('DELETE')
                    <button class="text-red-500 text-xs font-bold p-1 border border-red-200 rounded-lg bg-red-50">🗑️</button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center py-10 text-slate-400">
            <span class="text-4xl">👨‍✈️</span>
            <p class="mt-2 text-sm">Belum ada data driver.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $drivers->links() }}
    </div>
</div>
@endsection
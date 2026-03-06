@extends('layouts.app')
@section('title', 'Data Kendaraan')
@section('topbar_title', 'Data Kendaraan')

@section('content')
<div class="p-4">
    <div class="mb-4">
        <a href="{{ route('vehicle.create') }}" class="w-full flex items-center justify-center gap-2 py-3 bg-[#0d2b5e] text-white font-bold rounded-xl shadow-md">
            ➕ Tambah Kendaraan
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 text-sm rounded-xl p-3 mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="space-y-3">
        @forelse($vehicles as $vehicle)
        <div class="bg-white rounded-xl p-3 shadow-sm border border-slate-200 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-lg flex-shrink-0">
                🚚
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-slate-800 text-sm">{{ $vehicle->plate_number }}</h3>
                <p class="text-xs text-slate-500 truncate">{{ $vehicle->type }} - {{ $vehicle->brand }} ({{ $vehicle->year }})</p>
            </div>
            
            <span class="text-[10px] px-2 py-1 rounded-full font-bold uppercase
                {{ $vehicle->status == 'active' ? 'bg-green-100 text-green-700' : '' }}
                {{ $vehicle->status == 'maintenance' ? 'bg-amber-100 text-amber-700' : '' }}
                {{ $vehicle->status == 'inactive' ? 'bg-red-100 text-red-700' : '' }}">
                {{ $vehicle->status }}
            </span>

            <div class="flex gap-1">
                <a href="{{ route('vehicle.edit', $vehicle->id) }}" class="text-blue-500 text-xs font-bold p-1 border border-blue-200 rounded-lg bg-blue-50">Edit</a>
                
                <form action="{{ route('vehicle.destroy', $vehicle->id) }}" method="POST" onsubmit="return confirm('Hapus kendaraan ini?')">
                    @csrf @method('DELETE')
                    <button class="text-red-500 text-xs font-bold p-1 border border-red-200 rounded-lg bg-red-50">🗑️</button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center py-10 text-slate-400">
            <span class="text-4xl">🚫</span>
            <p class="mt-2 text-sm">Belum ada data kendaraan.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $vehicles->links() }}
    </div>
</div>
@endsection
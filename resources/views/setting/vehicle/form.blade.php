@extends('layouts.app')
@section('title', isset($vehicle) ? 'Edit Kendaraan' : 'Tambah Kendaraan')
@section('topbar_title', isset($vehicle) ? 'Edit Kendaraan' : 'Tambah Kendaraan')

@section('content')
<div class="p-4">
    <form action="{{ isset($vehicle) ? route('vehicle.update', $vehicle->id) : route('vehicle.store') }}" method="POST" class="space-y-4">
        @csrf 
        @if(isset($vehicle)) @method('PUT') @endif

        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 space-y-3">
            <h3 class="font-bold text-slate-800">Identitas Kendaraan</h3>
            
            <div>
                <label class="text-xs font-bold text-slate-500">Nomor Polisi</label>
                <input type="text" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number ?? '') }}" required 
                       class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm uppercase" placeholder="B 1234 XYZ">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-bold text-slate-500">Tipe</label>
                    <select name="type" class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
                        <option value="Truk" {{ old('type', $vehicle->type ?? '') == 'Truk' ? 'selected' : '' }}>Truk</option>
                        <option value="Minibus" {{ old('type', $vehicle->type ?? '') == 'Minibus' ? 'selected' : '' }}>Minibus</option>
                        <option value="Pick Up" {{ old('type', $vehicle->type ?? '') == 'Pick Up' ? 'selected' : '' }}>Pick Up</option>
                        <option value="Sedan" {{ old('type', $vehicle->type ?? '') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                        <option value="Lainnya" {{ old('type', $vehicle->type ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500">Merek</label>
                    <input type="text" name="brand" value="{{ old('brand', $vehicle->brand ?? '') }}" 
                           class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm" placeholder="Toyota">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-bold text-slate-500">Tahun</label>
                    <input type="number" name="year" value="{{ old('year', $vehicle->year ?? '') }}" 
                           class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm" placeholder="2022">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500">Status</label>
                    <select name="status" class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
                        <option value="active" {{ old('status', $vehicle->status ?? '') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="maintenance" {{ old('status', $vehicle->status ?? '') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="inactive" {{ old('status', $vehicle->status ?? '') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 space-y-3">
            <h3 class="font-bold text-slate-800">Dokumen (Opsional)</h3>
            
            <div>
                <label class="text-xs font-bold text-slate-500">Nomor STNK</label>
                <input type="text" name="stnk_number" value="{{ old('stnk_number', $vehicle->stnk_number ?? '') }}" 
                       class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
            </div>
             <div>
                <label class="text-xs font-bold text-slate-500">STNK Berlaku s/d</label>
                <input type="date" name="stnk_expires_at" value="{{ old('stnk_expires_at', $vehicle->stnk_expires_at ?? '') }}" 
                       class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
            </div>
        </div>

        <button type="submit" class="w-full py-4 bg-[#22a05e] text-white font-extrabold rounded-2xl text-sm shadow-lg">
            💾 Simpan Data Kendaraan
        </button>
    </form>
</div>
@endsection
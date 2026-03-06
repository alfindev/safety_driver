@extends('layouts.app')
@section('title', isset($driver) ? 'Edit Driver' : 'Tambah Driver')
@section('topbar_title', isset($driver) ? 'Edit Driver' : 'Tambah Driver')

@section('content')
<div class="p-4">
    {{-- Action form berubah tergantung mode --}}
    <form action="{{ isset($driver) ? route('driver.update', $driver->id) : route('driver.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf 
        @if(isset($driver)) 
            @method('PUT') 
        @endif
        
        {{-- Identitas --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 space-y-3">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <span class="text-lg">🆔</span> Identitas
            </h3>
            
            <div>
                <label class="text-xs font-bold text-slate-500">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $driver->name ?? '') }}" required class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-bold text-slate-500">ID Karyawan</label>
                    <input type="text" name="employee_id" value="{{ old('employee_id', $driver->employee_id ?? '') }}" required class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500">Username</label>
                    <input type="text" name="username" value="{{ old('username', $driver->username ?? '') }}" required class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
                </div>
            </div>

            {{-- Opsi: Password (Kosongkan jika tidak ingin ganti) --}}
            @if(isset($driver))
            <div>
                <label class="text-xs font-bold text-slate-500">Password Baru</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
            </div>
            @endif
        </div>

        {{-- SIM --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 space-y-3">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <span class="text-lg">🪪</span> SIM
            </h3>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-bold text-slate-500">No. SIM</label>
                    <input type="text" name="sim_number" value="{{ old('sim_number', $driver->sim_number ?? '') }}" class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500">Golongan</label>
                    <select name="sim_class" class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
                        <option value="">Pilih</option>
                        <option value="A" {{ old('sim_class', $driver->sim_class ?? '') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B1" {{ old('sim_class', $driver->sim_class ?? '') == 'B1' ? 'selected' : '' }}>B1</option>
                        <option value="B2" {{ old('sim_class', $driver->sim_class ?? '') == 'B2' ? 'selected' : '' }}>B2</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label class="text-xs font-bold text-slate-500">Masa Berlaku SIM</label>
                <input type="date" name="sim_expires_at" value="{{ old('sim_expires_at', $driver->sim_expires_at ?? '') }}" class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
            </div>
        </div>

        {{-- Kendaraan Ditugaskan --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 space-y-3">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <span class="text-lg">🚛</span> Kendaraan Ditugaskan
            </h3>
            
            <div class="grid grid-cols-2 gap-2">
                @foreach($vehicles as $v)
                <label class="flex items-center gap-2 bg-slate-50 rounded-lg p-2 cursor-pointer border border-slate-100 hover:border-blue-300">
                    <input type="checkbox" name="vehicles[]" value="{{ $v->id }}" 
                           class="rounded text-blue-600" 
                           {{ isset($driver) && $driver->vehicles->contains($v->id) ? 'checked' : '' }}>
                    <span class="text-sm font-bold text-slate-700">{{ $v->plate_number }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Upload Foto --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 space-y-3">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <span class="text-lg">📸</span> Dokumen Foto
            </h3>
            
            <div>
                <label class="text-xs font-bold text-slate-500">Foto Driver</label>
                {{-- Tampilkan foto saat ini jika ada --}}
                @if(isset($driver) && $driver->photo_path)
                <div class="mb-2">
                    <img src="{{ Storage::disk('local')->exists($driver->photo_path) ? 'data:image/jpeg;base64,'.base64_encode(Storage::disk('local')->get($driver->photo_path)) : '' }}" class="h-16 rounded-lg border">
                </div>
                @endif
                <input type="file" name="photo" accept="image/*" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
            </div>

            <div>
                <label class="text-xs font-bold text-slate-500">Foto SIM</label>
                @if(isset($driver) && $driver->sim_photo_path)
                <div class="mb-2">
                    <img src="{{ Storage::disk('local')->exists($driver->sim_photo_path) ? 'data:image/jpeg;base64,'.base64_encode(Storage::disk('local')->get($driver->sim_photo_path)) : '' }}" class="h-16 rounded-lg border">
                </div>
                @endif
                <input type="file" name="sim_photo" accept="image/*" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
            </div>
        </div>

        <button type="submit" class="w-full py-4 bg-[#22a05e] text-white font-extrabold rounded-2xl text-sm shadow-lg">
            💾 Simpan Perubahan
        </button>
    </form>
</div>
@endsection
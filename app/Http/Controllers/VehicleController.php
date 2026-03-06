<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VehicleController extends Controller
{
    /**
     * Tampilkan daftar kendaraan.
     */
    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(20);
        return view('setting.vehicle.index', compact('vehicles'));
    }

    /**
     * Tampilkan form tambah kendaraan.
     */
    public function create()
    {
        return view('setting.vehicle.form');
    }

    /**
     * Simpan kendaraan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number',
            'type'         => 'required|string|max:50',
            'brand'        => 'nullable|string|max:50',
            'year'         => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'status'       => 'required|in:active,maintenance,inactive',
            'stnk_number'  => 'nullable|string|max:50',
            'stnk_expires_at' => 'nullable|date',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('vehicle.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit kendaraan.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('setting.vehicle.form', compact('vehicle'));
    }

    /**
     * Update data kendaraan.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number,' . $vehicle->id,
            'type'         => 'required|string|max:50',
            'brand'        => 'nullable|string|max:50',
            'year'         => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'status'       => 'required|in:active,maintenance,inactive',
            'stnk_number'  => 'nullable|string|max:50',
            'stnk_expires_at' => 'nullable|date',
        ]);

        $vehicle->update($request->all());

        return redirect()->route('vehicle.index')
            ->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    /**
     * Hapus kendaraan.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicle.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }
}
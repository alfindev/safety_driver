<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $drivers = User::where('role', 'driver')
        ->with('vehicles')
        ->latest()->paginate(20);
    return view('setting.driver.index', compact('drivers'));
}


    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    $vehicles = Vehicle::where('status', 'active')->get();
    return view('setting.driver.form', compact('vehicles'));
}


    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'name'          => 'required|string|max:255',
        'employee_id'   => 'required|unique:users',
        'username'      => 'required|unique:users',
        'sim_expires_at'=> 'nullable|date',
        'photo'         => 'nullable|image|max:5120',
        'sim_photo'     => 'nullable|image|max:5120',
    ]);

    $data         = $request->except(['photo', 'sim_photo', 'vehicles', '_token']);
    $data['password'] = Hash::make($data['employee_id']);  // password default = ID
    $data['role']     = 'driver';

    if ($request->hasFile('photo'))
        $data['photo_path'] = $request->file('photo')->store('drivers/photos', 'local');
    if ($request->hasFile('sim_photo'))
        $data['sim_photo_path'] = $request->file('sim_photo')->store('drivers/sim', 'local');

    $driver = User::create($data);
    if ($request->has('vehicles'))
        $driver->vehicles()->sync($request->vehicles);

    return redirect()->route('driver.index')
        ->with('success', 'Driver berhasil ditambahkan!');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
public function edit(User $driver)
    {
        $vehicles = Vehicle::where('status', 'active')->get();
        return view('setting.driver.form', compact('driver', 'vehicles'));
    }

    /**
     * Update data driver.
     */
    public function update(Request $request, User $driver)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'employee_id'   => 'required|unique:users,employee_id,' . $driver->id,
            'username'      => 'required|unique:users,username,' . $driver->id,
            'sim_expires_at'=> 'nullable|date',
            'photo'         => 'nullable|image|max:5120',
            'sim_photo'     => 'nullable|image|max:5120',
        ]);

        // Ambil data kecuali file dan token
        $data = $request->except(['photo', 'sim_photo', 'vehicles', '_token', '_method', 'password']);

        // Update password hanya jika diisi (opsional)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle Upload Foto Baru (Hapus yang lama jika ada)
        if ($request->hasFile('photo')) {
            if ($driver->photo_path) Storage::disk('local')->delete($driver->photo_path);
            $data['photo_path'] = $request->file('photo')->store('drivers/photos', 'local');
        }
        
        if ($request->hasFile('sim_photo')) {
            if ($driver->sim_photo_path) Storage::disk('local')->delete($driver->sim_photo_path);
            $data['sim_photo_path'] = $request->file('sim_photo')->store('drivers/sim', 'local');
        }

        // Update data
        $driver->update($data);

        // Sync kendaraan
        $driver->vehicles()->sync($request->vehicles ?? []);

        return redirect()->route('driver.index')
            ->with('success', 'Data driver berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
public function destroy(User $driver)
{
    Storage::disk('local')
        ->delete([$driver->photo_path, $driver->sim_photo_path]);
    $driver->delete();
    return redirect()->route('driver.index')
        ->with('success', 'Driver dihapus.');
}

}

<?php
namespace App\Http\Controllers;

use App\Models\CheckItem;
use App\Models\CheckResult;
use App\Models\CheckSheet;
use App\Models\Photo;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckSheetController extends Controller
{
    // Form buat check sheet baru
    public function create()
    {
        $drivers  = User::where('role', 'driver')
                        ->where('status', 'active')
                        ->orderBy('name')
                        ->get();

        $vehicles = Vehicle::where('status', 'active')
                           ->orderBy('plate_number')
                           ->get();

        $items    = CheckItem::where('is_active', true)
                             ->orderBy('sort_order')
                             ->get()
                             ->groupBy('category');

        return view('checksheet.create', compact('drivers', 'vehicles', 'items'));
    }

    // Simpan check sheet (draft)
    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'check_date' => 'required|date',
        ]);

        // Buat header check sheet
        $sheet = CheckSheet::create([
            'user_id'           => $request->user_id,
            'vehicle_id'        => $request->vehicle_id,
            'check_date'        => $request->check_date,
            'departure_time'    => $request->departure_time,
            'estimated_arrival' => $request->estimated_arrival,
            'route'             => $request->route,
            'km_start'          => $request->km_start,
            'km_end'            => $request->km_end,
            'driver_fitness'    => $request->driver_fitness ?? 'fit',
            'overall_status'    => 'draft',
            'notes'             => $request->notes,
        ]);

        // Simpan hasil tiap item checklist
        $results = $request->input('results', []);
        foreach ($results as $itemId => $data) {
            CheckResult::create([
                'check_sheet_id' => $sheet->id,
                'check_item_id'  => $itemId,
                'status'         => $data['status'] ?? 'na',
                'notes'          => $data['notes'] ?? null,
            ]);
        }

        // Jika ada foto yang diupload
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $itemId => $file) {
                $path = $file->store('checksheets/' . $sheet->id, 'local');
                Photo::create([
                    'check_sheet_id' => $sheet->id,
                    'check_item_id'  => $itemId,
                    'label'          => 'Foto Item #' . $itemId,
                    'file_path'      => $path,
                ]);
            }
        }

        // Jika tombol submit (bukan draft)
        if ($request->action === 'submit') {
            $hasNok = CheckResult::where('check_sheet_id', $sheet->id)
                                 ->where('status', 'nok')
                                 ->exists();

            $sheet->update([
                'overall_status' => $hasNok ? 'nok' : 'ok',
                'submitted_at'   => now(),
            ]);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Check sheet berhasil disimpan!');
    }

    // List semua laporan
    public function index()
    {
        $sheets = CheckSheet::with(['driver', 'vehicle'])
                            ->latest()
                            ->paginate(20);

        return view('checksheet.index', compact('sheets'));
    }

    // Detail satu laporan
    public function show(int $id)
    {
        $sheet = CheckSheet::with([
            'driver', 'vehicle',
            'checkResults.checkItem',
            'photos'
        ])->findOrFail($id);

        $items = CheckItem::where('is_active', true)
                          ->orderBy('sort_order')
                          ->get()
                          ->groupBy('category');

        return view('checksheet.show', compact('sheet', 'items'));
    }
}
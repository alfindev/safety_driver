<?php

namespace App\Http\Controllers;

abstract class Controller
{
public function uploadPhoto(Request $request)
{
    $request->validate([
        'photo'           => 'required|image|max:10240',
        'check_sheet_id'  => 'required|exists:check_sheets,id',
        'label'           => 'required|string',
    ]);

    $path = $request->file('photo')
        ->store('checksheets/' . $request->check_sheet_id, 'local');

    Photo::create([
        'check_sheet_id' => $request->check_sheet_id,
        'check_item_id'  => $request->check_item_id,
        'label'          => $request->label,
        'file_path'      => $path,
    ]);

    return response()->json(['path' => $path, 'status' => 'uploaded']);
}

}

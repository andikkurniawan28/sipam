<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ResidentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Resident::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('resident.edit', $row->id);
                    $deleteUrl = route('resident.destroy', $row->id);

                    return '<div class="btn-group" role="group">
                                <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                                <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Hapus data ini?\')" style="display:inline-block;">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('resident.index');
    }

    public function create()
    {
        return view('resident.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:residents,name',
            'whatsapp' => 'required|string|max:20|unique:residents,whatsapp',
            'address' => 'required|string',
        ]);

        Resident::create([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
            'address' => $request->address,
        ]);

        return redirect()->route('resident.index')->with('success', 'Warga berhasil ditambahkan.');
    }

    public function edit(Resident $resident)
    {
        return view('resident.edit', compact('resident'));
    }

    public function update(Request $request, Resident $resident)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:residents,name,' . $resident->id,
            'whatsapp' => 'required|string|max:20|unique:residents,whatsapp,' . $resident->id,
            'address' => 'required|string',
        ]);

        $resident->update([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
            'address' => $request->address,
        ]);

        return redirect()->route('resident.index')->with('success', 'Warga berhasil diperbarui.');
    }

    public function destroy(Resident $resident)
    {
        $resident->delete();

        return redirect()->route('resident.index')->with('success', 'Warga berhasil dihapus.');
    }
}

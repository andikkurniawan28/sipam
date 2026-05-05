<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GatewayController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Gateway::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('gateway.edit', $row->id);
                    $deleteUrl = route('gateway.destroy', $row->id);

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

        return view('gateway.index');
    }

    public function create()
    {
        return view('gateway.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:gateways,name',
            'description' => 'nullable|string',
        ]);

        Gateway::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('gateway.index')->with('success', 'Gateway berhasil ditambahkan.');
    }

    public function edit(Gateway $gateway)
    {
        return view('gateway.edit', compact('gateway'));
    }

    public function update(Request $request, Gateway $gateway)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:gateways,name,' . $gateway->id,
            'description' => 'nullable|string',
        ]);

        $gateway->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('gateway.index')->with('success', 'Gateway berhasil diperbarui.');
    }

    public function destroy(Gateway $gateway)
    {
        $gateway->delete();

        return redirect()->route('gateway.index')->with('success', 'Gateway berhasil dihapus.');
    }
}

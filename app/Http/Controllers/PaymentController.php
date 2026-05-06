<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Payment;
use App\Models\Resident;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Payment::with(['resident', 'gateway', 'user']);

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('resident', function ($row) {
                    return $row->resident->name ?? '-';
                })

                ->addColumn('address', function ($row) {
                    return $row->resident->address ?? '-';
                })

                ->addColumn('gateway', function ($row) {
                    return $row->gateway->name ?? '-';
                })

                ->addColumn('user', function ($row) {
                    return $row->user->name ?? '-';
                })

                ->addColumn('period', function ($row) {
                    return $row->month . '/' . $row->year;
                })

                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d/m/Y H:i');
                })

                ->addColumn('action', function ($row) {
                    $showUrl = route('payment.show', $row->id);
                    $deleteUrl = route('payment.destroy', $row->id);

                    return '<div class="btn-group" role="group">
                                <a href="' . $showUrl . '" class="btn btn-sm btn-info">Tampilkan</a>
                                <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Hapus data ini?\')" style="display:inline-block;">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>';
                })
                ->filterColumn('resident', function ($query, $keyword) {
                    $query->whereHas('resident', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('resident', function ($query, $keyword) {
                    $query->whereHas('resident', function ($q) use ($keyword) {
                        $q->where('address', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('user', function ($query, $keyword) {
                    $query->whereHas('user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('payment.index');
    }

    public function create()
    {
        $residents = Resident::all();
        $gateways = Gateway::all();

        return view('payment.create', compact('residents', 'gateways'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'gateway_id'  => 'required|exists:gateways,id',
            'month'       => 'required|date_format:Y-m',
        ]);

        $period = $request->month;
        [$year, $month] = explode('-', $period);

        // 🔥 VALIDASI DOUBLE PAYMENT
        $exists = Payment::where('resident_id', $request->resident_id)
            ->where('month', (int) $month)
            ->where('year', (int) $year)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Warga sudah melakukan pembayaran pada periode tersebut.');
        }

        $fee = Setting::first()->fee;

        Payment::create([
            'code'        => 'PAY-' . strtoupper(Str::random(8)),
            'resident_id' => $request->resident_id,
            'gateway_id'  => $request->gateway_id,
            'user_id'     => Auth::id(),
            'month'       => (int) $month,
            'year'        => (int) $year,
            'total'       => $fee,
        ]);

        return redirect()->route('payment.index')->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function show(Payment $payment){
        return view('payment.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payment.index')->with('success', 'Pembayaran berhasil dihapus.');
    }
}

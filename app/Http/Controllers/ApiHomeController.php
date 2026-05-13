<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Resident;
use Illuminate\Http\Request;


class ApiHomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $now = now();

        // =========================
        // BASIC STATS
        // =========================
        $totalResident = Resident::count();

        $paymentThisMonth = Payment::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('total');

        $paidResidentThisMonth = Payment::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->distinct('resident_id')
            ->count('resident_id');

        $unpaidResidentThisMonth = $totalResident - $paidResidentThisMonth;

        // =========================
        // MATRIX (punya kamu)
        // =========================
        $year = $now->year;

        $residents = Resident::select('id', 'name', 'address')
            ->orderByRaw('LEFT(address, 1) ASC')
            ->orderByRaw('CAST(SUBSTRING(address, 2) AS UNSIGNED) ASC')
            ->get();

        $payments = Payment::where('year', $year)
            ->get()
            ->groupBy('resident_id');

        $data = $residents->map(function ($resident) use ($payments) {

            $months = [];

            for ($m = 1; $m <= 12; $m++) {
                $paid = optional($payments[$resident->id] ?? collect())
                    ->firstWhere('month', $m);

                $months[] = $paid ? 1 : 0;
            }

            return [
                'name' => $resident->name,
                'address' => $resident->address,
                'months' => $months
            ];
        });

        return response()->json([
            'year' => $year,

            // 🔥 INSIGHT BARU
            'summary' => [
                'total_resident' => $totalResident,
                'payment_this_month' => $paymentThisMonth,
                'paid_resident' => $paidResidentThisMonth,
                'unpaid_resident' => $unpaidResidentThisMonth,
            ],

            'data' => $data
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class MonthlyRecapController extends Controller
{
    public function index(){
        return view('monthly_recap.index');
    }

    public function process(Request $request){
        $period = $request->month;
        [$year, $month] = explode('-', $period);
        $payments = Payment::whereMonth('created_at', (int)$month)->whereYear('created_at', (int)$year)->orderBy('id', 'asc')->get();
        return view('monthly_recap.show', compact('payments', 'request'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Payment;
use Illuminate\Http\Request;

class MonthlyGatewayController extends Controller
{
    public function index(){
        $gateways = Gateway::all();
        return view('monthly_gateway.index', compact('gateways'));
    }

    public function process(Request $request){
        $period = $request->month;
        [$year, $month] = explode('-', $period);
        $gateway = Gateway::findOrFail($request->gateway_id);
        $payments = Payment::whereMonth('created_at', (int)$month)->whereYear('created_at', (int)$year)->where('gateway_id', $request->gateway_id)->orderBy('id', 'asc')->get();
        return view('monthly_gateway.show', compact('payments', 'request', 'gateway'));
    }
}

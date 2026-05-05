<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentPaymentController extends Controller
{
    public function index(){
        $residents = Resident::all();
        return view('resident_payment.index', compact('residents'));
    }

    public function process(Request $request){
        $resident = Resident::findOrFail($request->resident_id);
        $payments = Payment::where('resident_id', $request->resident_id)->orderBy('id', 'desc')->get();
        return view('resident_payment.show', compact('resident', 'payments'));
    }
}

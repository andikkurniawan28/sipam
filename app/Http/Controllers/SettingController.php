<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $setting = Setting::first();
        return view('setting.index', compact('setting'));
    }

    public function process(Request $request){
        $setting = Setting::first();
        $setting->update(['fee' => $request->fee]);
        return redirect()->back()->with('success', "Setting berhasil diupdate");
    }
}

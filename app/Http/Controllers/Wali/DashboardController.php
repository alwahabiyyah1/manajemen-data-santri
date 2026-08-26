<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $wali  = Auth::guard('wali')->user();
        $santri = $wali->santri()->with('dataSantri')->get();
        return view('wali.dashboard', compact('wali', 'santri'));
    }
}

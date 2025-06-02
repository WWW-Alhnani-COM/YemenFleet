<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // $totalMerchants = Merchant::count(); // عدد التجار
        return view('dashboard');
        // return view('dashboard', compact('totalMerchants'));
        // return view('dashboard');
    }


}

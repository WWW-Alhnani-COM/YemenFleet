<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
    public function __construct()
{
    if (!session()->has('dark_mode')) {
        session(['dark_mode' => false]);
    }
}
}

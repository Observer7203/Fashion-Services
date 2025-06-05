<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class CabinetController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('cabinet.index', compact('user'));
    }
}

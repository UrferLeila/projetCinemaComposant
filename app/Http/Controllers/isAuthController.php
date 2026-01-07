<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAuthController extends Controller
{
    public function index()
    {
        return response()->json(Auth::check(), 200);
    }
}

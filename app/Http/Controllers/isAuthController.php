<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAuthController extends Controller
{
    public function index()
    {
        // Return true if user is logged in, false otherwise
        return response()->json(Auth::check(), 200);
    }
}

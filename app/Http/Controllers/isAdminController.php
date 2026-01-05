<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class IsAdminController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Check if user exists, email is 'admin@ceff.ch', and id is 1
        $isAdmin = $user && $user->email === 'admin@ceff.ch' && $user->id === 1;

        return response()->json($isAdmin, 200);
    }
}

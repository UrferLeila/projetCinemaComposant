<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;


class TaskApiController extends Controller
{

    public function index()
    {
        $films = Film::all();
        return response()->json($films, 200);
    }

    public function store(Request $request)
    {
        
    }

    public function show(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        
    }

    public function destroy(string $id)
    {
        
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PaginaController extends Controller
{
    // En tu controlador PaginaController
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('index');
    }
}

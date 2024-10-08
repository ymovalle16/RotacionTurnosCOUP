<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Operator;

class PaginaController extends Controller
{
    // En tu controlador PaginaController
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $operators = Operator::all();
        return view('index', compact('operators'));
    }

    public function rotaciones()
    {
        return view('rotaciones');
    }

    public function ingresarOperador()
    {
        return view('ingresarOperador');
    }


}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Operator;
use App\Models\Status;

class PaginaController extends Controller
{
    // En tu controlador PaginaController
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $operators = Operator::all();
        $operators = Operator::with('status')->get();
        return view('index', compact('operators'));
    }

    public function rotaciones()
    {
        return view('rotaciones');
    }

    public function ingresarOperador()
    {
        $status = Status::all();
        return view('ingresarOperador', compact('status'));
    }

    public function ingresoOpe(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:5',
            'name' => 'required|string|max:155',
            'bus_code' => 'required|string|max:5',
            'id_status' => 'required|exists:statuses,id',
        ]);

        $operator = new Operator();
        $operator->code = $validatedData['code'];
        $operator->name = $validatedData['name'];
        $operator->bus_code = $validatedData['bus_code'];
        $operator->id_status = $validatedData['id_status'];

        if (Operator::where('code', $validatedData['code'])->exists()) {
            return redirect()->back()->withInput()->withErrors([
                'code' => 'Ya existe un operador con este código',
            ]);
        }

        $operator->save();
        return redirect()->route('ingresarOperador')->with('success', 'El ingreso ha sido exitoso');
    }

}

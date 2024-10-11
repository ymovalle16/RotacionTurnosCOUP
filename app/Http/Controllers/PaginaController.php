<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Operator;
use App\Models\StatusBus;
use App\Models\Status;
use App\Models\Bus;

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
        $buses = Bus::all();
        $buses = Bus::whereHas('statusBus', function ($query) {
            $query->where('status_name', '!=', 'Asignada');
        })->with('statusBus')->get();
        return view('index', compact('operators', 'buses'));
    }

    public function rotaciones()
    {
        return view('rotaciones');
    }

    public function ingresarOperador()
    {
        $status = Status::all();
        $availableBuses = Bus::whereHas('statusBus', function ($query) {
            $query->where('status_name', '=', 'Disponible');
        })->get();
        return view('ingresarOperador', compact('status', 'availableBuses'));
    }

    public function ingresoOpe(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:5',
            'name' => 'required|string|max:155',
            'bus_code' => 'required|exists:buses,code',
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

        // Actualiza el estado del bus a "Asignado"
        $bus = Bus::where('code', $validatedData['bus_code'])->first();
        $assignedStatus = StatusBus::where('status_name', 'Asignada')->first(); 
        $bus->status_id = $assignedStatus->id;
        $bus->save();

        $operator->save();
        return redirect()->route('ingresarOperador')->with('success', 'El ingreso ha sido exitoso');
    }

    public function ingresarBus()
    {
        $statusBus = StatusBus::all();
        return view('ingresarBus', compact('statusBus'));
    }

    public function ingresoBus(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:5',
            'status_id' => 'required|exists:statuses_bus,id',
        ]);

        $bus = new Bus();
        $bus->code = $validatedData['code'];
        $bus->status_id = $validatedData['status_id'];

        if (Bus::where('code', $validatedData['code'])->exists()) {
            return redirect()->back()->withInput()->withErrors([
                'code' => 'Ya existe un bus con este código',
            ]);
        }

        $bus->save();
        return redirect()->route('ingresarBus')->with('success', 'El ingreso ha sido exitoso');
    }

}

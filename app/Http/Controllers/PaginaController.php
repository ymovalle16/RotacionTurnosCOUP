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

        $operatorss = Operator::whereHas('status', function ($query) {
            $query->where('status_name', '=', 'Descanso');
        })->get();

        return view('index', compact('operators', 'buses', 'operatorss'));
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
    // dd($request->all());
    $validatedData = $request->validate([
        'code' => 'required|string|max:5',
        'name' => 'required|string|max:155',
        'bus_code' => 'required|string|max:20', // Permitir "Sin código" como válido
        'id_status' => 'required|exists:statuses,id',
    ]);

    // Manejar el bus_code
    $busCode = $validatedData['bus_code'] === 'Sin código' ? null : $validatedData['bus_code']; // Cambia 'Sin código' a null

    $operator = new Operator();
    $operator->code = $validatedData['code'];
    $operator->name = $validatedData['name'];
    $operator->bus_code = $busCode; // Usar $busCode
    $operator->id_status = $validatedData['id_status'];

    if (Operator::where('code', $validatedData['code'])->exists()) {
        return redirect()->back()->withInput()->withErrors([
            'code' => 'Ya existe un operador con este código',
        ]);
    }

    // Solo actualizar el estado del bus si se eligió un bus válido
    if ($busCode !== null) {
        $bus = Bus::where('code', $busCode)->first();

        if ($bus) { // Verificar si el bus existe
            $assignedStatus = StatusBus::where('status_name', 'Asignada')->first(); 
            $bus->status_id = $assignedStatus->id;
            $bus->save();
        }
    }

    $operator->save();
    return redirect()->route('index')->with('success', 'El ingreso del operador ha sido exitoso');
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
        return redirect()->route('index')->with('success', 'El ingreso del bus ha sido exitoso');
    }

    public function editarOpe($id)
    {
        $operator = Operator::find($id);
        $availableBuses = Bus::whereHas('statusBus', function ($query) {
            $query->where('status_name', '=', 'Disponible');
        })->get();
        $statusBus = StatusBus::all();
        $status = Status::all();
        return view('editarOpe', compact('operator', 'availableBuses', 'statusBus', 'status'));
    }

    public function actualizarOperador(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:155',
            'id_status' => 'sometimes|required|exists:statuses,id',
            'current_bus_status_id' => 'nullable|exists:statuses_bus,id',
            'new_bus_code' => 'nullable|exists:buses,code',
        ]);
    
        $operator = Operator::findOrFail($id);
        $operator->name = $validatedData['name'];
        $operator->id_status = $validatedData['id_status'];
    
        // Manejar la lógica del cambio de bus
        if ($request->change_bus === 'yes') {
            // Actualizar el estado del bus actual si existe
            if ($operator->bus_code && $request->current_bus_status_id) {
                $currentBus = Bus::where('code', $operator->bus_code)->first();
                if ($currentBus) {
                    $currentBus->status_id = $validatedData['current_bus_status_id'];
                    $currentBus->save();
                }
            }
    
            // Asignar nueva buseta al operador
            if ($request->new_bus_code) {
                $newBus = Bus::where('code', $validatedData['new_bus_code'])->first();
                if ($newBus) {
                    $assignedStatus = StatusBus::where('status_name', 'Asignada')->first();
                    if ($assignedStatus) {
                        $newBus->status_id = $assignedStatus->id;
                        $newBus->save();
                        $operator->bus_code = $validatedData['new_bus_code']; // Asignar el nuevo bus al operador
                    } else {
                        return redirect()->back()->withErrors(['error' => 'El estado "Asignada" no se encuentra en la base de datos.']);
                    }
                } else {
                    return redirect()->back()->withErrors(['error' => 'El nuevo bus no se encuentra en la base de datos.']);
                }
            } else {
                // Si no se selecciona nuevo bus, poner el campo bus_code a null
                $operator->bus_code = null;
            }
        } else if (!$operator->bus_code && $request->new_bus_code) {
            // Asignar bus a un operador que no tenía bus previamente
            $newBus = Bus::where('code', $validatedData['new_bus_code'])->first();
            if ($newBus) {
                $assignedStatus = StatusBus::where('status_name', 'Asignada')->first();
                if ($assignedStatus) {
                    $newBus->status_id = $assignedStatus->id;
                    $newBus->save();
                    $operator->bus_code = $validatedData['new_bus_code']; // Asignar el nuevo bus al operador
                } else {
                    return redirect()->back()->withErrors(['error' => 'El estado "Asignada" no se encuentra en la base de datos.']);
                }
            } else {
                return redirect()->back()->withErrors(['error' => 'El nuevo bus no se encuentra en la base de datos.']);
            }
        }
    
        // Guardar los cambios del operador
        $operator->save();
    
        // Redirigir a la página principal con un mensaje de éxito
        return redirect()->route('index')->with('success', 'Operador actualizado exitosamente');
    }

    public function editarBus($id)
    {
        $bus =  Bus::find($id);
        $statusBus = StatusBus::all();
        return view('editarBus', compact('bus', 'statusBus'));
    }

    public function actualizarBus(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'status_id' => 'required|exists:statuses_bus,id', 
        ]);

        // Encontrar el bus por su ID
        $bus = Bus::findOrFail($id);

        // Actualizar el estado del bus
        $bus->status_id = $validatedData['status_id'];

        // Guardar los cambios
        $bus->save();

        // Redirigir a la página principal con un mensaje de éxito
        return redirect()->route('index')->with('success', 'El estado del bus ha sido actualizado exitosamente');
    }

}

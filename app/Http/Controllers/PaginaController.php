<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Operator;
use App\Models\StatusBus;
use App\Models\Status;
use App\Models\Bus;
use App\Models\Basin;
use App\Models\Group;
use App\Models\NumTable;
use Illuminate\Support\Facades\Log;


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
    
        // Soltar al operador del grupo si su estado no es "disponible"
        $availableStatusId = Status::where('status_name', 'Disponible')->first()->id;
        if ($operator->id_status != $availableStatusId) {
            DB::table('groups')->where('operator_id', $id)->delete();
        }
    
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

    public function grupos()
    {
        // Obtener todos los grupos con su operador
        $groups = Group::with('operator')->get();
    
        // Obtener los operadores con estatus "Disponible"
        $operators = Operator::whereHas('status', function ($query) {
            $query->where('status_name', '=', 'Disponible');
        })->get();
    
        // Obtener todos los registros de cuencas (basins)
        $basins = Basin::all();
        
        // Crear un array de IDs de los operadores que ya están asignados a algún grupo
        $existingOperatorIds = $groups->pluck('operator_id')->toArray();
    
        // Pasar todos estos datos a la vista
        return view('grupos', compact('operators', 'basins', 'groups', 'existingOperatorIds'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'basin_id' => 'required|integer',
            'operator_id' => 'required|string',
        ]);

        // Obtén el operador por su código
        $operator = Operator::where('code', $request->operator_id)->first();

        // Si el operador no existe, muestra un mensaje de error
        if (!$operator) {
            return redirect()->route('grupos')->with('error', 'Operador no encontrado.');
        }

        // Verificar si el operador ya está asignado a otro grupo
        $existingGroup = Group::where('operator_id', $operator->id)->first();
        if ($existingGroup) {
            return redirect()->route('grupos')->with('error', 'Este operador ya está asignado a otro grupo.');
        }

        // Crea el grupo con el 'id' del operador encontrado
        $group = Group::create([
            'basin_id' => $request->basin_id,
            'operator_id' => $operator->id,  // Usa el 'id' del operador
        ]);

        return redirect()->route('grupos')->with('success', 'Operador agregado exitosamente.');
    }
 
    public function transfer(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'basin_id' => 'nullable'
        ]);

        try {
            $group = Group::findOrFail($request->group_id);

            // Si basin_id es null, significa "soltar"
            if ($request->basin_id === null) {
                // Aquí defines qué hacer al "soltar"
                // Por ejemplo, eliminar el grupo o cambiar su estado
                $group->delete(); // O lo que necesites hacer
            } else {
                // Cambiar de cuenca
                $group->basin_id = $request->basin_id;
                $group->save();
            }

            return response()->json([
                'success' => true, 
                'message' => $request->basin_id === null 
                    ? 'Operador soltado exitosamente' 
                    : 'Transferencia exitosa'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function asignaciones()
    {
        $groups = Group::all();
        $operators = Operator::all();
        $tabs = NumTable::all();

        return view('asignaciones', compact('groups, operators'));
    }

}

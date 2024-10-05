<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    public function login()
    {
        return view('funciones.login'); // Mostrar la vista de login si no está autenticado
    }    


    public function validacion(Request $request)
    {
        // Validación
        $request->validate([
            'identification' => 'required|string|max:255',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt(['identification' => $request->identification, 'password' => $request->password])) {
            // Autenticación exitosa
            return redirect()->route('index');  // Redirigir a la página principal
        }
        

        // Si la autenticación falla
        return back()->withErrors([
            'identification' => 'Las credenciales son incorrectas.',
        ])->onlyInput('identification');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login'); // Redirigir al login
    }
}


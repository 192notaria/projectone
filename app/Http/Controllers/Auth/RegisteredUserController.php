<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Ocupaciones;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $ocupaciones = Ocupaciones::orderBy("nombre", "ASC")->get();
        return view('auth.register', compact('ocupaciones'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apaterno' => ['required', 'string', 'max:255'],
            'amaterno' => ['required', 'string', 'max:255'],
            'genero' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'int', 'min:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => mb_strtoupper($request->name),
            'apaterno' => mb_strtoupper($request->apaterno),
            'amaterno' => mb_strtoupper($request->amaterno),
            'genero' => strtoupper($request->genero),
            'telefono' => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'ocupacion' => mb_strtoupper($request->ocupacion),
            'user_image' => "v3/src/assets/img/g-8.png",
            'email' => mb_strtolower($request->email),
            'password' => Hash::make("1234nITSS#ASDAWasd1"),
        ]);

        event(new Registered($user));

        // Auth::login($user);

        return redirect(route("login"))->with("success", "Pre registro exitoso, contacte con su administrador para obtener sus credenciales de acceso");
    }
}

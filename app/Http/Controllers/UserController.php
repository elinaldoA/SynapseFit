<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::with(['subscriptions.plan'])->paginate(10);
        return view('administrador.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('administrador.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6|confirmed',
            'height'     => 'required|numeric',
            'weight'     => 'required|numeric',
            'sex'        => 'required|in:male,female',
            'age'        => 'required|integer',
            'objetivo'   => 'required|string',
        ]);

        User::create([
            'name'       => $request->name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'height'     => $request->height,
            'weight'     => $request->weight,
            'sex'        => $request->sex,
            'age'        => $request->age,
            'objetivo'   => $request->objetivo,
        ]);

        return redirect()->route('usuarios')->with('success', 'Usuário criado com sucesso!');
    }

    public function edit(User $usuario)
    {
        return view('administrador.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $usuario->id,
            'height'     => 'required|numeric',
            'weight'     => 'required|numeric',
            'sex'        => 'required|in:male,female',
            'age'        => 'required|integer',
            'objetivo'   => 'required|string',
        ]);

        $usuario->update([
            'name'       => $request->name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'height'     => $request->height,
            'weight'     => $request->weight,
            'sex'        => $request->sex,
            'age'        => $request->age,
            'objetivo'   => $request->objetivo,
        ]);

        return redirect()->route('usuarios')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios')->with('success', 'Usuário removido com sucesso!');
    }
}

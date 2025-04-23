<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\BioimpedanceService;
use App\Services\DietaService;
use App\Services\TreinoService;

class UserController extends Controller
{
    protected $bioimpedanceService;
    protected $dietaService;
    protected $treinoService;

    public function __construct(BioimpedanceService $bioimpedanceService, DietaService $dietaService, TreinoService $treinoService)
    {
        $this->middleware('auth');
        $this->bioimpedanceService = $bioimpedanceService;
        $this->dietaService = $dietaService;
        $this->treinoService = $treinoService;
    }

    public function index(Request $request)
    {
        $query = User::with(['subscriptions.plan']);

        if ($request->filled('pesquisar')) {
            $termo = $request->get('pesquisar');
            $query->where(function ($q) use ($termo) {
                $q->where('name', 'like', '%' . $termo . '%')
                    ->orWhere('email', 'like', '%' . $termo . '%')
                    ->orWhere('cpf', 'like', '%' . $termo . '%');
            });
        }

        $usuarios = $query->paginate(10);

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

        $user = User::create([
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

        // Calcular e salvar bioimpedância
        $bioimpedanceData = $this->bioimpedanceService->calcularBioimpedancia($user);
        $user->bioimpedance()->create($bioimpedanceData);

        // Gerar e salvar dieta
        $this->dietaService->gerarDieta($user);

        // Gerar e salvar treino
        $this->treinoService->gerarTreino($user);

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

        $pesoAnterior = $usuario->weight;

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

        // Atualizar bioimpedância se o peso foi alterado
        if ($pesoAnterior != $usuario->weight) {
            $bioimpedanceData = $this->bioimpedanceService->calcularBioimpedancia($usuario);
            $existingBio = $usuario->bioimpedance()->first();
            if ($existingBio) {
                $existingBio->update($bioimpedanceData);
            } else {
                $usuario->bioimpedance()->create($bioimpedanceData);
            }

            // Atualizar dieta e treino com base no novo peso
            if ($usuario->dieta()->exists()) {
                $this->dietaService->atualizarDieta($usuario);
            }

            if ($usuario->workouts()->exists()) {
                $this->treinoService->atualizarTreino($usuario);
            }
        }

        return redirect()->route('usuarios')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios')->with('success', 'Usuário removido com sucesso!');
    }
}

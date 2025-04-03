<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\BioimpedanceService;
use App\Services\DietaService;
use App\Services\TreinoService;

class ProfileController extends Controller
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

    public function index()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|max:12|required_with:current_password',
            'password_confirmation' => 'nullable|min:8|max:12|required_with:new_password|same:new_password',
            'weight' => 'nullable|numeric|min:0',  // Validação para o peso
        ]);

        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');

        if (!is_null($request->input('current_password'))) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = $request->input('new_password');
            } else {
                return redirect()->back()->withInput();
            }
        }

        // Atualizar o peso, se fornecido
        if ($request->input('weight') !== null) {
            $user->weight = $request->input('weight');

            // Recalcular a bioimpedância
            $bioimpedanceData = $this->bioimpedanceService->calcularBioimpedancia($user);
            $existingBioimpedance = $user->bioimpedance()->first();

            if ($existingBioimpedance) {
                // Atualiza os dados de bioimpedância
                $existingBioimpedance->update($bioimpedanceData);
            } else {
                // Caso não exista, cria um novo registro
                $user->bioimpedance()->create($bioimpedanceData);
            }

            // Recalcular a dieta
            $dieta = $this->dietaService->gerarDieta($user);
            $user->dieta()->updateOrCreate([], $dieta); // Atualiza ou cria a dieta

            // Recalcular os treinos
            $this->treinoService->criarTreino($user);
        }

        $user->save();

        return redirect()->route('profile')->withSuccess('Profile updated successfully.');
    }
}

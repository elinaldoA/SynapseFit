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
            'weight' => 'nullable|numeric|min:0',
        ]);

        $user = User::findOrFail(Auth::user()->id);

        $pesoAnterior = $user->weight;

        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->height = $request->input('height');
        $user->sex = $request->input('sex');
        $user->age = $request->input('age');
        $user->objetivo = $request->input('objetivo');

        if (!is_null($request->input('current_password'))) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
            } else {
                return redirect()->back()->withInput()->withErrors(['current_password' => 'Senha atual incorreta']);
            }
        }

        if ($request->filled('weight')) {
            $novoPeso = $request->input('weight');

            if ($pesoAnterior != $novoPeso) {
                $user->weight = $novoPeso;

                $bioimpedanceData = $this->bioimpedanceService->calcularBioimpedancia($user);
                $existingBio = $user->bioimpedance()->first();
                if ($existingBio) {
                    $existingBio->update($bioimpedanceData);
                }

                if ($user->dieta()->exists()) {
                    $this->dietaService->atualizarDieta($user);
                }

                if ($user->workouts()->exists()) {
                    $this->treinoService->atualizarTreino($user);
                }
            }
        }

        $user->save();

        return redirect()->route('profile')->withSuccess('Perfil atualizado com sucesso.');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Services\BioimpedanceService;
use App\Services\DietaService;
use App\Services\TreinoService;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\WelcomeNotification;

class RegisterController extends Controller
{
    protected $bioimpedanceService;
    protected $dietaService;
    protected $treinoService;

    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct(BioimpedanceService $bioimpedanceService, DietaService $dietaService, TreinoService $treinoService)
    {
        $this->middleware('guest');
        $this->bioimpedanceService = $bioimpedanceService;
        $this->dietaService = $dietaService;
        $this->treinoService = $treinoService;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'height' => ['required', 'numeric', 'min:0'],
            'weight' => ['required', 'numeric', 'min:0'],
            'sex' => ['required', 'in:male,female'],
            'age' => ['required', 'numeric', 'min:18'],
            'objetivo' => ['required', 'in:hipertrofia,emagrecimento,resistencia'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'height' => $data['height'],
            'weight' => $data['weight'],
            'sex' => $data['sex'],
            'age' => $data['age'],
            'objetivo' => $data['objetivo'],
            'role' => 'aluno',
        ]);

        $bioimpedanceData = $this->bioimpedanceService->calcularBioimpedancia($user);

        $existingBioimpedance = $user->bioimpedance()->first();

        if ($existingBioimpedance) {
            $existingBioimpedance->update($bioimpedanceData);
        } else {
            $user->bioimpedance()->create($bioimpedanceData);
        }

        $dieta = $this->dietaService->gerarDieta($user);

        $user->dieta()->create($dieta);

        $this->treinoService->criarTreino($user);

        $user->notify(new WelcomeNotification());

        return $user;
    }
}


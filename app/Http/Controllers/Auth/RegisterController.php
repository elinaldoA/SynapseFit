<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Validator;
use App\Services\BioimpedanceService;
use App\Services\DietaService;
use App\Services\TreinoService;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\WelcomeNotification;
use Carbon\Carbon;

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

        $freePlan = Plan::where('name', 'Grátis')->first();

        if ($freePlan) {
            UserSubscription::create([
                'user_id' => $user->id,
                'plan_id' => $freePlan->id,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays($freePlan->duration_in_days),
                'is_active' => true,
            ]);
        }

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


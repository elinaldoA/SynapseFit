<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conquistas = $user->achievements()->latest()->get();

        return view('usuario.conquistas.index', compact('conquistas'));
    }
}

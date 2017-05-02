<?php
namespace App\Http\Controllers;

use App\Analisis;
use App\Http\Requests;
use App\Medico;
use App\Paciente;
use App\User;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cantidad_usuarios = User::all()->count();
        $cantidad_pacientes = Paciente::all()->count();
        $cantidad_analisis = Analisis::all()->count();
        $cantidad_medicos = Medico::all()->count();

        return view('adminlte::home', [
            'cantidad_usuarios' => $cantidad_usuarios,
            'cantidad_pacientes' => $cantidad_pacientes,
            'cantidad_analisis' => $cantidad_analisis,
            'cantidad_medicos' => $cantidad_medicos,
        ]);
    }
}
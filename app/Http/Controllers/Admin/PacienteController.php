<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;
use Html;

use App\Paciente;

class PacienteController extends Controller
{

    public function index()
    {

    }

    public function tolist(Request $request)
    {
        $_search = $request->only('s_dni', 's_apellido', 's_nombre');

        return view('admin.paciente.tolist', [
            '_search' => $_search,
        ]);
    }

    public function tolistData(Request $request)
    {
        $qPaciente = Paciente::all();

        $datatablePaciente = Datatables::of($qPaciente);

        $datatablePaciente->filter(function($paciente) use ($request){
            if ($request->has('s_dni')):
                $paciente->collection = $paciente->collection->filter(function($item) use ($request){
                    return Str::contains(Str::lower($item->dni), Str::lower($request->input('s_dni'))) ? true : false;
                });
            endif;
            if ($request->has('s_apellido')):
                $paciente->collection = $paciente->collection->filter(function($item) use ($request){
                    return Str::contains(Str::lower($item->apellido), Str::lower($request->input('s_apellido'))) ? true : false;
                });
            endif;
            if ($request->has('s_nombre')):
                $paciente->collection = $paciente->collection->filter(function($item) use ($request){
                    return Str::contains(Str::lower($item->nombre), Str::lower($request->input('s_nombre'))) ? true : false;
                });
            endif;
        });

        $datatablePaciente->addColumn('opciones', function($paciente){
            $btn_name = "<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>&nbsp;Detalle";
            $html = HTML::link(url('paciente/detalle', $paciente->id), $btn_name, ['class' => 'btn btn-link btn-xs btn-detalle'], null, false);
            return $html;
        });

        return $datatablePaciente->make(true);
    }

    public function create()
    {
        $titulo = 'Nuevo';

        $ciudades = ['' => 'Seleccione', 1 => 'Ranchos', 2 => 'Chascomus'];
        $provincias = ['' => 'Seleccione', 1 => 'Buenos Aires'];

        return view('admin.paciente.paciente', [
            'titulo' => $titulo,
            'ciudades' => $ciudades,
            'provincias' => $provincias
        ]);
    }

    public function store(Request $request)
    {

        $validarPaciente = $this->_validatePaciente($request);
        if ($validarPaciente->fails()):
            return back()->withErrors($validarPaciente)->withInput();
        endif;

        $paciente = new Paciente();
        $paciente->dni = $request->input('dni');
        $paciente->apellido = $request->input('apellido');
        $paciente->nombre = $request->input('nombre');
        $nacimiento = $request->input('nacimiento', null);
        if ($nacimiento):
            $paciente->nacimiento = Carbon::createFromFormat('d/m/Y', $nacimiento);
        endif;
        $paciente->observaciones = $request->input('observaciones', null);
        $paciente->ciudad_id = $request->input('ciudad_id', null);
        $paciente->provincia_id = $request->input('provincia_id', null);
        $paciente->direccion = $request->input('direccion', null);
        $paciente->telefono = $request->input('telefono', null);
        $paciente->email = $request->input('email', null);

        if ($paciente->save()):
            return redirect('paciente/listar')->with('msg_success', 'Paciente creado con exito.');
        endif;

        return back()->with('msg_error', 'Error al intentar guardar al paciente.')->withInput();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $titulo = 'Detalle';

        $paciente = Paciente::find($id);

        $ciudades = ['' => 'Seleccione', 1 => 'Ranchos', 2 => 'Chascomus'];
        $provincias = ['' => 'Seleccione', 1 => 'Buenos Aires'];

        return view('admin.paciente.edit', [
            'titulo' => $titulo,
            'ciudades' => $ciudades,
            'provincias' => $provincias,
            'paciente' => $paciente,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validarPaciente = $this->_validatePaciente($request);
        if ($validarPaciente->fails()):
            return back()->withErrors($validarPaciente)->withInput();
        endif;

        $paciente = Paciente::find($id);

        $paciente->dni = $request->input('dni');
        $paciente->apellido = $request->input('apellido');
        $paciente->nombre = $request->input('nombre');
        $nacimiento = $request->input('nacimiento', null);
        if ($nacimiento):
            $paciente->nacimiento = Carbon::createFromFormat('d/m/Y', $nacimiento);
        endif;
        $paciente->observaciones = $request->input('observaciones', null);
        $paciente->ciudad_id = $request->input('ciudad_id', null);
        $paciente->provincia_id = $request->input('provincia_id', null);
        $paciente->direccion = $request->input('direccion', null);
        $paciente->telefono = $request->input('telefono', null);
        $paciente->email = $request->input('email', null);

        if ($paciente->save()):
            return redirect("paciente/listar")->with('msg_success', 'Paciente actualizado con exito.');
        endif;

        return back()->withInput()->with('msg_error', 'Error al intentar actualizar al paciente.')->withInput();
    }

    public function destroy($id)
    {
        //
    }

    protected function _validatePaciente(Request $request)
    {
        $id = $request->input('id', '');
        return $validator = Validator::make($request->all(), [
            'dni' => "required|integer|unique:pacientes,dni,{$id}",
            'nacimiento' => 'nullable|date_format:"d/m/Y"',
            'nombre' => 'required|string', 'apellido' => 'required|string',
            'observaciones' => 'nullable|max:500',
            'email' => 'nullable|email',
        ], [
            'dni.required' => 'Documento es obligatorio.',
            'dni.integer' => 'Solo valores numericos sin puntos.',
            'dni.unique' => 'Ya existe el número de documento. (Debe ser único)',
            'nombre.required' => 'El Nombre es oblogatorio.',
            'nombre.string' => 'Nombre debe ser alfanumerico.',
            'apellido.required' => 'El Apellido es oblogatorio.',
            'apellido.string' => 'Apellido debe ser alfanumerico.',
            'nacimiento.date_format' => 'Formato de fecha incorrecto.',
            'observaciones.max' => 'Se requiere como máximo 500 caracteres.',
            'email.email' => 'Formato de Email incorrecto.',
        ]);
    }
}

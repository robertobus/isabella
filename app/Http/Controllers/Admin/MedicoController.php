<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;
use Html;

use App\Medico;

class MedicoController extends Controller
{

    public function index()
    {

    }

    public function tolist(Request $request)
    {
        $_search = $request->only('s_matricula', 's_apellido', 's_nombre');

        return view('admin.medico.tolist', [
            '_search' => $_search,
        ]);
    }

    public function tolistData(Request $request)
    {
        $qMedico = Medico::all();

        $datatableMedico = Datatables::of($qMedico);

        $datatableMedico->filter(function($medico) use ($request){
            if ($request->has('s_matricula')):
                $medico->collection = $medico->collection->filter(function($item) use ($request){
                    return Str::contains(Str::lower($item->matricula), Str::lower($request->input('s_matricula'))) ? true : false;
                });
            endif;
            if ($request->has('s_apellido')):
                $medico->collection = $medico->collection->filter(function($item) use ($request){
                    return Str::contains(Str::lower($item->apellido), Str::lower($request->input('s_apellido'))) ? true : false;
                });
            endif;
            if ($request->has('s_nombre')):
                $medico->collection = $medico->collection->filter(function($item) use ($request){
                    return Str::contains(Str::lower($item->nombre), Str::lower($request->input('s_nombre'))) ? true : false;
                });
            endif;
        });

        $datatableMedico->addColumn('opciones', function($medico){
            $btn_name = "<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>&nbsp;Detalle";
            $html = HTML::link(url('medico/detalle', $medico->id), $btn_name, ['class' => 'btn btn-link btn-xs btn-detalle'], null, false);
            return $html;
        });

        return $datatableMedico->make(true);
    }

    public function create()
    {
        $titulo = 'Nuevo';

        return view('admin.medico.medico', [
            'titulo' => $titulo,
        ]);
    }

    public function store(Request $request)
    {

        $validarMedico = $this->_validateMedico($request);
        if ($validarMedico->fails()):
            return back()->withErrors($validarMedico)->withInput();
        endif;

        $medico = new Medico();
        $medico->matricula = $request->input('matricula');
        $medico->apellido = $request->input('apellido');
        $medico->nombre = $request->input('nombre');
        $medico->telefono = $request->input('telefono', null);
        $medico->email = $request->input('email', null);

        if ($medico->save()):
            return redirect('medico/listar')->with('msg_success', 'Médico creado con exito.');
        endif;

        return back()->with('msg_error', 'Error al intentar guardar el nuevo médico.')->withInput();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $titulo = 'Detalle';

        $medico = Medico::find($id);

        return view('admin.medico.edit', [
            'titulo' => $titulo,
            'medico' => $medico,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validarMedico = $this->_validateMedico($request);
        if ($validarMedico->fails()):
            return back()->withErrors($validarMedico)->withInput();
        endif;

        $medico = Medico::find($id);

        $medico->matricula = $request->input('matricula');
        $medico->apellido = $request->input('apellido');
        $medico->nombre = $request->input('nombre');
        $medico->telefono = $request->input('telefono', null);
        $medico->email = $request->input('email', null);

        if ($medico->save()):
            return redirect("medico/listar")->with('msg_success', 'Médico actualizado con exito.');
        endif;

        return back()->withInput()->with('msg_error', 'Error al intentar actualizar el médico.')->withInput();
    }

    public function destroy($id)
    {
        //
    }

    protected function _validateMedico(Request $request)
    {
        $id = $request->input('id', '');
        return $validator = Validator::make($request->all(), [
            'matricula' => "required|integer|unique:medicos,matricula,{$id}",
            'nombre' => 'required|string', 'apellido' => 'required|string',
            'email' => 'nullable|email',
        ], [
            'matricula.required' => 'La matricula es obligatoria.',
            'matricula.integer' => 'Solo valores numericos sin puntos.',
            'matricula.unique' => 'Ya existe el número de matricula. (Debe ser único)',
            'nombre.required' => 'El Nombre es oblogatorio.',
            'nombre.string' => 'Nombre debe ser alfanumerico.',
            'apellido.required' => 'El Apellido es oblogatorio.',
            'apellido.string' => 'Apellido debe ser alfanumerico.',
            'email.email' => 'Formato de Email incorrecto.',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Practicas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use App\Medico;
use App\ObraSocial;
use App\Analisis;
use App\Paciente;


use PDF;

class AnalisisController extends Controller
{

    public function index()
    {

    }

    public function tolist()
    {
        $analisis = Analisis::all();

        return view('practicas.analisis.tolist', [
            'conjAnalisis' => $analisis
        ]);
    }

    public function create()
    {
        $titulo = 'Nuevo';

        $options_pn = ['' => 'Seleccione', 'positivo' => 'Positivo', 'negativo' => 'Negativo'];
        $arrObrasSociales = ObraSocial::all()->pluck('descripcion', 'id')->prepend('Sin Obra Social', '');

        $arrMedicos = Medico::all()->mapWithKeys(function($item){
            return [$item->id => "{$item->apellido}, {$item->nombre}"];
        })->prepend('Seleccione', '');

        $arrPacientes = Paciente::all()->mapWithKeys(function($item){
            return [$item->id => "{$item->apellido}, {$item->nombre}"];
        })->prepend('Seleccione', '');

        return view('practicas.analisis.create', [
            'titulo' => $titulo,
            'pacientes' => $arrPacientes,
            'medicos' => $arrMedicos,
            'obras_sociales' => $arrObrasSociales,
            'options_pn' => $options_pn,
        ]);
    }

    public function store(Request $request)
    {

        $validate = $this->_validateAnalisis($request);
        if ($validate->fails()):
            return back()->withErrors($validate)->withInput();
        endif;

        $analisis = new Analisis();
        $analisis->fecha = Carbon::createFromFormat('d/m/Y', $request->input('fecha'));
        $analisis->paciente_id = $request->input('paciente_id');
        $analisis->medico_id = $request->input('medico_id');
        $analisis->obra_social_id = $request->input('obra_social_id', null);
        $analisis->diagnostico = $request->input('diagnostico', null);

        $analisis->grupo = $request->input('grupo', null);
        $analisis->factor = $request->input('factor', null);
        $analisis->pci = $request->input('pci', null);
        $analisis->pcd = $request->input('pcd', null);
        $analisis->ppt = $request->input('ppt', null);

        $analisis->observaciones = $request->input('observaciones', null);

        if ($analisis->save()):
            return redirect("analisis/detalle/{$analisis->id}")->with('msg_success', 'Analisis creado con exito.');
        endif;

        return back()->with('msg_error', 'Error al intentar guardar el analisis.')->withInput();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $titulo = 'Detalle';

        $analisis = Analisis::find($id);

        $options_pn = ['' => 'Seleccione', 'positivo' => 'Positivo', 'negativo' => 'Negativo'];
        $arrObrasSociales = ObraSocial::all()->pluck('descripcion', 'id')->prepend('Sin Obra Social', '');

        $arrMedicos = Medico::all()->mapWithKeys(function($item){
            return [$item->id => "{$item->apellido}, {$item->nombre}"];
        })->prepend('Seleccione', '');

        $arrPacientes = Paciente::all()->mapWithKeys(function($item){
            return [$item->id => "{$item->apellido}, {$item->nombre}"];
        })->prepend('Seleccione', '');

        return view('practicas.analisis.edit', [
            'titulo' => $titulo,
            'pacientes' => $arrPacientes,
            'medicos' => $arrMedicos,
            'obras_sociales' => $arrObrasSociales,
            'options_pn' => $options_pn,
            'analisis' => $analisis,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = $this->_validateAnalisis($request);
        if ($validate->fails()):
            return back()->withErrors($validate)->withInput();
        endif;

        $analisis = Analisis::find($id);

        $analisis->fecha = Carbon::createFromFormat('d/m/Y', $request->input('fecha'));
        $analisis->paciente_id = $request->input('paciente_id');
        $analisis->medico_id = $request->input('medico_id');
        $analisis->obra_social_id = $request->input('obra_social_id', null);
        $analisis->diagnostico = $request->input('diagnostico', null);

        $analisis->grupo = $request->input('grupo', null);
        $analisis->factor = $request->input('factor', null);
        $analisis->pci = $request->input('pci', null);
        $analisis->pcd = $request->input('pcd', null);
        $analisis->ppt = $request->input('ppt', null);

        $analisis->observaciones = $request->input('observaciones', null);

        if ($analisis->save()):
            return redirect("analisis/detalle/{$analisis->id}")->with('msg_success', 'Analisis actualizado con exito.');
        endif;

        return back()->withInput()->with('msg_error', 'Error al intentar actualizar el analisis.')->withInput();
    }

    public function destroy($id)
    {
        //
    }

    protected function _validateAnalisis(Request $request)
    {
        $obra_social_id = $request->input('obra_social_id', '');
        return $validator = Validator::make($request->all(), [
            'paciente_id' => "required|integer|exists:pacientes,id",
            'medico_id' => 'required|integer|exists:medicos,id',
            'obra_social_id' => "nullable|integer|exists:obra_social,id",
            'fecha' => 'required|date_format:"d/m/Y"',
            'diagnostico' => 'required|max:255',
            'observaciones' => 'nullable|max:500',
        ], [
            'paciente_id.required' => 'Paciente es obligatorio.',
            'paciente_id.integer' => 'Solo valores numericos.',
            'paciente_id.exists' => 'El Paciente no existe.',
            'medico_id.required' => 'Medico es obligatorio.',
            'medico_id.integer' => 'Solo valores numericos.',
            'medico_id.exists' => 'El Médico no existe.',
            'obra_social_id.integer' => 'Solo valores numericos.',
            'obra_social_id.exists' => 'Obra social no existe.',
            'fecha.required' => 'Fecha de Analisis es obligatoria.',
            'fecha.date_format' => 'Formato de fecha incorrecto.',
            'diagnostico.required' => 'El diagnostico es obligatorio.',
            'diagnostico.max' => 'Se permite solo un maximo de 255 caracteres.',
            'observaciones.max' => 'Se permite solo un maximo de 500 caracteres.',
        ]);
    }

    public function export($id = null)
    {

        $analisis = Analisis::find($id);

        if (!$analisis):
            return redirect('analisis/busqueda')->with('msg_error', 'Error! Análisis inexistente.');
        endif;

        PDF::SetTitle('Hospital Campomar - Informe de Análisis Clínico');

        //HEADER
        PDF::setHeaderMargin(5);
        PDF::setHeaderCallback(function($pdf){

            $pdf->setFont('helvetica', 'B', 15);
            $pdf->Cell(0, 0, 'HOSPITAL CAMPOMAR', 0, 1, 'C');
            $pdf->setFont('helvetica', 'B', 11);
            $pdf->Cell(0, 0, 'HEMOTERAPIA', 0, 1, 'C');
            $pdf->Image(public_path('img/escudo-ranchos.jpg'), 15, 5, 15, 20, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $pdf->Line(15, 25, 195, 25, ['color' => array(86,172,61)]);
        });
        //FOOTER
        PDF::setFooterMargin(17);
        PDF::setFooterCallback(function($pdf){
            $pdf->Line(15,278,195,279, ['color' => array(86,172,61)]);
            $pdf->setFont('helvetica', '', 8);
            $descripcion = "<b>HOSPITAL CAMPOMAR - HEMOTERAPIA</b><br/>"
                ."Av. Campomar 1794 - Ranchos - Gral. Paz - Buenos Aires<br/>"
                ."Tel. +54 9 02241 482011 - Fax. +54 9 02241 482774<br/> "
                ."www.hospitalcampomar.com.ar - Email. hospitalcampomar@mriosalud.com.ar";
            $pdf->writeHtmlCell(0, 0, '', '', $descripcion, 0, 0, 0, true, '', true);
            $pdf->Cell(10, 20, 'Página '. PDF::getAliasNumPage() .' de '. PDF::getAliasNbPages(), 0, 0, 'R');
        });

        PDF::setMargins(15,30, 15);
        PDF::AddPage();

        PDF::setFont('helvetica', '', 11);
        PDF::Write(0, 'Fecha: '. Carbon::createFromFormat('Y-m-d', $analisis->fecha)->format('d/m/Y'), '', false, 'R', true);
        PDF::Write(0, 'Paciente: '. $analisis->paciente->apellido .', '. $analisis->paciente->nombre, '', false, '', true);
        PDF::Write(0, 'Médico: '. $analisis->medico->apellido .', '. $analisis->medico->nombre, '', false, '', true);
        PDF::Ln(3);
        PDF::Write(0, 'Diagnóstico: '. $analisis->diagnostico, '', false, '', true);
        PDF::Ln(5);
        PDF::setFont('helvetica', 'B', 11);
        PDF::Write(0, '                         ', '', false, '', false);
        PDF::Write(0, 'Grupo:                   ', '', false, '', false); PDF::Write(0, $analisis->grupo, '', false, '', false);
        PDF::Write(0, '                          ', '', false, '', false);
        PDF::Write(0, 'Factor Rh: ', '', false, '', false); PDF::Write(0, $analisis->factor, '', false, '', true);
        PDF::Write(0, '                         ', '', false, '', false);
        PDF::Write(0, 'PCI:                        '. $analisis->pci, '', false, '', true);
        PDF::Write(0, '                         ', '', false, '', false);
        PDF::Write(0, 'PCD:                      '. $analisis->pcd, '', false, '', true);
        PDF::Write(0, '                         ', '', false, '', false);
        PDF::Write(0, 'PPT:                       '. $analisis->ppt, '', false, '', true);
        PDF::Ln(5);
        PDF::Write(0, 'Observaciones: ', '', false, '', true);
        PDF::setFont('helvetica', '', 11);
        PDF::Write(0, $analisis->observaciones, '', false, '', true);
        PDF::Ln(20);
        PDF::setFont('helvetica', '', 11);
        PDF::Write(0, '                                                                                   ', '', false, '', false);
        PDF::Write(0, '____________________________', '', false, '', true);
        PDF::Write(0, '                                                                                   ', '', false, '', false);
        PDF::Write(0, '                    Bioquímico', '', false, '', true);

        $name_file = str_pad($analisis->id, 5, '0', STR_PAD_LEFT);
        $pdf = PDF::Output(public_path("export/{$name_file}.pdf"), 'S');

        PDF::reset();

        return response($pdf)->withHeaders([
            'Content-Type' => 'application/pdf',
            'Content-Description' => 'File Transfer',
            'Content-Transfer-Encoding' => 'Binary',
            'Content-Disposition' => "attachment;filename='{$name_file}.pdf'",
        ]);
    }
}

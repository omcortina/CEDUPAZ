<?php

namespace App\Http\Controllers;

use App\Persona;
use App\Curso;
use App\Asignatura;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    public function ListarAsignaturas(Request $request)
    {
    	$asignaturas = Asignatura::all()->where('id_padre',null);
    	return view("asignatura.listado_asignaturas",compact('asignaturas'));
    }

    public function ListarDocumentosMaterias($id_asignatura){
        $asignatura = Asignatura::find($id_asignatura);
        return view("persona.listado_documentos_materia", compact("asignatura"));
    }



    public function GuardarAsignatura(Request $request)
    {
    	$post = $request->all();
        $mensaje = '';
        $errors = [];
        $docentes = Persona::all()->where('id_dominio_tipo_persona', 6);
        $cursos_padres = Curso::all()->where('id_padre',null);
        $asignatura = new Asignatura;
           if ($post) {
            $post = (object) $post;
            $a = Asignatura::all()->where('codigo', $post->materia_padre['codigo']);
            if(count($a)>0){
                 return response()->json([
                        'mensaje'=> "Este codigo ya esta registrado",
                        'error' =>true
                    ]);
            }             
                //este rescibe como parametros los 
                $validator = \Validator::make($request->except(['_token', 'sub_materias'])['materia_padre'], $asignatura->rules);
                if (!$validator->fails()) {
                    $asignatura->fill($request->except(['_token','sub_materias'])['materia_padre']);
                    $asignatura->save();

                    if(isset($post->sub_materias)){
                    	$sub_materias = $post->sub_materias;

	                    foreach ($sub_materias as $sub_materia) {
	                    	$submateria = new Asignatura;
	                        $submateria->fill($sub_materia);
	                        $submateria->id_padre = $asignatura->id_asignatura;
	                        $submateria->save();
	                    }
                    }

                    $mensaje = "Asignatura registrada exitosamente";
                    return response()->json([
                        'mensaje'=>$mensaje,
                        'error' =>false
                    ]);
                }
                $errors = $validator->messages()->get('*');
                 return response()->json([
                        'mensaje'=>$errors,
                        'error' =>true
                    ]);
           }
        return view('asignatura.registrar_asignaturas',compact(['errors', 'asignatura', 'docentes', 'cursos_padres']));
    }

    public function EditarAsignatura(Request $request,$id_asignatura){
        $mensaje = '';
        $asignatura = Asignatura::find($id_asignatura);

        $docentes = Persona::all()->where("id_dominio_tipo_persona", 6);
        $cursos_padres = Curso::all()->where('id_padre',null);
        $post = $request->all();
        $errors = [];
           if ($post) {
                $post = (object) $post;
                $a = Asignatura::all()->where('codigo', $post->materia_padre['codigo']);
                if(count($a)>1){
                        return response()->json([
                            'mensaje'=> "Este codigo ya esta registrado",
                            'error' =>true
                        ]);                     
                }
                //este rescibe como parametros los 
                $asignatura = Asignatura::find($id_asignatura);

                $validator = \Validator::make($request->except(['_token', 'sub_materias'])['materia_padre'], $asignatura->rules);
                if (!$validator->fails()) {
                    $asignatura->update($request->except(['_token'])['materia_padre']);

                    $sub_materias = $post->sub_materias;

                    foreach ($sub_materias as $sub_materia) {
                        $sub_materia = (object) $sub_materia;
                        $sub_materia_editar = Asignatura::find($sub_materia->id_asignatura);
                        if ($sub_materia_editar == null) $sub_materia_editar = new Asignatura;
                        $sub_materia_editar->codigo =  $sub_materia->codigo;
                        $sub_materia_editar->nombre =  $sub_materia->nombre;
                        $sub_materia_editar->id_persona =  $sub_materia->id_persona;
                        $sub_materia_editar->id_curso =  $sub_materia->id_curso;
                        $sub_materia_editar->id_padre = $asignatura->id_asignatura;

                        $sub_materia_editar->save();

                    }

                    $mensaje = "Asignatura modificada exitosamente";
                    return response()->json([
                        'mensaje'=>$mensaje,
                        'error' =>false
                    ]);
                }

                $errors = $validator->messages()->get('*');
           }
        return view('asignatura.editar_asignatura',compact(['errors', 'asignatura', 'docentes', 'cursos_padres']));
    }

    public function EliminarAsignatura($id_asignatura)
    {
        $mensaje = '';
        $asignatura = Asignatura::find($id_asignatura);

        if (count($asignatura->documentos)>0) {
            $mensaje = "No se puede eliminar la asignatura ".$asignatura->nombre." de ".$asignatura->curso->nombre." porque tiene documentos asignados";
            session()->flash('mensaje_asignatura', $mensaje);
            return redirect()->route('asignatura/editar_asignatura', $asignatura->id_asignatura);

        }

        foreach ($asignatura->subMaterias as $sub_materia) {
            if (count($sub_materia->documentos)>0) {
                $mensaje = "No se puede eliminar la asignatura ".$sub_materia->nombre." de ".$sub_materia->curso->nombre." porque tiene documentos asignados";
                session()->flash('mensaje_asignatura', $mensaje);
                return redirect()->route('asignatura/editar_asignatura', $asignatura->id_asignatura);

            }
        }

        foreach ($asignatura->subMaterias as $sub_materia) {
            $sub_materia->delete();
        }

        $asignatura->delete();
        $mensaje = "Asignatura eliminada exitosamente";
        return redirect()->route('asignatura/listar_asignaturas');
    }

    public function EliminarSubMateria($id_asignatura)
    {
        $mensaje = '';
        $asignatura = Asignatura::find($id_asignatura);
        $documentos = $asignatura->documentos;
        if (count($documentos)>0) {
           $mensaje = "No se puede eliminar la asignatura, existen documentos asignadas";
           return response()->json([
                        'mensaje'=>$mensaje,
                        'error' =>true
                    ]);
        }

        $asignatura->delete();
        $mensaje = "Asignatura eliminada exitosamente";
        return response()->json([
                        'mensaje'=>$mensaje,
                        'error' =>false
                    ]);
    }

}

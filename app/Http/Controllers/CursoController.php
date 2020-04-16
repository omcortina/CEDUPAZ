<?php

namespace App\Http\Controllers;

use App\Asignatura;
use App\Curso;
use App\CursoEstudiante;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function ListarCursos()
    {
        $cursos = Curso::all()->where('id_padre', null);
        return view("curso.listado_cursos",compact('cursos'));
    }

    public function ListarEstudiantesPorCurso($id_curso){
        $curso = Curso::find($id_curso);
        $estudiantes = $curso->estudiantes();
        return response()->json($estudiantes);
    }

    public function ListarSubCursos($id_curso_padre){
        $sub_cursos = Curso::where('id_padre', $id_curso_padre)->get();
        return response()->json($sub_cursos);
    }

    public function GuardarCurso(Request $request)
    {
        $post = $request->all();
        $mensaje = '';
        $errors = [];


        $curso = new Curso;
           if ($post) {
            $post = (object) $post; 
            $c = Curso::all()->where('codigo', $post->curso_padre['codigo']);
            if(count($c)>0){
                 return response()->json([
                        'mensaje'=> "Este codigo ya esta registrado",
                        'error' =>true
                    ]);
            }         
                //este rescibe como parametros los 
                $validator = \Validator::make($request->except(['_token', 'sub_cursos'])['curso_padre'], $curso->rules);
                if (!$validator->fails()){
                    $curso->fill($request->except(['_token', 'sub_cursos'])['curso_padre']);
                    $curso->save();

                    if(isset($post->sub_cursos)){

                        $sub_cursos = $post->sub_cursos;

                        foreach ($sub_cursos as $sub_curso) {
                            $subcurso = new Curso;
                            $subcurso->fill($sub_curso);
                            $subcurso->id_padre = $curso->id_curso;
                            $subcurso->save();
                        }
                    }
                    
                    $mensaje = "Curso registrado exitosamente";
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
        return view('curso.registrar_cursos',compact('errors'), compact('curso'));
    }

    public function EditarCurso(Request $request,$id_curso){
        $mensaje = '';
        $curso = Curso::find($id_curso);
        $post = $request->all();
        $errors = [];
           if ($post) {
                $post = (object) $post;
                $c = Curso::all()->where('codigo', $post->curso_padre['codigo']);
                if(count($c)>1){
                     return response()->json([
                            'mensaje'=> "Este codigo ya esta registrado",
                            'error' =>true
                        ]);
                }
                //este rescibe como parametros los 
                $curso = Curso::find($id_curso);

                $validator = \Validator::make($request->except(['_token', 'sub_cursos'])['curso_padre'], $curso->rules);
                if (!$validator->fails()) {
                    $curso->update($request->except(['_token', 'sub_cursos'])['curso_padre']);

                    $sub_cursos = $post->sub_cursos;
                    foreach ($sub_cursos as $sub_curso) {
                        $sub_curso = (object) $sub_curso;
                        $sub_curso_editar = Curso::find($sub_curso->id_curso);
                        if ($sub_curso_editar == null) $sub_curso_editar = new Curso;
                        $sub_curso_editar->codigo =  $sub_curso->codigo;
                        $sub_curso_editar->nombre =  $sub_curso->nombre;
                        $sub_curso_editar->id_padre = $curso->id_curso;

                        $sub_curso_editar->save();

                    }

                    $mensaje = "Curso modificado exitosamente";
                    return response()->json([
                        'mensaje'=>$mensaje,
                        'error' =>false
                    ]);
                }

                $errors = $validator->messages()->get('*');
           }
        return view('curso.editar_curso',compact('curso'),compact('errors'));
    }

    public function EliminarCurso($id_curso)
    {
        $mensaje = '';
        $curso = Curso::find($id_curso);
        $asignaturas = Asignatura::all()->where('id_curso',$id_curso);
        if (count($asignaturas)>0) {
           $mensaje = "No se puede eliminar el curso, existen materias asignadas";
           session()->flash('mensaje_curso', $mensaje);
           return redirect()->route('curso/editar_curso', $id_curso);
        }

        foreach ($curso->subCursos as $sub_curso) {
            $sub_curso->delete();
        }
        $curso->delete();
        $mensaje = "Curso eliminado exitosamente";
        session()->flash('mensaje_curso', $mensaje);
        return redirect()->route('curso/listar_cursos');
    }

    public function EliminarSubCurso($id_curso)
    {
        $mensaje = '';
        $curso = Curso::find($id_curso);
        $asignaturas = Asignatura::all()->where('id_curso',$id_curso);
        if (count($asignaturas)>0) {
           $mensaje = "No se puede eliminar el curso, existen materias asignadas";
           return response()->json([
                        'mensaje'=>$mensaje,
                        'error' =>true
                    ]);
        }

        $curso->delete();
        $mensaje = "Curso eliminado exitosamente";
        return response()->json([
                        'mensaje'=>$mensaje,
                        'error' =>false
                    ]);
    }
}

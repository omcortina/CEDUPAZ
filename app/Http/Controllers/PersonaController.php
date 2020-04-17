<?php

namespace App\Http\Controllers;

use App\Asignatura;
use App\Curso;
use App\CursoEstudiante;
use App\Persona;//el modelo
use Illuminate\Http\Request;

class PersonaController extends Controller
{

    public function ValidarLogin(Request $request)
    {
        $post = $request->all();
        $post = (object) $post;
       
        
        $persona = Persona::where('username',$post->username)
                          ->where('password',$post->password)
                          ->first();
        if ($persona) {
            

             if ($persona->id_dominio_tipo_persona == 5) {
                session([
                    'id_usuario' => $persona->id_persona,
                    'admin' => true
                ]);

                return redirect()->route('persona/listar_docentes');
            }

            if ($persona->id_dominio_tipo_persona == 6) {
                if ($persona->estado != 0) {
                    session([
                    'id_usuario' => $persona->id_persona,
                    'docente' => true
                    ]);
                    return view("layouts.main_docente");
                }else{
                    $mensaje = "Este usuario ya no esta disponible en la plataforma";
                    session()->flash('mensaje_login', $mensaje);
                    return view("layouts.login");
                }
                
            }

            if ($persona->id_dominio_tipo_persona == 10) {
                if ($persona->estado != 0) {
                    session([
                    'id_usuario' => $persona->id_persona,
                    'estudiante' => true
                    ]);
                    return view("layouts.main_estudiante");
                }else{
                    $mensaje = "Este usuario ya no esta disponible en la plataforma";
                    session()->flash('mensaje_login', $mensaje);
                    return view("layouts.login");
                }
                
            }
        }

        $mensaje = "Credenciales invalidas";
        session()->flash('mensaje_login', $mensaje);
        return view("layouts.login");
        
    }

    public function CerrarSesion(Request $request)
    {
        $request->session()->flush();
        return redirect("/");
    }

    public function ListarDocentes(){
        $docentes = Persona::all()->where('id_dominio_tipo_persona', 6)->where('estado', 1);
        return view("persona.listado_docentes",compact('docentes'));
    }

    public function ListarEstudiantes(){
        $estudiantes = Persona::all()->where('id_dominio_tipo_persona', 10)->where('estado', 1);
        return view("persona.listado_estudiantes",compact('estudiantes'));
    }


    public function GuardarDocente(Request $request){
        $post = $request->all();
        $mensaje = '';
        $errors = [];
        $persona = new Persona;
        if ($post) {
            $post = (object) $post;
            $p = Persona::all()->where('identificacion', $post->identificacion);
            if(count($p)>0){
                $mensaje = "Esta identificacion ya esta registrada";
                session()->flash('error_mensaje_persona', $mensaje);
                return redirect()->route('persona/listar_docentes');
            }

            $p = Persona::all()->where('username', $post->username);
            if(count($p)>0){
                $mensaje = "Este usuario ya existe";
                session()->flash('error_mensaje_persona', $mensaje);
                return redirect()->route('persona/listar_estudiantes');
            }
            //este rescibe como parametros los 
            $validator = \Validator::make($request->except('_token'), $persona->rules);
            if (!$validator->fails()) {
                $request['id_dominio_tipo_persona'] = 6;
                $request['estado'] = 1;
                $persona->create($request->except('_token'));
                $mensaje = "Persona registrada exitosamente";
                session()->flash('mensaje_persona', $mensaje);
                return redirect()->route('persona/listar_docentes');
            }  
            $errors = $validator->messages()->get('*');
        }
        return view('persona.registrar_docentes',compact('errors'), compact('persona'));
    }


    public function GuardarEstudiante(Request $request){
        $post = $request->all();
        $mensaje = '';
        $errors = [];
        $cursos =  Curso::all()->where('id_padre', null);
        $persona = new Persona;
        if ($post) {
            $post = (object) $post;
            $p = Persona::all()->where('identificacion', $post->identificacion);
            if(count($p)>0){
                $mensaje = "Esta identificacion ya esta registrada";
                session()->flash('error_mensaje_persona', $mensaje);
                return redirect()->route('persona/listar_estudiantes');
            }

            $p = Persona::all()->where('username', $post->username);
            if(count($p)>0){
                $mensaje = "Este usuario ya existe";
                session()->flash('error_mensaje_persona', $mensaje);
                return redirect()->route('persona/listar_estudiantes');
            }

            
            $sexo = $post->id_dominio_tipo_sexo;
            $sexo = intval($sexo);

            if($sexo == 0){
                $mensaje = "El estudiante no se pudo registrar, el campo sexo es obligatorio";
                session()->flash('error_mensaje_persona', $mensaje);
                return redirect()->route('persona/listar_estudiantes');
            }

            $request['id_dominio_tipo_persona'] = 10;
            $request['estado'] = 1;
            $persona->fill($request->except('_token'));
            $validator = \Validator::make($request->except('_token'), $persona->rules);
            if (!$validator->fails()) {
                $persona->save();
                $curso_estudiante = new CursoEstudiante;
                $curso_estudiante->id_persona = $persona->id_persona;
                $curso_estudiante->estado = $persona->estado;
                $curso_estudiante->id_curso = $post->id_curso;
                $curso_estudiante->save();

                $mensaje = "Persona registrada exitosamente";
                session()->flash('mensaje_persona', $mensaje);
                return redirect()->route('persona/listar_estudiantes');
            }  
            $errors = $validator->messages()->get('*');
        }
        return view('persona.registrar_estudiantes',compact('errors'), compact(['persona', 'cursos']));
    }

    public function EditarDocente(Request $request,$id_persona){
        $mensaje = '';
        $persona = Persona::find($id_persona);
        $post = $request->all();

        $errors = [];
           if ($post) {
                $post = (object) $post;
                $p = Persona::all()->where('identificacion', $post->identificacion);
                if(count($p)>1){
                    $mensaje = "Esta identificacion ya esta registrada";
                    session()->flash('error_mensaje_persona', $mensaje);
                    return redirect()->route('persona/listar_docentes');
                }

                $p = Persona::all()->where('username', $post->username);
                if(count($p)>1){
                    $mensaje = "Este usuario ya existe";
                    session()->flash('error_mensaje_persona', $mensaje);
                    return redirect()->route('persona/listar_estudiantes');
                }
                //este rescibe como parametros los 
                $persona = Persona::find($post->id_persona);    
                $validator = \Validator::make($request->except('_token'), $persona->rules);
                if (!$validator->fails()) {
                    $persona->update($request->except('_token'));
                    $mensaje = "Persona modificada exitosamente";
                    session()->flash('mensaje_persona', $mensaje);
                    return redirect()->route('persona/listar_docentes');
                }

                $errors = $validator->messages()->get('*');
           }
        return view('persona.editar_docente',compact('persona'),compact('errors'));
    }

    public function EditarEstudiante(Request $request,$id_persona){
        $mensaje = '';
        $persona = Persona::find($id_persona);
        $cursos =  Curso::all()->where('id_padre', null);
        $post = $request->all();
        $errors = [];
           if ($post) {
                $post = (object) $post;
                $p = Persona::all()->where('identificacion', $post->identificacion);
                if(count($p)>1){
                    $mensaje = "Esta identificacion ya esta registrada";
                    session()->flash('error_mensaje_persona', $mensaje);
                    return redirect()->route('persona/listar_estudiantes');
                }

                $p = Persona::all()->where('username', $post->username);
                if(count($p)>1){
                    $mensaje = "Este usuario ya existe";
                    session()->flash('error_mensaje_persona', $mensaje);
                    return redirect()->route('persona/listar_estudiantes');
                }
                $persona = Persona::find($post->id_persona);
                
                $curso_estudiante = CursoEstudiante::all()->where('id_persona', $post->id_persona);  
                  
                $validator = \Validator::make($request->except('_token'), $persona->rules);
                if (!$validator->fails()) {
                    $persona->update($request->except('_token'));


                    foreach ($curso_estudiante as $curso_persona) {
                        $curso_persona->estado = 0;
                        $curso_persona->update();
                    }

                    $curso_estudiante = new CursoEstudiante;
                    $curso_estudiante->id_persona = $persona->id_persona;
                    $curso_estudiante->id_curso = $post->id_curso;
                    $curso_estudiante->estado = 1;
                    $curso_estudiante->save();

                    $mensaje = "Persona modificada exitosamente";
                    session()->flash('mensaje_persona', $mensaje);
                    return redirect()->route('persona/listar_estudiantes');
                }

                $errors = $validator->messages()->get('*');
           }
        return view('persona.editar_estudiante',compact('persona'),compact(['errors', 'cursos']));
    }


    public function EliminarEstudiante($id_persona)
    {
        $mensaje = '';
        $persona = Persona::find($id_persona);
        $cursos_estudiante = CursoEstudiante::all()->where('id_persona', $id_persona);
        foreach ($cursos_estudiante as $curso_estudiante) {
            $curso_estudiante->estado = 0;
            $curso_estudiante->update();
        } 
        $persona->estado = 0;
        $persona->update();       
        $mensaje = "Persona eliminada exitosamente";
        session()->flash('mensaje_persona', $mensaje);
        return redirect()->route('persona/listar_estudiantes');
    }

    public function EliminarDocente($id_persona)
    {
        $mensaje = '';
        $persona = Persona::find($id_persona);
        $persona->estado = 0;
        $persona->update();
        $mensaje = "Persona eliminada exitosamente";
        session()->flash('mensaje_persona', $mensaje);
        return redirect()->route('persona/listar_docentes');
    }

    public function ListarMateriasPorCurso($id_curso){
        $curso = Curso::find($id_curso);

        if ($curso) {
            $asignaturas = $curso->asignaturas;
            return view("persona.listado_materias_curso", compact(["asignaturas","curso"]));
        }
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
     protected $table = 'persona';
     protected $primaryKey = 'id_persona';
     protected $fillable = ['identificacion', 'nombre', 'apellido','email','telefono','id_dominio_tipo_sexo','username','password','id_dominio_tipo_persona', 'estado'];

    public $rules = [
	    'identificacion' => 'required',
	    'nombre' => 'required',
	    'apellido' => 'required',
	    'email' => 'required',
	    'telefono' => 'required',
	    'id_dominio_tipo_sexo' => 'required',
	    'username' => 'required',
	    'password' => 'required'  
	];

	public function tipo()
	{
	    return $this->belongsTo('App\Dominio', 'id_dominio_tipo_persona');
	}

    public function sexo()
    {
        return $this->belongsTo('App\Dominio', 'id_dominio_tipo_sexo');
    }


	public function asignaturas()
    {
        return $this->hasMany(Asignatura::class, 'id_persona'); //lista de objetos del model Asignatura

    }


    public function getCursosPadre(){
    	$cursos_padres = [];
    	$asignaturas = Asignatura::all()->where('id_persona', $this->id_persona);

        $cursos_padres_encontrados = [];
        foreach ($asignaturas as $asignatura) {
            $curso = $asignatura->curso;
            
            if(in_array($curso->id_padre, $cursos_padres_encontrados) == false) {
             // el curso es padre
                if ($curso->id_padre == null) {
                    $curso['hijos'] = [];
                    array_push($cursos_padres, $curso);
                    array_push($cursos_padres_encontrados, $curso->id_curso);
                }else{
                    $curso_padre = $curso->padre;
                    $curso_padre['hijos'] = [];
                    array_push($cursos_padres, $curso_padre);
                    array_push($cursos_padres_encontrados, $curso_padre->id_curso);
                }
                
            }
        }
    	foreach ($cursos_padres as $curso_padre) {
    		
    		$hijos_encontrados = [];
    		foreach ($asignaturas as $asignatura) {
    			$curso = $asignatura->curso;

    			if ($curso->id_padre == $curso_padre->id_curso) {
    				if (in_array($curso, $hijos_encontrados) == false){
    					array_push($hijos_encontrados, $curso);
    				}
    			}
    		}
    		$curso_padre['hijos'] = $hijos_encontrados;

    	}

    	return $cursos_padres;
    }

    public function GetMateriasEstudiante(){
        $curso = $this->cursoActual();
        return $curso->asignaturas;
    }

    public function cursos(){
        $cursos=[];
        $cursos_estudiantes = CursoEstudiante::all()->where('id_persona',$this->id_persona); //lista de objetos del model Curso
        foreach ($cursos_estudiantes as $curso_estudiante) {
            $curso = $curso_estudiante->curso;
            array_push($cursos, $curso);
        }
        return $cursos;
    }




    public function cursoActual(){
        $cursos=[];
        $curso_estudiante = CursoEstudiante::where('id_persona',$this->id_persona)->where('estado',1)->first(); //lista de objetos del model Curso  
        if ($curso_estudiante) {
            $curso = new Curso;
            $curso = $curso_estudiante->curso;
            return $curso;
        }

        return null;      
    }
}

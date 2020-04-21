<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'curso';
    protected $primaryKey = 'id_curso';
    protected $fillable = ['codigo', 'nombre', 'id_padre'];

    public $rules = [
	    'codigo' => 'required',
	    'nombre' => 'required' 
	];

	public function subCursos()
    {
        return $this->hasMany(Curso::class, 'id_padre'); //lista de objetos del model Curso

    }

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class, 'id_curso'); //lista de objetos del model Asignatura

    }

    public function padre()
    {
        return $this->belongsTo(Curso::class, 'id_padre');
    }


    public function estudiantes(){
        $estudiantes=[];
        $cursos_estudiantes = CursoEstudiante::all()->where('id_curso',$this->id_curso)->where('estado',1); //lista de objetos del model Persona
        
        foreach ($cursos_estudiantes as $curso_estudiante) {
            $estudiante = $curso_estudiante->estudiante;
            array_push($estudiantes, $estudiante);
        }
        return $estudiantes;
    }

}

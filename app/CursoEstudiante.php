<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CursoEstudiante extends Model
{
    protected $table = 'curso_estudiante';
    protected $primaryKey = 'id_curso_estudiante';
    protected $fillable = ['id_curso','id_persona', 'estado'];

    public function curso(){
    	return $this->belongsTo('App\Curso', 'id_curso');
    }

    public function estudiante(){
    	return $this->belongsTo('App\Persona', 'id_persona');
    }
}




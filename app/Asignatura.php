<?php

namespace App;

use App\Curso;
use App\Persona;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $table = 'asignatura';
    protected $primaryKey = 'id_asignatura';
    protected $fillable = ['codigo', 'nombre', 'id_curso', 'id_persona', 'id_padre'];

    public $rules = [
	    'codigo' => 'required',
	    'nombre' => 'required' 
	];

	public function subMaterias()
    {
        return $this->hasMany(Asignatura::class, 'id_padre'); //lista de objetos del model Asignatura  
    }

    public function curso(){
        return $this->belongsTo("App\Curso", "id_curso");
    }

    public function persona(){
        return $this->belongsTo("App\Persona", "id_persona");
    }

    

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'id_asignatura')->orderBy('id_documento', 'desc'); //lista de objetos del model Asignatura  
    }
}

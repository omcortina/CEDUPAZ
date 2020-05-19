<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividad';
    protected $primaryKey = 'id_actividad';
    protected $fillable = ['nombre', 'fecha', 'fecha_inicio', 'fecha_fin', 'id_dominio_tipo', 'estado', 'id_asignatura', 'observaciones'];


    public $rules = [
	    'nombre' => 'required',
	    'fecha_inicio' => 'required',
	    'fecha_fin' => 'required',
	    'id_dominio_tipo' => 'required',
	    'estado' => 'required'
	];

    function documentos(){
    	return $this->hasMany(Documento::class, 'id_actividad')->orderBy('id_documento', 'desc');
    }

    public function tipo(){
    	 return $this->belongsTo(Dominio::class, 'id_dominio_tipo');
    }

    public function asignatura(){
    	 return $this->belongsTo(Asignatura::class, 'id_asignatura');
    }

    function entregas(){
        return $this->hasMany(Entrega::class, 'id_actividad');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $table = 'entrega';
    protected $primaryKey = 'id_entrega';
    protected $fillable = ['fecha', 'observaciones', 'id_estado', 'calificacion', 'anotaciones', 'id_actividad', 'id_estudiante'];


	public function actividad(){
    	 return $this->belongsTo(Actividad::class, 'id_actividad');
    }

	public function documentos()
	{
		return $this->hasMany(Documento::class, 'id_entrega')->orderBy('id_documento', 'desc');

	}

	public function estado(){
    	 return $this->belongsTo(Dominio::class, 'id_estado');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documento';
    protected $primaryKey = 'id_documento';
    protected $fillable = ['url', 'id_asignatura', 'id_dominio_tipo', 'estado_oculto', 'descripcion'];

    public function tipo(){
    	 return $this->belongsTo(Dominio::class, 'id_dominio_tipo');
    }
}

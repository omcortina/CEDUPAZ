<?php

namespace App\Http\Controllers;

use App\Actividad;
use App\Documento;
use App\Asignatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActividadController extends Controller
{
    public function ConsultarActividad($id_actividad){
        $actividad = Actividad::find($id_actividad);
        $tipo = $actividad->tipo->nombre;
        $documentos = $actividad->documentos;
        return response()->json([
                    'actividad'=>$actividad,
                    'tipo'=>$tipo,
                    'documentos'=>$documentos
                ]);
    }

    public function AgregarActividad(Request $request, $id_asignatura)
    {
        
    	$asignatura = Asignatura::find($id_asignatura);
    	$post = $request->all();
		
    	$errors = [];
    	if ($post) { 	
    		$actividad = new Actividad;
    		$post = (object) $post;
    		
    		$fecha_inicio = date('Y-m-d H:i', strtotime(str_replace("/", "-", explode(" - ", $post->fechas)[0])));
            $fecha_fin = date('Y-m-d H:i', strtotime(str_replace("/", "-", explode(" - ", $post->fechas)[1])));
    		$request['fecha_inicio'] = $fecha_inicio;
    		$request['fecha_fin'] = $fecha_fin;
    		$validator = \Validator::make($request->except(['_token', 'archivos', 'fechas']), $actividad->rules);

    		if (!$validator->fails()) {
    			$actividad->fill($request->except(['_token', 'archivos', 'fechas']));

                
        			if ($actividad->save()) {
                        foreach ($post->archivos as $archivo) {
                            $documento = new Documento;
                            $documento->id_actividad=$actividad->id_actividad;
                            $documento->nombre=$archivo->getClientOriginalName();
                            $documento->id_dominio_tipo=21;
                            $documento->estado_oculto=1;
                            $documento->descripcion="Documento de la actividad ".$actividad->nombre; 
                            $documento->save();
                                 //obtenemos el nombre del archivo
                            $fecha_actual = date('d-m-Y_H_i_ s');
                            $nombre = $documento->id_documento."_".$fecha_actual.'_'.$archivo->getClientOriginalName();
                            $ruta = '/files';
                             
                            Storage::disk('public')->put($ruta."/".$nombre,  \File::get($archivo));
                            $documento->url = $nombre;
                            $documento->save();
                        }
                        $mensaje = "Actividad subida";
                        session()->flash('mensaje_actividad', $mensaje);
                        return redirect()->route('persona/listar_materias_curso', ['id_curso' => $asignatura->id_curso]);
                    }	
    			
    		}
    		$errors = $validator->messages()->get('*');
        }

    	return view("actividad.agregar_actividad", compact("asignatura"), compact("errors"));
    }

    public function EditarActividad(Request $request, $id_actividad){
    	$actividad = Actividad::find($id_actividad);

    	$post = $request->all();
		
    	$errors = [];
    	if ($post) {
    		$post = (object) $post;
    		
    		$fecha_inicio = date('Y-m-d H:i', strtotime(str_replace("/", "-", explode(" - ", $post->fechas)[0])));
    		$fecha_fin = date('Y-m-d H:i', strtotime(str_replace("/", "-", explode(" - ", $post->fechas)[1])));
    		$request['fecha_inicio'] = $fecha_inicio;
    		$request['fecha_fin'] = $fecha_fin;

    		$validator = \Validator::make($request->except(['_token', 'archivos', 'fechas']), $actividad->rules);


    		if (!$validator->fails()){
    			$actividad->update($request->except(['_token', 'archivos', 'fechas']));

    			if(isset($post->archivos)){
    				foreach ($actividad->documentos as $documento) {
    					$ruta = '/files/'.$documento->url;
               
		                $exists =Storage::disk('public')->exists($ruta);
		                if($exists) Storage::disk('public')->delete($ruta);
		                $documento->delete();
    				}

    				foreach ($post->archivos as $archivo) {
    					$documento = new Documento;
	    				$documento->id_actividad=$actividad->id_actividad;
			            $documento->nombre=$archivo->getClientOriginalName();
			            $documento->id_dominio_tipo=21;
			            $documento->estado_oculto=1;
			            $documento->descripcion="Documento de la actividad ".$actividad->nombre; 
			            $documento->save();
			                 //obtenemos el nombre del archivo
		                $fecha_actual = date('d-m-Y_H_i_ s');
		                $nombre = $documento->id_documento."_".$fecha_actual.'_'.$archivo->getClientOriginalName();
		                $ruta = '/files';
		                 
		                Storage::disk('public')->put($ruta."/".$nombre,  \File::get($archivo));
		                $documento->url = $nombre;
		                $documento->save();
    				}	
    			}
    			$mensaje = "Actividad modificada";
 				session()->flash('mensaje_actividad', $mensaje);
    			return redirect()->route('persona/listar_materias_curso', ['id_curso' => $actividad->asignatura->id_curso]);
    		}
    		$errors = $validator->messages()->get('*');
    		
    	}
    	return view("actividad.editar_actividad", compact("actividad"), compact("errors"));
    }

    public function CambiarEstado($id_actividad){
        $actividad = Actividad::find($id_actividad);
        if ($actividad->estado == 1) {
        	$actividad->estado = 0;     	
        }else{
        	$actividad->estado = 1;
        }
        
        $actividad->update();

	     return response()->json([
	            'error' =>false
        ]);
	}

    public function VerEntregas($id_actividad){
        $actividad = Actividad::find($id_actividad);
        $asignatura = $actividad->asignatura;
        $curso = $asignatura->curso;
        $estudiantes = $curso->estudiantes();

        return view("actividad.ver_entregas", compact(["asignatura", "estudiantes", "actividad"]));
    }

    public function EliminarActividad($id_actividad){
        $actividad = Actividad::find($id_actividad);
        $documentos = $actividad->documentos;
        $entregas = $actividad->entregas;
        if(count($entregas) > 0){
           $mensaje = "No se puede eliminar la actividad, existen entregas asignadas";
           return response()->json([
                        'mensaje'=>$mensaje,
                        'error' =>true
                    ]);
        }else{

            foreach ($documentos as $documento) {
                $ruta = '/files/'.$documento->url;
                   
                $exists =Storage::disk('public')->exists($ruta);
                if($exists) Storage::disk('public')->delete($ruta);
                $documento->delete();
            }
           
            $actividad->delete();
            $mensaje = "Actividad eliminada exitosamente";
            return response()->json([
                            'mensaje'=>$mensaje,
                            'error' =>false
                        ]);
        }      
    }
}

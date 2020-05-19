<?php

namespace App\Http\Controllers;

use App\Actividad;
use App\Entrega;
use App\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EntregaController extends Controller
{
	public function ConsultarEntrega($id_entrega){
		$entrega = Entrega::find($id_entrega);
		$documentos = $entrega->documentos;
		return response()->json([
			'entrega'=>$entrega,
			'documentos'=>$documentos
			]);
	}

	public function AgregarEntrega(Request $request, $id_actividad)
	{
		$actividad = Actividad::find($id_actividad);
		$asignatura = $actividad->asignatura;
		$post = $request->all();
		$errors = [];
		if ($post) {
			$entrega = new Entrega;
			$post = (object) $post;

				$entrega->fill($request->except(['_token', 'archivos']));
				$entrega->id_estudiante = session('id_usuario');
				$entrega->id_actividad = $actividad->id_actividad;
				$entrega->id_estado = 26;
				
				if ($entrega->save()) {
    				foreach ($post->archivos as $archivo) {
	    				$documento = new Documento;
	    				$documento->id_entrega=$entrega->id_entrega;
			            $documento->nombre=$archivo->getClientOriginalName();
			            $documento->id_dominio_tipo=22;
			            $documento->estado_oculto=1;
			            $documento->descripcion="Documento de entrega de la actividad ".$actividad->nombre; 
			            $documento->save();

		                $fecha_actual = date('d-m-Y_H_i_ s');
		                $nombre = $documento->id_documento."_".$fecha_actual.'_'.$archivo->getClientOriginalName();
		                $ruta = '/files';
		                 
		                Storage::disk('public')->put($ruta."/".$nombre,  \File::get($archivo));
		                $documento->url = $nombre;
		                $documento->save();
		            }
		            $mensaje = "Entrega realizada correctamente";
         			session()->flash('mensaje_entrega', $mensaje);
            		return redirect()->route('asignatura/listar_documentos_materias', ['id_asignatura' => $asignatura->id_asignatura]);
    			}
			
			$errors = $validator->messages()->get('*');
		}
		return view("entrega.agregar_entrega", compact(["actividad", "asignatura"]), compact("errors"));
	}

	public function EditarEntrega(Request $request, $id_entrega){
		$entrega = Entrega::find($id_entrega);
		$actividad = $entrega->actividad;
		$asignatura = $entrega->actividad->asignatura;
		$documento = $entrega->documentos;
		$post = $request->all();
		$errors = [];
		$fecha_actual = date("Y-m-d H:i");
		$fecha_inicio = date("Y-m-d H:i", strtotime($actividad->fecha_inicio));
		$fecha_fin = date("Y-m-d H:i", strtotime($actividad->fecha_fin));

		if($fecha_actual >= $fecha_inicio and $fecha_actual <= $fecha_fin){
			if($post){
				$post = (object) $post;


					$entrega->update($request->except(['_token', 'archivos']));
					if(isset($post->archivos)){
	    				foreach ($entrega->documentos as $documento) {
	    					$ruta = '/files/'.$documento->url;
	               
			                $exists =Storage::disk('public')->exists($ruta);
			                if($exists) Storage::disk('public')->delete($ruta);
			                $documento->delete();
	    				}

	    				foreach ($post->archivos as $archivo) {
	    					$documento = new Documento;
		    				$documento->id_entrega=$entrega->id_entrega;
				            $documento->nombre=$archivo->getClientOriginalName();
				            $documento->id_dominio_tipo=22;
				            $documento->estado_oculto=1;
				            $documento->descripcion="Documento de entrega de la actividad ".$actividad->nombre; 
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
		    		$mensaje = "Entrega modificada";
		 			session()->flash('mensaje_entrega', $mensaje);
		    		return redirect()->route('asignatura/listar_documentos_materias', ['id_asignatura' => $asignatura->id_asignatura]);
				
				$errors = $validator->messages()->get('*');
			}
			return view("entrega.editar_entrega", compact(["entrega", "asignatura"]), compact("errors"));
		}
		$mensaje = "El plazo de entrega se ha vencido";
		session()->flash('mensaje_error_entrega', $mensaje);
		return redirect()->route('asignatura/listar_documentos_materias', ['id_asignatura' => $asignatura->id_asignatura]);
	}

	public function AgregarCalificacion(Request $request, $id_entrega){
		$post = $request->all();
		$entrega = Entrega::find($id_entrega);
		$entrega->id_estado = 25;
		$error = true;
		$mensaje = "";
		if($post){
			$post = (object) $post;
			if (isset($post->calificacion)) {
				$entrega->calificacion = $post->calificacion;
				$entrega->anotaciones = $post->anotaciones;
				$entrega->update();
				$mensaje = "Calificacion asignada correctamente";
				$error = false;
			}else{
				$mensaje = "Debe agregar una calificacion obligatoriamente";
				$error = true;
			}		
		}
		return response()->json([
			'mensaje'=>$mensaje,
			'entrega'=>$entrega,
			'error'=>$error
			]);
	}
}

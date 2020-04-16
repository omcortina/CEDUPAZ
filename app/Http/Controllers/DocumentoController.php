<?php

namespace App\Http\Controllers;

use App\Asignatura;
use App\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function SubirDocumento(Request $request)
    {
    	$post = $request->all();
    	if($post){
    		$post = (object) $post;

	    	$asignatura = Asignatura::find($post->id_asignatura);
	    	$archivo = $request->file("archivo");
            $documento = new Documento;
            $documento->id_asignatura=$asignatura->id_asignatura;
            $documento->nombre=$post->nombre;
            $documento->id_dominio_tipo=$post->id_dominio_tipo;
            $documento->estado_oculto=$post->estado_oculto;
            $documento->descripcion=$post->descripcion;
            if ($documento->id_dominio_tipo == 14) {
              $documento->url = $post->urlVideo;
            }else{
              if ($archivo) {   
                 //obtenemos el nombre del archivo
                 $fecha_actual = date('d-m-Y_H_i_ s');
                 $nombre = $fecha_actual.'_'.$archivo->getClientOriginalName();
                 $ruta = '/files';
                 
                 Storage::disk('public')->put($ruta."/".$nombre,  \File::get($archivo));

                 //
                 $documento->url = $nombre;
              }
            }  

            $documento->save();
            $mensaje = "Documento subido";
         	session()->flash('mensaje_documento', $mensaje); 
            return redirect()->route('persona/listar_materias_curso', ['id_curso' => $asignatura->id_curso]);
    	}
	}

    public function EditarDocumento(Request $request){
        $post = $request->all();
        if ($post) {
            $post = (object) $post;
            $archivo = $request->file("archivo");
            $asignatura = Asignatura::find($post->id_asignatura_documento);

            $documento = Documento::find($post->id_documento);
            $documento->nombre=$post->nombre;
            $documento->id_dominio_tipo=$post->id_dominio_tipo;
            $documento->estado_oculto=$post->estado_oculto;
            $documento->descripcion=$post->descripcion;
            if ($archivo != null && $documento->id_dominio_tipo != 14) {
                $ruta = '/files/'.$documento->url;
               
                $exists =Storage::disk('public')->exists($ruta);
                if($exists) Storage::disk('public')->delete($ruta);
                $documento->delete();
                
                $fecha_actual = date('d-m-Y_H_i_ s');
                $nombre = $fecha_actual.'_'.$archivo->getClientOriginalName();
                $ruta = '/files';
                 
                Storage::disk('public')->put($ruta."/".$nombre,  \File::get($archivo));

                $documento->url = $nombre;
            }

            if($documento->id_dominio_tipo == 14){
                $documento->url = $post->urlVideo;
            }

            $documento->save();
            $mensaje = "Documento modificado";
            session()->flash('mensaje_documento', $mensaje); 
            return redirect()->route('persona/listar_materias_curso', ['id_curso' => $asignatura->id_curso]);
        }
    }

    public function ConsultarDocumento($id_documento){
        $documento = Documento::find($id_documento);
        return response()->json($documento);

    }

	public function EliminarDocumento($id_documento){
        $documento = Documento::find($id_documento);
        $ruta = '/files/'.$documento->url;
               
        $exists =Storage::disk('public')->exists($ruta);
        if($exists) Storage::disk('public')->delete($ruta);
        $documento->delete();
	        return response()->json([
	            'error' =>false
        ]);
	}

	public function CambiarEstado($id_documento){
        $documento = Documento::find($id_documento);
        if ($documento->estado_oculto == 1) {
        	$documento->estado_oculto = 0;     	
        }else{
        	$documento->estado_oculto = 1;
        }
        
        $documento->update();

	     return response()->json([
	            'error' =>false
        ]);
	}


	public function downloadFile($id_documento){
	  $documento = Documento::find($id_documento);
      $pathtoFile = public_path().'/files/'.$documento->url;
      return response()->download($pathtoFile);
    }
}

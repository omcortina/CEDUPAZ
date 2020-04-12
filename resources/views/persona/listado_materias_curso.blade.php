<title>Listado Mis Cursos</title>
<?php 
header('Content-Type: text/html; charset=UTF-8');
?>
@extends('layouts.main_docente')
@section('content')
<style type="text/css">
    .au-task-list{
        height: 300px;
    }
</style>
<div class="row">
<div class="col-lg-1">
</div>
	<div class="col-lg-12">
	<div class="card">
            <div class="card-header">Listado mis cursos</div>
            <div class="card-body">
            
            <h3>{{ucwords(strtolower($curso->nombre))}}</h3>
            @if (session('mensaje_documento'))
                <div id="msg" class="alert alert-success" >
                    
                        <li>{{session('mensaje_documento')}}</li>
                </div>

                <script>
                    setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                </script>
            @endif
            <br>
            <div class="row">

                @foreach ($asignaturas as $asignatura)
                    
                
                <div class="col-lg-6">
                	
                    <div class="au-card au-card--no-shadow au-card--no-pad m-b-40 au-card--border">
                        <div class="au-card-title" style="background-image:url('{{ asset('Diseño/images/bg-title-01.jpg') }}');">
                            <div class="bg-overlay bg-overlay--blue"></div>
                            <h3>
                                <i class="zmdi zmdi-account-calendar"></i>{{mb_strtoupper($asignatura->nombre)}}</h3>
                            <button class="au-btn-plus" onclick="AbrirModalDocumento({{$asignatura->id_asignatura}})">
                                <i class="zmdi zmdi-plus"></i>
                            </button>
                        </div>
                        <div class="au-task js-list-load au-task--border">
                            <div class="au-task__title">
                                <p>Documentos</p>
                            </div>
                            @php

                            $contador = 0;
                            $colores = [
                                        'au-task__item au-task__item--danger',
                                        'au-task__item au-task__item--warning',
                                        'au-task__item au-task__item--primary',
                                        'au-task__item au-task__item--success'
                                        ]
                            @endphp
                            <div class="au-task-list js-scrollbar3">
                            @foreach ($asignatura->documentos as $documento)
                                <div class="{{$colores[$contador]}}">
                                    <div class="au-task__item-inner" id="div_documento">
                                        <div class=row>
                                            <div class="col-lg-6">
                                                <h5 class="task">
                                                    <a href="#"><b>Nombre: </b>{{ucwords(strtolower(str_replace("ñ", "n" ,$documento->nombre)))}}</a>
                                                </h5>

                                                <h5 class="task">
                                                    <a href="#"><b>Tipo: </b>{{ucwords(strtolower(str_replace("ñ", "n" ,$documento->tipo->nombre)))}}</a>
                                                </h5>
                                                <h5 class="task">
                                                    <a href="#"><b>Fecha: </b>{{date('d-m-Y', strtotime($documento->fecha))}}</a>
                                                </h5>
                                                <h5 class="task">
                                                    <a href="#"><b>Obervaciones: </b> <i style="margin-left: 10px" class="fa fa-comment" title="{{ucwords(strtolower(str_replace("ñ", "n" ,$documento->descripcion)))}}"></i></a>
                                                </h5>
                                            </div>
                                            <div class="col-lg-6">
                                                <br>
                                                <a class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="#" onclick="EliminarDocumento({{$documento->id_documento}})"><i class="fa fa-trash"></i></a>
                                                @if ($documento->estado_oculto == 0)
                                                    <a title="Cambiar a visible" class="pull-right" style="color: #007bff; cursor: pointer; margin-left: 15px" href="#" onclick="CambiarEstado({{$documento->id_documento}})"><i class="fa fa-eye-slash"></i></a>
                                                @else
                                                <a title="Ocultar" class="pull-right" style="color: #007bff; cursor: pointer; margin-left: 15px" href="#" onclick="CambiarEstado({{$documento->id_documento}})"><i class="fa fa-eye"></i></a>
                                                @endif
                                                @if ($documento->id_dominio_tipo != 14)
                                                    <a target="_blank" title="Descargar" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="{{ route('documento/download', $documento->id_documento) }}"><i class="fa fa-download"></i></a>
                                                @else
                                                <a title="Ver video" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="#" onclick="VerVideo('{{$documento->url}}')"><i class="fa fa-video-camera"></i></a>
                                                @endif    
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                @php
                                $contador ++;
                                if ($contador==4) $contador = 0;
                                @endphp
                            @endforeach
                            </div>                  
                        </div>
                    </div>
        
                </div>
                @endforeach
            </div>
				
        </div>
    </div>
</div>
</div>
@endsection
{{ Form::open(array('method' => 'post', 'files' => true, 'route' => 'documento/subir_documento'))}}
    <div class="modal fade" id="ModalDocumento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar documentos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id_asignatura" id="id_asignatura">
            <div class="form-group">
                <label for="cc-payment" class="control-label mb-1">Nombre</label>
                <input name="nombre" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
            </div>

            <div class="form-group">
                <label for="cc-payment" class="control-label mb-1">Tipo de documento</label>

                <select name="id_dominio_tipo"  class="form-control" onchange="if(this.value==14){$('#divUrlVideo').fadeIn(); $('#divDocumento').fadeOut()} else{$('#divUrlVideo').fadeOut(); $('#divDocumento').fadeIn()}">
                    @php
                        $tipos_de_documento = \App\Dominio::all()->where('id_padre',7);
                    @endphp
                            <option value="0">Seleccione...</option>
                            @foreach ($tipos_de_documento as $td)
                                <option value="{{$td->id_dominio}}">{{$td->nombre}}</option>
                            @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cc-payment" class="control-label mb-1">Tipo de documento</label>

                <select name="estado_oculto"  class="form-control">
                        <option value="1">Visible</option>
                        <option value="0">Oculto</option>
                </select>
            </div>

            <div class="form-group" id="divDocumento" style="display: none">
                <label for="cc-payment" class="control-label mb-1">Documento</label>
                <input name="archivo" type="file" id="file-input" name="file-input" class="form-control-file">
            </div>

            <div class="form-group" id="divUrlVideo" style="display: none">
                <label for="cc-payment" class="control-label mb-1">Url video</label>
                <input name="urlVideo" type="text" class="form-control" aria-required="true" aria-invalid="false">
            </div>

            <div class="form-group">
                <label for="cc-payment" class="control-label mb-1">Observaciones</label>
                <input name="descripcion" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Subir</button>
          </div>
        </div>
      </div>
    </div>
{{ Form::close() }}

<div class="modal fade" id="ModalVideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" style="max-width: 600px">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Video</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <iframe id="frame_video" width="560" height="315" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
              <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
</div>
<script>
    function AbrirModalDocumento(id_asignatura){
        $("#id_asignatura").val(id_asignatura)
        $("#ModalDocumento").modal("show")

    }

    function VerVideo(url){
        var url_video = url.replace("watch?v=", "embed/");
        document.getElementById('frame_video').src = url_video
        $("#ModalVideo").modal("show")

    }

    function EliminarDocumento(id_documento){
        Swal.fire({
          title: '¿Esta seguro que desea eliminar?',
          text: "El archivo se eliminara de forma permanente!",
          icon: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {
            var url = "../../documento/eliminar_documento/"+id_documento
            $.get(url, function(response) {
                if(response.error == false){
                    Swal.fire(
                      'Eliminado!',
                      'El archivo ha sido eliminado correctamente',
                      'success'
                    ).then((result) => {
                          if (result.value) {
                            location.reload()
                          }
                        })
                }
            })
            
          }
        })
    }

    function CambiarEstado(id_documento){
        Swal.fire({
          title: '¿Esta seguro que desea cambiar de estado?',
          icon: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, cambiar!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {
            var url = "../../documento/cambiar_estado/"+id_documento
            $.get(url, function(response) {
                if(response.error == false){
                    Swal.fire(
                      'Proceso exitoso!',
                      'El documento se ha modificado correctamente',
                      'success'
                    ).then((result) => {
                          if (result.value) {
                            location.reload()
                          }
                        })
                }
            })
            
          }
        })
    }
</script>


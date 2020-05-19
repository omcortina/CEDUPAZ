<title>Listado Mis Cursos</title>
@php
header("Content-Type: text/html; charset=utf-8");
  function quitar_tildes($cadena){
    $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù");
    $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U");
    $texto = str_replace($no_permitidas, $permitidas ,$cadena);
    return $texto;
  }
@endphp
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
            
            @if (session('mensaje_documento'))
                <div id="msg" class="alert alert-success" >
                    
                        <li>{{session('mensaje_documento')}}</li>
                </div>

                <script>
                    setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                </script>
            @endif

             @if (session('mensaje_actividad'))
                <div id="msg" class="alert alert-success" >
                    
                        <li>{{session('mensaje_actividad')}}</li>
                </div>

                <script>
                    setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                </script>
            @endif

            <div class="row">

                @foreach ($asignaturas as $asignatura)
                    
                
                <div class="col-lg-12">
                	
                    <div class="au-card au-card--no-shadow au-card--no-pad m-b-40 au-card--border">
                        <div class="au-card-title" style="background-image:url('{{ asset('Diseño/images/bg-title-01.jpg') }}');">
                            <div class="bg-overlay bg-overlay--blue"></div>
                            <h3>
                                <i class="zmdi zmdi-account-calendar"></i>{{mb_strtoupper($asignatura->nombre)}}</h3>
                                
                            <button class="au-btn-plus" onclick="AbrirModalOpciones({{$asignatura->id_asignatura}})" >
                                <a class="js-acc-btn" href="#"><i class="zmdi zmdi-plus"></i></a>       
                            </button>

                            
                          
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="au-task js-list-load au-task--border">
                                <div class="au-task__title">
                                    <p>Actividades</p>
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
                            @foreach ($asignatura->actividades as $actividad)
                                <div class="{{$colores[$contador]}}">
                                    <div class="au-task__item-inner" id="div_documento">
                                        <div class=row>
                                            <div class="col-lg-7">
                                                <h5 class="task">
                                                    <a href="#"><b>Nombre: </b>{{ucwords(strtolower(str_replace("ñ", "n" ,$actividad->nombre)))}}</a>
                                                </h5>

                                                <h5 class="task">
                                                    <a href="#"><b>Tipo: </b>{{ucwords(strtolower(str_replace("ñ", "n" ,$actividad->tipo->nombre)))}}</a>
                                                </h5>
                                                <h5 class="task">
                                                    <a href="#"><b>Apertura: </b>{{date('d-m-Y H:i', strtotime($actividad->fecha_inicio))}}<br>
                                                        <b>Cierre: </b>{{date('d-m-Y H:i', strtotime($actividad->fecha_fin))}}
                                                    </a>
                                                </h5>
                                                <h5 class="task">
                                                    <a href="#"><b>Observaciones: </b> <i style="margin-left: 10px" class="fa fa-comment" title="{{ucwords(strtolower(str_replace("ñ", "n",quitar_tildes($actividad->observaciones))))}}"></i></a>
                                                </h5>
                                            </div>
                                            <div class="col-lg-5">
                                                <br>

                                                <a title="Eliminar" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="#" onclick="EliminarActividad({{$actividad->id_actividad}})"><i class="fa fa-trash"></i></a>

                                                <a title="Ver entregas" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="{{ route('actividad/ver_entregas', $actividad->id_actividad) }}"><i class="fa fa-check-square"></i></a>

                                                <a title="Editar actividad" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="{{ route('actividad/editar_actividad', $actividad->id_actividad) }}"> <i class="fa fa-pencil-square-o"></i></a>

                                                @if ($actividad->estado == 0)
                                                    <a title="Cambiar a visible" class="pull-right" style="color: #007bff; cursor: pointer; margin-left: 15px" href="#" onclick="CambiarEstadoActividad({{$actividad->id_actividad}})"><i class="fa fa-eye-slash"></i></a>
                                                @else
                                                <a title="Ocultar" class="pull-right" style="color: #007bff; cursor: pointer; margin-left: 15px" href="#" onclick="CambiarEstadoActividad({{$actividad->id_actividad}})"><i class="fa fa-eye"></i></a>
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
                            <div class="col-lg-6">
                                <div class="au-task js-list-load au-task--border">
                            <div class="au-task__title">
                                <p>Documentos de apoyo</p>
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
                                                <a title="Eliminar" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="#" onclick="EliminarDocumento({{$documento->id_documento}})"><i class="fa fa-trash"></i></a>

                                                <a title="Editar documento" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="#" onclick="AbrirModalDocumentoEdit({{$documento->id_documento}})"> <i class="fa fa-pencil-square-o"></i></a>

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
                        
                    </div>
        
                </div>
                @endforeach
            </div>
				
        </div>
    </div>
</div>
</div>
@endsection

<div class="modal fade" id="modal_opciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Opciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <input type="hidden" id="id_asignatura_escogida">
            <div class="col-lg-6">
                <a onclick="AbrirModalDocumento(0)" href="#" class="btn btn-success" style="color: white; width: 100%"><i class="fa fa-book"></i> Nuevo documento</a>
            </div>

            <div class="col-lg-6">
                <a onclick="AgregarActividad()" class="btn btn-info" style="color: white; width: 100%"><i class="fa fa-users"></i> Nueva actividad</a>              
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{ Form::open(array('method' => 'post', 'files' => true, 'id'=>'form_documento', 'route' => 'documento/subir_documento'))}}
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

                <select name="id_dominio_tipo"  class="form-control" onchange="if(this.value==14){$('#divUrlVideo').fadeIn(); $('#divDocumento').fadeOut()} else{$('#divUrlVideo').fadeOut(); $('#divDocumento').fadeIn()} if(this.value==0){$('#divDocumento').fadeOut(); $('#divUrlVideo').fadeOut()}">
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
                <label for="cc-payment" class="control-label mb-1">Estado</label>

                <select name="estado_oculto"  class="form-control">
                        <option value="1">Visible</option>
                        <option value="0">Oculto</option>
                </select>
            </div>

            <div class="form-group" id="divDocumento" style="display: none">
                <label for="cc-payment" class="control-label mb-1">Documento</label>
                <input name="archivo" type="file" id="archivo" class="form-control-file">
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
            <button type="button" onclick="ValidarDocumentoAdd()" class="btn btn-primary">Subir</button>
          </div>
        </div>
      </div>
    </div>
{{ Form::close() }}

{{ Form::open(array('method' => 'post', 'files' => true, 'route' => 'documento/editar_documento'))}}
    <div class="modal fade" id="ModalDocumentoEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar documentos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id_documento" id="id_documento">
            <input type="hidden" name="id_asignatura_documento" id="id_asignatura_documento">
            <div class="form-group">
                <label for="cc-payment" class="control-label mb-1">Nombre</label>
                <input name="nombre" id="nombre" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
            </div>

            <div class="form-group">
                <label for="cc-payment" class="control-label mb-1">Tipo de documento</label>

                <select name="id_dominio_tipo" id="id_dominio_tipo"  class="form-control" onchange="if(this.value==14){$('#divUrlVideoEdit').fadeIn(); $('#divDocumentoEdit').fadeOut()} else{$('#divUrlVideoEdit').fadeOut(); $('#divDocumentoEdit').fadeIn()} if(this.value==0){$('#divDocumentoEdit').fadeOut(); $('#divUrlVideoEdit').fadeOut()}">
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
                <label for="cc-payment" class="control-label mb-1">Estado</label>

                <select name="estado_oculto" id="estado_oculto"  class="form-control">
                        <option value="1">Visible</option>
                        <option value="0">Oculto</option>
                </select>
            </div>

            <div class="form-group" id="divDocumentoEdit" style="display: none">
                <label for="cc-payment" class="control-label mb-1">Documento</label>
                <input name="archivo" type="file" id="archivo_edit" name="file-input" class="form-control-file">
            </div>

            <div class="form-group" id="divUrlVideoEdit" style="display: none">
                <label for="cc-payment" class="control-label mb-1">Url video</label>
                <input name="urlVideo" id="urlVideo" type="text" class="form-control" aria-required="true" aria-invalid="false">
            </div>

            <div class="form-group">
                <label for="cc-payment" class="control-label mb-1">Observaciones</label>
                <input name="descripcion" id="descripcion" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit"  class="btn btn-primary">Guardar Cambios</button>
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
    function ValidarDocumentoAdd(){
        var tipo_documento = $("#id_dominio_tipo").val()
        if(tipo_documento != 14){
            if(document.getElementById("archivo").files.length == 0 ){ 
                alert("Debe seleccionar un archivo valido.")
                return false;
            }
        }
        $("#form_documento").submit()
        //aqui todo esta bien
    }

    var asignatura_escojida = 0
    function AbrirModalOpciones(id_asignatura){
      $("#modal_opciones").modal("show")
      $("#id_asignatura_escogida").val(id_asignatura)
      asignatura_escojida = id_asignatura
      
    }

    function AgregarActividad(){
        asignatura_escojida = $("#id_asignatura_escogida").val()
        location.href="../../actividad/agregar_actividad/"+asignatura_escojida 
    }
    
    function AbrirModalDocumento(id_asignatura){
        if(asignatura_escojida != 0) id_asignatura = asignatura_escojida
        $("#id_asignatura").val(id_asignatura)
        $("#modal_opciones").modal("hide")
        $("#ModalDocumento").modal("show")
    }

    function AbrirModalDocumentoEdit(id_documento){
      $("#ModalDocumentoEdit").modal("show")
      var url = "../../documento/consultar_documento/"+id_documento
      $.get(url, function(response){
        $("#id_asignatura_documento").val(response.id_asignatura)
        $("#id_documento").val(response.id_documento)
        $("#nombre").val(response.nombre)
        $("#id_dominio_tipo").val(response.id_dominio_tipo)
        $("#estado_oculto option[value="+response.estado_oculto+"]").attr("selected",true)
          if(response.id_dominio_tipo == 14){
            $("#divDocumentoEdit").fadeOut()
            $("#divUrlVideoEdit").fadeIn()
            $("#urlVideo").val(response.url)
          }else{
            $("#divDocumentoEdit").fadeIn()
            $("#divUrlVideoEdit").fadeOut()
          }
        $("#descripcion").val(response.descripcion)
      })
    }

    function VerVideo(url){
        var url_video = url
        var is_punto_be = url_video.includes("youtu.be")
        var is_youtube_punto_com = url_video.includes("www.youtube.com")
        if(is_punto_be){
            url_video = url.replace("youtu.be/", "www.youtube.com/")
            url_video = url_video.split("www.youtube.com/")
            var primera_parte = url_video[0]+("www.youtube.com/")
            var segunda_parte = url_video[1]
            var url_completa = primera_parte+"embed/"+segunda_parte
            document.getElementById('frame_video').src = url_completa  
            $("#ModalVideo").modal("show")
        }
        
        if(is_youtube_punto_com){
            url_video = url.replace("watch?v=", "embed/")
            url_video = url_video.split("&")
            var url_nueva = url_video[0]
            document.getElementById('frame_video').src = url_nueva  
            $("#ModalVideo").modal("show")
        }  
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

    function EliminarActividad(id_actividad){
        Swal.fire({
          title: '¿Esta seguro que desea eliminar?',
          text: "La actividad se eliminara de forma permanente!",
          icon: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {
            var url = "../../actividad/eliminar_actividad/"+id_actividad
            $.get(url, function(response) {
                if(response.error == false){
                    Swal.fire(
                      'Eliminado!',
                      response.mensaje,
                      'success'
                    ).then((result) => {
                          if (result.value) {
                            location.reload()
                          }
                        })
                }else{
                    Swal.fire(
                      'Error!',
                      response.mensaje,
                      'warning'
                    )
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

    function CambiarEstadoActividad(id_actividad){
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
            var url = "../../actividad/cambiar_estado_actividad/"+id_actividad
            $.get(url, function(response) {
                if(response.error == false){
                    Swal.fire(
                      'Proceso exitoso!',
                      'La actividad se ha modificado correctamente',
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


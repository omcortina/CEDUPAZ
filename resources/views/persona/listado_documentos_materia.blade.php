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
@extends('layouts.main_estudiante')
@section('content')
<style type="text/css">
    .au-task-list{
        height: 400px;
    }
</style>
<div class="row">
<div class="col-lg-1">
</div>
	<div class="col-lg-12">
	<div class="card">
            <div class="card-header">Listado de documentos</div>
            <div class="card-body">

            @if (session('mensaje_entrega'))
                <div id="msg" class="alert alert-success" >
                    
                        <li>{{session('mensaje_entrega')}}</li>
                </div>

                <script>
                    setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                </script>
            @endif

            @if (session('mensaje_error_entrega'))
                <div id="msg" class="alert alert-danger" >
                    
                        <li>{{session('mensaje_error_entrega')}}</li>
                </div>

                <script>
                    setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                </script>
            @endif
            <div class="row"> 
                <div class="col-lg-12">
                	
                    <div class="au-card au-card--no-shadow au-card--no-pad m-b-40 au-card--border">
                        <div class="au-card-title" style="background-image:url('{{ asset('Diseño/images/bg-title-01.jpg') }}');">
                            <div class="bg-overlay bg-overlay--blue"></div>
                            <h3>
                                <i class="zmdi zmdi-account-calendar"></i>{{mb_strtoupper($asignatura->nombre)}}</h3>
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
                            @php
                                $entrega = \App\Entrega::where('id_estudiante', session('id_usuario'))->where('id_actividad', $actividad->id_actividad)->first();
                            @endphp
                            @if ($actividad->estado == 1)
                              <div class="{{$colores[$contador]}}">
                                    <div class="au-task__item-inner" id="div_documento">
                                        <div class=row>
                                            <div class="col-lg-8">
                                              @if ($entrega != null)
                                                <h5 class="task">
                                                    <a href="#"><b>Nombre: </b>{{ucwords(strtolower(str_replace("ñ", "n" ,$actividad->nombre)))}}</a>
                                                </h5>
                                                <h5 class="task">
                                                    <a href="#"><b>Apertura: </b> {{date('d-m-Y H:i', strtotime($actividad->fecha_inicio))}}<br>
                                                        <b>Cierre: </b>{{date('d-m-Y H:i', strtotime($actividad->fecha_fin))}}
                                                    </a>
                                                </h5>

                                                  <h5 class="task">
                                                    <a href="#"><b>Estado: </b>{{ucwords(strtolower(str_replace("ñ", "n" ,$entrega->estado->nombre)))}}</a>
                                                  </h5>

                                                  <h5 class="task">
                                                    <a href="#"><b>Calificación: </b>{{ucwords(strtolower(str_replace("ñ", "n" ,$entrega->calificacion)))}}</a>
                                                  </h5>
                                                  <h5 class="task">
                                                    @php
                                                      header("Content-Type: text/html; charset=utf-8");
                                                    @endphp
                                                    <a href="#"><b>Anotaciones: </b>{{ucwords(strtolower(str_replace("ñ", "n" ,quitar_tildes($entrega->anotaciones))))}}</a>
                                                  </h5>
                                              @else
                                              <h5 class="task">
                                                    <a href="#"><b>Nombre: </b>{{ucwords(strtolower(str_replace("ñ", "n" ,$actividad->nombre)))}}</a>
                                                </h5>
                                                <h5 class="task">
                                                    <a href="#"><b>Apertura: </b> {{date('d-m-Y H:i', strtotime($actividad->fecha_inicio))}}<br>
                                                        <b>Cierre: </b>{{date('d-m-Y H:i', strtotime($actividad->fecha_fin))}}
                                                    </a>
                                                </h5>
                                              @endif
                                                
                                                
                                            </div>
                                            <div class="col-lg-4">
                                                <br>
                                                @php
                                                    $fecha_actual = date("Y-m-d H:i");
                                                    $fecha_inicio = date("Y-m-d H:i", strtotime($actividad->fecha_inicio));
                                                    $fecha_fin = date("Y-m-d H:i", strtotime( $actividad->fecha_fin));
                                                @endphp
                                                
                                                @if ($entrega == null)
                                                  @if ($fecha_actual >= $fecha_inicio and $fecha_actual <= $fecha_fin)
                                                    <a title="Ver informacion" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="#" onclick="VerInformacion({{$actividad->id_actividad}})"> <i class="fa fa-info-circle"></i></a>

                                                    <a title="Agregar entrega" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="{{ route('entrega/agregar_entrega', $actividad->id_actividad) }}"><i class="fa fa-plus"></i></a>
                                                  @else
                                                    <a title="Ver informacion" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="#" onclick="VerInformacion({{$actividad->id_actividad}})"> <i class="fa fa-info-circle"></i></a>
                                                  @endif
                                                    
                                                  @else
                                                  
                                                  @if ($entrega->calificacion != null)
                                                    <a title="Ver informacion" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="#" onclick="VerInformacion({{$actividad->id_actividad}})"> <i class="fa fa-info-circle"></i></a>

                                                    <a title="Ver mi entrega" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="#" onclick="VerMiEntrega({{$entrega->id_entrega}})"> <i class="fa fa-eye"></i></a>
                                                    @else
                                                    @if ($fecha_actual >= $fecha_inicio and $fecha_actual <= $fecha_fin)
                                                      <a title="Ver informacion" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="#" onclick="VerInformacion({{$actividad->id_actividad}})"> <i class="fa fa-info-circle"></i></a>

                                                      <a title="Ver mi entrega" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="#" onclick="VerMiEntrega({{$entrega->id_entrega}})"> <i class="fa fa-eye"></i></a>

                                                      <a title="Editar entrega" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="{{ route('entrega/editar_entrega', $entrega->id_entrega) }}"> <i class="fa fa-pencil-square-o"></i></a>
                                                      @else
                                                      <a title="Ver informacion" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="#" onclick="VerInformacion({{$actividad->id_actividad}})"> <i class="fa fa-info-circle"></i></a>

                                                      <a title="Ver mi entrega" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="#" onclick="VerMiEntrega({{$entrega->id_entrega}})"> <i class="fa fa-eye"></i></a>
                                                    @endif
                                                  @endif 
                                                @endif   
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                              @endif
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
                                    @if ($documento->estado_oculto == 1)

                                        <div class="{{$colores[$contador]}}">
                                            <div class="au-task__item-inner" id="div_documento">
                                                <div class=row>
                                                    <div class="col-lg-6">
                                                        <h5 class="task">
                                                            <a href="#">{{ucwords(strtolower(str_replace("ñ", "n" ,$documento->nombre)))}}</a>
                                                        </h5>

                                                        <span class="time">{{date('d-m-Y', strtotime($documento->fecha))}}</span>
                                                        <h5 class="task">
                                                            <a href="#">{{ucwords(strtolower(str_replace("ñ", "n" ,$documento->descripcion)))}}</a>
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <br>
                                                     @if ($documento->id_dominio_tipo != 14)
                                                        <a target="_blank" title="Descargar" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="{{ route('documento/download', $documento->id_documento) }}"><i class="fa fa-download"></i></a>
                                                    @else
                                                    <a title="Ver video" class="pull-right" style="margin-left: 15px; color: #007bff; cursor: pointer;" href="#" onclick="VerVideo('{{$documento->url}}')"><i class="fa fa-video-camera"></i></a>
                                                    @endif 
                                                    </div>
                                                </div>                                        
                                            </div>
                                        </div>
                                    @endif   
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
                
            </div>
				
        </div>
    </div>
</div>
</div>
@endsection

<div class="modal fade" id="ModalInformacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 550px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Informacion de la actividad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id_documento" id="id_documento">
        <input type="hidden" name="id_asignatura_documento" id="id_asignatura_documento">
        <div class="form-group">
            <label for="cc-payment" class="control-label mb-1" id="nombre_actividad"></label>
        </div>

        <div class="form-group">
            <label for="cc-payment" class="control-label mb-1" id="tipo_actividad"></label>
        </div>

        <div class="form-group">
            <label for="cc-payment" class="control-label mb-1" id="lapso_entrega_actividad"></label>
        </div>

        <div class="form-group">
            <label for="cc-payment" class="control-label mb-1" id="observaciones_actividad"></label>
        </div>

        <div class="table-responsive table--no-card m-b-30">
          <table class="table table-borderless table-striped table-earning">
              <thead>
                  <tr>
                      <th>Documento</th>
                      <th><center>Descargar</center></th>
                  </tr>
              </thead>
              <tbody id="bodytableDocumentos">

              </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalInformacionEntrega" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 550px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Informacion de la entrega</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id_documento" id="id_documento">
        <input type="hidden" name="id_asignatura_documento" id="id_asignatura_documento">

        <div class="form-group">
            <label for="cc-payment" class="control-label mb-1" id="actividad"></label>
        </div>

        <div class="form-group">
            <label for="cc-payment" class="control-label mb-1" id="observaciones_entrega"></label>
        </div>

        <div class="table-responsive table--no-card m-b-30">
          <table class="table table-borderless table-striped table-earning">
              <thead>
                  <tr>
                      <th>Documento</th>
                      <th><center>Descargar</center></th>
                  </tr>
              </thead>
              <tbody id="bodytableDocumentosEntrega">

              </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

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

    function VerInformacion(id_actividad){
      $("#ModalInformacion").modal("show")
      $("#bodytableDocumentos").html('')
      var url="../../actividad/consultar_actividad/"+id_actividad
      $.get(url, function(response){
        $("#nombre_actividad").html("<b>Nombre:</b> "+response.actividad.nombre)
        $("#tipo_actividad").html("<b>Tipo:</b> "+response.tipo)
        $("#lapso_entrega_actividad").html("<b>Lapso de entrega:</b> "+response.actividad.fecha_inicio+" - "+response.actividad.fecha_fin)
        if(response.actividad.observaciones != null){
          $("#observaciones_actividad").html("<b>Observaciones:</b> "+response.actividad.observaciones)
        }else{
          $("#observaciones_actividad").html("<b>Observaciones:</b> Sin observaciones")
        }

        response.documentos.forEach(function(documento){
          var fila = "<tr>"+
                       "<td>"+documento.nombre+"</td>"+
                       "<td><center><a target=_blank href='../../documento/download/"+documento.id_documento+"'><i class='fa fa-download' style='color: #6c757d'></i></a></center></td>"+
                     "</tr>"
          $("#bodytableDocumentos").append(fila)
        })
      })
    }

    function VerMiEntrega(id_entrega){
      $("#ModalInformacionEntrega").modal("show")
      $("#bodytableDocumentosEntrega").html('')
      var url="../../entrega/consultar_entrega/"+id_entrega
      $.get(url, function(response){
        $("#actividad").html("<b>Actividad:</b> "+response.actividad.nombre)
        if(response.entrega.observaciones != null){
          $("#observaciones_entrega").html("<b>Mis observaciones:</b> "+response.entrega.observaciones)
        }else{
          $("#observaciones_entrega").html("<b>Mis observaciones:</b> Sin observaciones")
        }

        response.documentos.forEach(function(documento){
          var fila = "<tr>"+
                       "<td>"+documento.nombre+"</td>"+
                       "<td><center><a target=_blank href='../../documento/download/"+documento.id_documento+"'><i class='fa fa-download' style='color: #6c757d'></i></a></center></td>"+
                     "</tr>"
          $("#bodytableDocumentosEntrega").append(fila)
        })
      })
    }
</script>


<title>Ver entregas</title>
@extends('layouts.main_docente')
@section('content')
<div class="row">
	<div class="col-lg-1">
	</div>
	<div class="col-lg-12">
		<div class="card">
        	<div class="card-header">Listado de estudiantes</div>
        	@if (count($errors)>0)
                	<div id="msg" class="alert alert-danger alert-dismissible fade show" >
                		@foreach ($errors as $key => $value)
                			<li>{{$value[0]}}</li>
                		@endforeach
                	</div>

                	<script>
                		setTimeout(function(){ $('#msg').fadeOut() }, 10000);
                	</script>
                @endif
            <div class="card-body">
            	<div class="col-lg-12">
                	
                    <div class="au-card au-card--no-shadow au-card--no-pad m-b-40 au-card--border">
                        <div class="au-card-title" style="background-image:url('{{ asset('Diseño/images/bg-title-01.jpg') }}');">
                            <div class="bg-overlay bg-overlay--blue"></div>
                            <h3>
                                <i class="zmdi zmdi-account-calendar"></i>{{mb_strtoupper($asignatura->nombre)}}</h3>
                        </div>
                        <div class="au-task js-list-load au-task--border">
                            <div class="au-task__title">
                                <p><b>Entregas</b></p>
                            </div>
                            <div class="au-task-list js-scrollbar3">
                                <div>
                                    <div class="au-task__item-inner">
                                    	<input type="hidden" name="id_asignatura" value="{{$asignatura->id_asignatura}}">
	                                        <div class="row">
								                <div class="col-lg-12">
								                	<div class="table-responsive table--no-card m-b-30">
								                		<table class="table table-borderless table-striped table-earning">
								            				<thead>
								            					<tr>
								                                    <th>Estudiante</th>
								                                    <th>Estado</th>
								                                    <th><center>Ver entrega</center></th>
								                                    <th>Calificacion</th>
								            					</tr>
								            				</thead>
								            				<tbody id="bodytable">
								            				    @foreach ($estudiantes as $e)
								            				    @php
								            				    	$entrega = \App\Entrega::where('id_actividad', $actividad->id_actividad)->where('id_estudiante', $e->id_persona)->first();
								            				    @endphp
								            				    @if ($entrega != null)
								            				    	<tr>
								                                    <td>{{$e->nombre}} {{$e->apellido}}</td>
								                                    <td>Entregado</td>
								                                	<td><center><a title="Ver entrega" href="#" onclick="VerInformacionEntrega({{$entrega->id_entrega}})"><i class="fa fa-eye" style="color: #6c757d"></i></a></center></td>
								                                	@if ($entrega->calificacion != null)
								                                		<td>{{$entrega->calificacion}}</td>
								                                	@else
								                                	<td>Sin calificar</td>
								                                	@endif
								                                	
								            					   </tr>

								            					@else
								            						<tr>
								                                    <td>{{$e->nombre}} {{$e->apellido}}</td>
								                                    <td>No entregado</td>
								            					   </tr>
								            				    @endif	
								            				    @endforeach
								            				</tbody>
								    			         </table>
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
    </div>
</div>
@endsection

<div class="modal fade" id="ModalInformacionEntrega" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 550px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Informacion de la entrega</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive table--no-card m-b-30">
          <table class="table table-borderless table-striped table-earning">
          	<input id="id_entrega" type="hidden" name="id_entrega">
              <thead>
                  <tr>
                      <th>Documento</th>
                      <th><center>Descargar</center></th>
                  </tr>
              </thead>
              <tbody id="bodytableEntregas">

              </tbody>
          </table>
        </div>

        <div class="form-group">
            <label for="cc-payment" class="control-label mb-1" id="observaciones_entrega"></label>
        </div>

        <div class="form-group">
            <label for="cc-payment" class="control-label mb-1">Calificacion</label>
            <input id="calificacion" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-primary" onclick="AgregarCalificacion()">Enviar calificacion</button>
      </div>
    </div>
  </div>
</div>

<script>
	function VerInformacionEntrega(id_entrega){
		$("#ModalInformacionEntrega").modal("show")
		$("#bodytableEntregas").html('')
		$("#id_entrega").val(id_entrega)
		var url="../../entrega/consultar_entrega/"+id_entrega
		$.get(url, function(response){
			response.documentos.forEach(function(documento){
	          var fila = "<tr>"+
	                       "<td>"+documento.nombre+"</td>"+
	                       "<td><center><a target=_blank href='../../documento/download/"+documento.id_documento+"'><i class='fa fa-download' style='color: #6c757d'></i></a></center></td>"+
	                     "</tr>"
	          $("#bodytableEntregas").append(fila)
	        })
			$("#calificacion").val(response.entrega.calificacion)
	        if(response.entrega.observaciones != null){
				$("#observaciones_entrega").html("<b>Observaciones:</b> "+response.entrega.observaciones)
			}else{
				$("#observaciones_entrega").html("<b>Observaciones:</b> Sin observaciones")
			}
		})
	}

	function AgregarCalificacion(){
		var id_entrega = $("#id_entrega").val()
		var calificacion = $("#calificacion").val()
		var url="../../entrega/agregar_calificacion/"+id_entrega+"/"+calificacion
		$.get(url, function(response){
			if(response.error==false){
				swal.fire("Proceso Exitoso",response.mensaje,"success").then((result)=>{
                    if(result.value==true) location.reload()
                })
			}
		})
	}
</script>
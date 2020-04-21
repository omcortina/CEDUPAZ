<title>Agregar Actividad</title>
@extends('layouts.main_docente')
@section('content')
<style type="text/css">

	.au-task-list {
    height: 100% !important;
	}
	.files input {
    outline: 2px dashed #92b0b3;
    outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear;
    padding: 120px 0px 85px 35%;
    text-align: center !important;
    margin: 0;
    width: 100% !important;
}
.files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
 }
.files{ position:relative}
.files:after {  pointer-events: none;
    position: absolute;
    top: 60px;
    left: 0;
    width: 50px;
    right: 0;
    height: 56px;
    content: "";
    background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);
    display: block;
    margin: 0 auto;
    background-size: 100%;
    background-repeat: no-repeat;
}
.color input{ background-color:#f1f1f1;}
.files:before {
    position: absolute;
    bottom: 10px;
    left: 0;  pointer-events: none;
    width: 100%;
    right: 0;
    height: 57px;
    content: " Arrastra los archivos. ";
    display: block;
    margin: 0 auto;
    color: #2ea591;
    font-weight: 600;
    text-transform: capitalize;
    text-align: center;
}
</style>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<div class="row">
	<div class="col-lg-1">
	</div>
	<div class="col-lg-12">
		<div class="card">
        	<div class="card-header">Agregar nueva actividad</div>
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
                                <p><b>Nueva actividad</b></p>
                            </div>
                            <div class="au-task-list js-scrollbar3">
                                <div>
                                    <div class="au-task__item-inner">
                                    	{{ Form::open(array('method' => 'post', 'files' => true)) }}
                                    	<input type="hidden" name="id_asignatura" value="{{$asignatura->id_asignatura}}">
	                                        <div class="row">	
	                                        	<div class="col-lg-4">
	                                        		<div class="form-group">
								                        <label for="cc-payment" class="control-label mb-1">Nombre</label>
								                        <input name="nombre" type="text" class="form-control" aria-required="true" aria-invalid="false" value="">
								                    </div>
								                </div>

								                <div class="col-lg-4">
								                	<div class="form-group">
								                        <label for="cc-payment" class="control-label mb-1">Tipo</label>
								                        <select class="form-control" name="id_dominio_tipo">
									                        @php
										                        $tipos_de_actividad = \App\Dominio::all()->where('id_padre',18);
										                    @endphp
										                    <option value="0">Seleccione...</option>
										                    @foreach ($tipos_de_actividad as $ta)
										                      <option value="{{$ta->id_dominio}}">{{$ta->nombre}}</option>    
                    										@endforeach
								                        </select>
								                    </div>
												</div>

								                <div class="col-lg-4">
								                	<div class="form-group">
								                        <label for="cc-payment" class="control-label mb-1">Estado</label>
								                        <select class="form-control" name="estado">
								                        	<option value="1">Visible</option><option value="0">Oculto</option>
								                        </select>
								                    </div>
												</div>
	                                        </div>

	                                        <div class="row">
	                                        	<div class="col-lg-12">
	                                        		<div class="form-group">
								                        <label for="cc-payment" class="control-label mb-1">Fechas de entrega</label>
								                        <input name="fechas" type="text" class="form-control" aria-required="true" aria-invalid="false" value="">
								                    </div>
								                </div>
	                                        </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="cc-payment" class="control-label mb-1">Obervaciones</label>
                                                        <input name="observaciones" type="text" class="form-control" aria-required="true" aria-invalid="false" value="">
                                                    </div>
                                                </div>
                                            </div>

	                                      <div class="row">
	                                        	<div class="col-md-12">
									              <div class="form-group files">
									                <label>Subir archivos </label>
									                <input type="file" class="form-control" multiple="multiple" name="archivos[]">
									              </div>
											  </div>
	                                        </div>
	                                      <div class="row">
	                                      	<div class="col-lg-3"></div>
	                                      	<div class="col-lg-6">
	                                      		<button type="submit" class="btn btn-primary" style="width: 100%">Subir</button>
	                                      	</div>
	                                      </div>
                                        {{ Form::close() }}
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
<script>
	$(document).ready(function(){
		$('input[name="fechas"]').daterangepicker({
	     timePicker: true,
	     timePicker24Hour: true,
		    locale: {
		      format: 'DD/MM/YYYY HH:mm'
		    }
	  });
	})
</script>
@endsection


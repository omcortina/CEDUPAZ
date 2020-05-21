<title>Agregar Actividad</title>
@extends('layouts.main_docente')
@section('content')

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
                    @if (session('mensaje_error_actividad'))
                        <div id="msg" class="alert alert-danger" >
                            
                                <li>{{session('mensaje_actividad')}}</li>
                        </div>

                        <script>
                            setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                        </script>
                    @endif
                	
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
                                    	{{ Form::open(array('method' => 'post', 'id'=>'form_agregar_actividad', 'files' => true)) }}
                                    	<input type="hidden" name="id_asignatura" value="{{$asignatura->id_asignatura}}">
	                                        <div class="row">	
	                                        	<div class="col-lg-4">
	                                        		<div class="form-group">
								                        <label for="cc-payment" class="control-label mb-1">Nombre</label>
								                        <input id="cc-name" name="nombre" type="text" class="form-control cc-name valid" data-val="true" data-val-required="Por favor digite el telefono"
                            autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error" required>
								                    </div>
								                </div>

								                <div class="col-lg-4">
								                	<div class="form-group">
								                        <label for="cc-payment" class="control-label mb-1">Tipo</label>
								                        <select class="form-control" name="id_dominio_tipo" required>
									                        @php
										                        $tipos_de_actividad = \App\Dominio::all()->where('id_padre',18);
										                    @endphp
										                    <option value="">Seleccione...</option>
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
								                        	<option value="1">Visible</option>
                                                            <option value="0">Oculto</option>
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
                                                        <label for="cc-payment" class="control-label mb-1">Observaciones</label>
                                                        <input name="observaciones" type="text" class="form-control" aria-required="true" aria-invalid="false" value="">
                                                    </div>
                                                </div>
                                            </div>
	                                      
	                                      <div class="row">
	                                      	<div class="col-lg-3"></div>
	                                      	<div class="col-lg-6">
	                                      		<button type="submit"class="btn btn-primary" style="width: 100%">Subir</button>
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


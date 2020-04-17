<title>Editar Estudiante</title>
@extends('layouts.main')
@section('content')
<div class="row">
<div class="col-lg-2">
</div>
	<div class="col-lg-8">
        <div class="card">
            <div class="card-header">Estudiante</div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">Editar Estudiantes</h3>
                </div>
                <hr>
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
                {{ Form::open(array('method' => 'post')) }}
                    <input type="hidden" name="id_persona" value="{{$persona->id_persona}}">
                    <div class="form-group">
                        <label for="cc-payment" class="control-label mb-1">Identificacion</label>
                        <input name="identificacion" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$persona->identificacion}}">
                    </div>

                    <div class="form-group has-success">
                        <label for="cc-name" class="control-label mb-1">Nombre</label>
                        <input id="cc-name" name="nombre" type="text" class="form-control cc-name valid" data-val="true" data-val-required="Por favor digite el telefono"
                            autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error" value="{{$persona->nombre}}">
                        <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                    </div>

                    <div class="form-group">
                        <label for="cc-number" class="control-label mb-1">Apellido</label>
                        <input id="cc-number" name="apellido" type="text" class="form-control cc-number identified visa" value="{{$persona->apellido}}" data-val="true"
                            data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number"
                            autocomplete="cc-number" >
                        <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                    </div>  

                    <div class="form-group">
                        <label for="cc-number" class="control-label mb-1">Email</label>
                        <input id="cc-number" name="email" type="text" class="form-control cc-number identified visa" value="{{$persona->email}}" data-val="true"
                            data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number"
                            autocomplete="cc-number" >
                        <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                    </div>

                    <div class="form-group">
                        <label for="cc-number" class="control-label mb-1">Telefono</label>
                        <input id="cc-number" name="telefono" type="text" class="form-control cc-number identified visa" value="{{$persona->telefono}}" data-val="true"
                            data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number"
                            autocomplete="cc-number" >
                        <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                    </div>

                    <div class="form-group">
                        <label for="cc-payment" class="control-label mb-1">Sexo</label>

                        <select name="id_dominio_tipo_sexo"  class="form-control">
                            @php
                                $tipos_de_sexo = \App\Dominio::all()->where('id_padre',11);
                            @endphp
                                    <option value="0">Seleccione...</option>
                                    @foreach ($tipos_de_sexo as $ts)
                                    @if ($ts->id_dominio==$persona->id_dominio_tipo_sexo)
                                        <option selected value="{{$ts->id_dominio}}">{{$ts->nombre}}</option>
                                    @endif
                                        <option value="{{$ts->id_dominio}}">{{$ts->nombre}}</option>
                                    @endforeach
                        </select>
                     </div>

                    <div class="form-group">
                        <label for="cc-number" class="control-label mb-1">Username</label>
                        <input id="cc-number" name="username" type="text" class="form-control cc-number identified visa" value="{{$persona->username}}" data-val="true"
                            data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number"
                            autocomplete="cc-number" >
                        <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                    </div>

                    <div class="form-group">
                        <label for="cc-number" class="control-label mb-1">Password</label>
                        <input id="cc-number" name="password" type="text" class="form-control cc-number identified visa" value="{{$persona->password}}" data-val="true"
                            data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number"
                            autocomplete="cc-number" >
                        <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                    </div>

                    <div class="form-group">
                        <label for="cc-payment" class="control-label mb-1">Grado</label>

                        <select id="selectGrado"  class="form-control" onchange="if(this.value!=0){$('#divCurso').fadeIn()} else{$('#divCurso').fadeOut()} MostrarSubCursos()"> 
                            <option value="0">Seleccione...</option>

                            @foreach ($cursos as $c)
                                @if ($persona->cursoActual() != null)
                                    @if ($c->id_curso==$persona->cursoActual()->id_padre)
                                        
                                        <option selected value="{{$c->id_curso}}">{{$c->nombre}}</option>>
                                    @else
                                        <option value="{{$c->id_curso}}">{{$c->nombre}}</option>
                                    @endif
                                @endif
                                

                                
                            @endforeach
                        </select>
                     </div>

                     <div class="form-group" id="divCurso" style="display: none">
                        <label for="cc-payment" class="control-label mb-1">Curso</label>

                        <select name="id_curso" id="selectCurso"  class="form-control">
                            
                        </select>
                     </div>

                     @if ($persona->cursoActual() != null)
                         <script>$('#divCurso').fadeIn(); MostrarSubCursos() </script>
                     @endif

                    <div>
                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                            <i class="fa fa-lock fa-lg"></i>&nbsp;
                            <span id="payment-button-amount">Guardar Cambios</span>
                            <span id="payment-button-sending" style="display:none;">Sending…</span>
                        </button>
                    </div>
                    <br>
                    <div>
                        <a id="payment-button" class="btn btn-lg btn-danger btn-block" style="color: white" href="{{ route('persona/eliminar_estudiante' ,$persona->id_persona)}}">
                            <i class="fa fa-trash fa-lg"></i>&nbsp;
                            <span id="payment-button-amount">Eliminar</span>
                            <span id="payment-button-sending" style="display:none;">Sending…</span>
                        </a>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    </div>
@endsection


<script>
    function MostrarSubCursos(){
        $("#selectCurso").html('<option value="0">Seleccione...</option>')
        var id_curso_padre = $("#selectGrado").val()
        var url = "../../curso/consultar_sub_cursos/"+id_curso_padre
        $.get(url, function(response){
            response.forEach((sub_cursos)=>{
                if(sub_cursos.id_curso == {{$persona->cursoActual()->id_curso}}){
                    var opcion = "<option selected value='"+sub_cursos.id_curso+"'>"+sub_cursos.nombre+"</option>"
                }else{
                    var opcion = "<option value='"+sub_cursos.id_curso+"'>"+sub_cursos.nombre+"</option>"
                }
                 $("#selectCurso").append(opcion)   
            })
        })
    }
</script>
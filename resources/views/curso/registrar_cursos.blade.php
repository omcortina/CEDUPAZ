<title>Registrar Curso</title>
@extends('layouts.main')
@section('content')
<div class="row">
<div class="col-lg-2">
</div>
	<div class="col-lg-8">
        <div class="card">
            <div class="card-header">Curso</div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">Registrar curso</h3>
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

                    <div class="form-group">
                        <label for="cc-payment" class="control-label mb-1">Codigo</label>
                        <input id="codigo_padre" value="{{$curso->codigo}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                    </div>

                    <div class="form-group has-success">
                        <label for="cc-name" class="control-label mb-1">Nombre</label>
                        <input id="nombre_padre" value="{{$curso->nombre}}" type="text" class="form-control cc-name valid" data-val="true" data-val-required="Por favor digite el telefono"
                            autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error" required>
                        <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                    </div>
    
                    <div>
                        <button id="payment-button" onclick="Registrar()" class="btn btn-lg btn-info btn-block">
                            <i class="fa fa-lock fa-lg"></i>&nbsp;
                            <span id="payment-button-amount">Registrar</span>
                            <span id="payment-button-sending" style="display:none;">Sending…</span>
                        </button>
                    </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6">Subcursos</div>
                    <div class="col-lg-6"><button class="btn btn-info pull-right" style="margin-bottom: 5px" data-toggle="modal" data-target="#ModalSubcurso">Agregar subcurso</button></div>
                </div>
            </div>
                <div class="card-body">    
    
        <div class="table-responsive table--no-card m-b-30">
            <table class="table table-borderless table-striped table-earning">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Quitar</th>
                    </tr>
                </thead>
                <tbody id="bodytable">
                    
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

<div class="modal fade" id="ModalSubcurso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar subcurso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="cc-payment" class="control-label mb-1">Codigo</label>
            <input id="codigo" type="text" class="form-control" aria-required="true" aria-invalid="false">
        </div>

        <div class="form-group has-success">
            <label for="cc-name" class="control-label mb-1">Nombre</label>
            <input id="nombre" type="text" class="form-control cc-name valid" data-val="true" data-val-required="Por favor digite el telefono"
                autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error">
            <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="AgregarSubcurso()">Agregar</button>
      </div>
    </div>
  </div>
</div>

{{ Form::open(array('method' => 'post', 'id' => 'formRegistro') )}}
{{ Form::close()}}

<script>
    var sub_cursos = [];

    function AgregarSubcurso() {
        var codigo = $("#codigo").val()
        var nombre = $("#nombre").val()

        var subCurso = {
            "codigo":codigo,
            "nombre":nombre
        }

        sub_cursos.push(subCurso)
        MostrarTabla()
    }

    function MostrarTabla() {
        $("#bodytable").html('')
        var posicion = 0;
        sub_cursos.forEach(function (sub_curso) {
            var fila = "<tr>"+
                        "<td>"+sub_curso.codigo+"</td>"+
                        "<td>"+sub_curso.nombre+"</td>"+
                        "<td><i class='fa fa-trash' onclick='QuitarSubCurso("+posicion+")'></i></td>"+
                        "</tr>"
            $("#bodytable").append(fila)
            posicion++
        })
    }

    function QuitarSubCurso(posicion) {
        sub_cursos.splice(posicion, 1)
        MostrarTabla()
    }

    function Registrar() {
        var data_form = $("#formRegistro").serialize()
        var token = data_form.split("&")[0].split("=")[1]
        var curso_padre = {
            "codigo" : $("#codigo_padre").val(),
            "nombre" : $("#nombre_padre").val()
        }

        var url = "{{route('curso/registrar_cursos')}}"
        var request = {
            "_token" : token,
            "curso_padre" : curso_padre,
            "sub_cursos" : sub_cursos
        }
        console.log(request)

        $.post(url, request, function(response){
            if (response.error == false) {
                swal.fire("Proceso Exitoso",response.mensaje,"success").then((result)=>{
                    if(result.value==true) location.href="{{ route('curso/listar_cursos') }}"
                }) 
            }
        })
    }
</script>
<title>Editar Curso</title>
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
                    <h3 class="text-center title-2">Editar curso</h3>
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

                <br>

                @if (session('mensaje_curso'))
                        <div id="msg" class="alert alert-danger" >
                            
                                <li>{{session('mensaje_curso')}}</li>
                        </div>

                        <script>
                            setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                        </script>
                @endif

                <input type="hidden" name="id_curso" value="{{$curso->id_curso}}">
                <div class="form-group">
                    <label for="cc-payment" class="control-label mb-1">Codigo</label>
                    <input id="codigo_padre" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$curso->codigo}}">
                </div>

                <div class="form-group has-success">
                    <label for="cc-name" class="control-label mb-1">Nombre</label>
                    <input id="nombre_padre" type="text" class="form-control cc-name valid" data-val="true" data-val-required="Por favor digite el telefono"
                        autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error" value="{{$curso->nombre}}">
                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                </div>

                <div>
                    <button id="payment-button" class="btn btn-lg btn-info btn-block" onclick="GuardarCambios()">
                        <i class="fa fa-lock fa-lg"></i>&nbsp;
                        <span id="payment-button-amount">Guardar Cambios</span>
                        <span id="payment-button-sending" style="display:none;">Sending…</span>
                    </button>
                </div>
                <br>
                <div>
                    <a id="payment-button" class="btn btn-lg btn-danger btn-block" style="color: white" href="{{ route('curso/eliminar_curso' ,$curso->id_curso)}}">
                        <i class="fa fa-trash fa-lg"></i>&nbsp;
                        <span id="payment-button-amount">Eliminar</span>
                        <span id="payment-button-sending" style="display:none;">Sending…</span>
                    </a>
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
                                <th>N° estudiantes</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="bodytable">
                            
                            @foreach ($curso->subCursos as $sc)
                                <script>
                                    AgregarSubCursosExistentes('{{$sc->id_curso}}', '{{$sc->codigo}}','{{$sc->nombre}}', '{{count($sc->estudiantes())}}')

                                </script>
                            @endforeach
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

<div class="modal fade" id="ModalVerEstudiantes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 1000px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Listado de estudiantes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive table--no-card m-b-30">
            <table class="table table-borderless table-striped table-earning">
                <thead>
                    <tr>
                        <th>Identificacion</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Telefono</th>
                    </tr>
                </thead>
                <tbody id="bodytableModal">
                    
                    
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

<div class="modal fade" id="ModalEditarSubcurso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar subcurso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="cc-payment" class="control-label mb-1">Codigo</label>
            <input id="codigo_sub_curso" type="text" class="form-control" aria-required="true" aria-invalid="false">
        </div>

        <div class="form-group has-success">
            <label for="cc-name" class="control-label mb-1">Nombre</label>
            <input id="nombre_sub_curso" type="text" class="form-control cc-name valid" data-val="true" data-val-required="Por favor digite el telefono"
                autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error">
            <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="ModificarSubCurso()">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>

{{ Form::open(array('method' => 'post', 'id' => "formEditarCurso")) }}
{{ Form::close() }}

<script>
    var sub_cursos = [];
    var posicion_curso_editar


    function AgregarSubcurso() {
        var codigo = $("#codigo").val()
        var nombre = $("#nombre").val()

        var subCurso = {
            "id_curso":0,
            "codigo":codigo,
            "nombre":nombre,
            "num_estudiantes":0 
        }

        $("#codigo").val("")
        $("#nombre").val("")
        sub_cursos.push(subCurso)
        MostrarTabla()
    }

    function ModificarSubCurso(){

        sub_cursos[posicion_curso_editar].codigo = $("#codigo_sub_curso").val()
        sub_cursos[posicion_curso_editar].nombre = $("#nombre_sub_curso").val()
        MostrarTabla()
    }

    function MostrarTabla() {
        $("#bodytable").html('')
        var posicion = 0;
        sub_cursos.forEach(function (sub_curso) {
            var fila = "<tr>"+
                        "<td>"+sub_curso.codigo+"</td>"+
                        "<td>"+sub_curso.nombre+"</td>"+
                        "<td>"+sub_curso.num_estudiantes+"</td>"+
                        "<td><i title='Ver estudiantes' class='fa fa-users' onclick='MostrarEstudiantes("+posicion+", "+sub_curso.id_curso+")'></i> <i title='Editar curso' class='fa fa-pencil-square-o' style='margin-left: 10px' onclick='AbrirModalEditar("+posicion+")'></i> <i class='fa fa-trash' title='Eliminar curso' style='margin-left: 10px' onclick='QuitarSubCurso("+posicion+","+sub_curso.id_curso+")'></i></td>"+
                        "</tr>"
            $("#bodytable").append(fila)
            posicion++
        })
    }

    function QuitarSubCurso(posicion, id_curso) {
        Swal.fire({
          title: '¿Esta seguro que desea eliminar?',
          text: "El curso se eliminara de forma permanente!",
          icon: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
        if (result.value) {
            if(sub_cursos[posicion].id_curso != 0){
                var url="../../curso/eliminar_sub_curso/"+id_curso
                $.get(url, function(response) {
                    if(response.error == false){
                        Swal.fire(
                          'Eliminado!',
                          response.mensaje,
                          'success'
                        ).then((result) => {
                              if (result.value) {
                                sub_cursos.splice(posicion, 1)
                                MostrarTabla()
                              }
                            })
                    }else{
                        Swal.fire(
                          'Error!',
                          'No se puede eliminar el curso porque tiene materias asignadas',
                          'warning'
                        ).then((result) => {
                              if (result.value) {
                                MostrarTabla()
                              }
                            })
                    }
                })
            }else{
                Swal.fire(
                          'Eliminado!',
                          'Curso eliminado exitosamente',
                          'success'
                        ).then((result) => {
                              if (result.value) {
                                sub_cursos.splice(posicion, 1)
                                MostrarTabla()
                              }
                })
            }
          }
        })

    }



    function AgregarSubCursosExistentes(id_curso, codigo, nombre, num_estudiantes) {

        var subCurso = {
            "id_curso":id_curso,
            "codigo":codigo,
            "nombre":nombre,
            "num_estudiantes":num_estudiantes
        }
        sub_cursos.push(subCurso)
        MostrarTabla()
    }

    function GuardarCambios() {
        var data_form = $("#formEditarCurso").serialize()
        var token = data_form.split("&")[0].split("=")[1]
        var curso_padre = {
            "id_curso" : $("#id_curso").val(),
            "codigo" : $("#codigo_padre").val(),
            "nombre" : $("#nombre_padre").val()
        }

        var url = "{{route('curso/editar_curso', $curso->id_curso)}}"
        var request = {
            "_token" : token,
            "curso_padre" : curso_padre,
            "sub_cursos" : sub_cursos
        }

        $.post(url, request, function(response){
            if (response.error == false) {
                swal.fire("Proceso Exitoso",response.mensaje,"success").then((result)=>{
                    if(result.value==true) location.href="{{ route('curso/listar_cursos') }}"
                })  
            }
        })
    }

    function AbrirModalEditar(posicion){
        $("#ModalEditarSubcurso").modal("show")
        var posicion = posicion
        posicion_curso_editar = posicion
        var nombre = sub_cursos[posicion].nombre
        var codigo = sub_cursos[posicion].codigo
        $("#codigo_sub_curso").val(codigo)
        $("#nombre_sub_curso").val(nombre)
    }

    function MostrarEstudiantes(posicion, id_curso){
        $("#ModalVerEstudiantes").modal("show")
        $("#bodytableModal").html('')
        var url = "../../curso/estudiantes_por_curso/"+id_curso
        console.log(url)
        $.get(url, function(response){
            response.forEach((estudiantes)=>{
                var fila = "<tr>"+
                           "<td>"+estudiantes.identificacion+"</td>"+
                           "<td>"+estudiantes.nombre+"</td>"+
                           "<td>"+estudiantes.apellido+"</td>"+
                           "<td>"+estudiantes.email+"</td>"+
                           "<td>"+estudiantes.telefono+"</td>"+
                           "</tr>"
                $("#bodytableModal").append(fila)
                posicion++
            })
        })
    }
</script>
<title>Editar Asignatura</title>
@extends('layouts.main')
@section('content')
<div class="row">
<div class="col-lg-2">
</div>
	<div class="col-lg-8">
        <div class="card">
            <div class="card-header">Asignatura</div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">Editar asignatura</h3>
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

                @if (session('mensaje_asignatura'))
                        <div id="msg" class="alert alert-danger" >
                            
                                <li>{{session('mensaje_asignatura')}}</li>
                        </div>

                        <script>
                            setTimeout(function(){ $('#msg').fadeOut() }, 10000);
                        </script>
                @endif
                
                    <input type="hidden" name="id_asignatura" value="{{$asignatura->id_asignatura}}">
                    <div class="form-group">
                        <label for="cc-payment" class="control-label mb-1">Codigo</label>
                        <input id="codigo_padre" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$asignatura->codigo}}">
                    </div>

                    <div class="form-group has-success">
                        <label for="cc-name" class="control-label mb-1">Nombre</label>
                        <input id="nombre_padre" name="nombre" type="text" class="form-control cc-name valid" data-val="true" data-val-required="Por favor digite el telefono"
                            autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error" value="{{$asignatura->nombre}}">
                        <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                    </div>

                    <div class="form-group has-success" style="display: none">
                        <label for="cc-name" class="control-label mb-1">Docente</label>
                        <select name="selectDocente" id="selectDocente" class="form-control">
                            <option value="0">Seleccione...</option>
                            @foreach ($docentes as $d)
                                @if ($d->id_persona==$asignatura->id_persona)
                                    <option selected value="{{$d->id_persona}}">{{$d->nombre}} {{$d->apellido}}</option>
                                @else
                                    <option value="{{$d->id_persona}}">{{$d->nombre}} {{$d->apellido}}</option>
                                @endif

                            @endforeach
                        </select>
                    </div>

                    <div class="form-group has-success">
                        <label for="cc-name" class="control-label mb-1">Curso</label>
                        <select name="selectCursoPadre" id="selectCursoPadre" class="form-control" onchange="if(this.value!=0){$('#divSubmateria').fadeIn()} else{$('#divSubmateria').fadeOut()}">
                            <option value="0">Seleccione...</option>
                            @foreach ($cursos_padres as $cp)
                                @if ($cp->id_curso==$asignatura->id_curso)
                                    <option selected value="{{$cp->id_curso}}">{{$cp->nombre}}</option>
                                @else
                                    <option value="{{$cp->id_curso}}">{{$cp->nombre}}</option>
                                @endif  
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <button id="payment-button" onclick="GuardarCambios()" class="btn btn-lg btn-info btn-block">
                            <i class="fa fa-lock fa-lg"></i>&nbsp;
                            <span id="payment-button-amount">Guardar Cambios</span>
                            <span id="payment-button-sending" style="display:none;">Sending…</span>
                        </button>
                    </div>
                    <br>
                    <div>
                        <a id="payment-button" class="btn btn-lg btn-danger btn-block" style="color: white" href="{{ route('asignatura/eliminar_asignatura' ,$asignatura->id_asignatura)}}">
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
                    <div class="col-lg-6">Submaterias</div>
                    <div class="col-lg-6" id="divSubmateria"><button class="btn btn-info pull-right" style="margin-bottom: 5px" onclick="AbrirModal()">Agregar submateria</button></div>
                </div>
            </div>
                <div class="card-body">    
    
        <div class="table-responsive table--no-card m-b-30">
            <table class="table table-borderless table-striped table-earning">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Docente</th>
                        <th>Curso</th>
                        <th>Opciones</th>
                    </tr>
                </thead>

                <tbody id="bodytable">
                    
                    @foreach ($asignatura->subMaterias as $sm)
                        <script>
                            AgregarSubMateriasExistentes('{{$sm->id_asignatura}}', '{{$sm->codigo}}','{{$sm->nombre}}','{{$sm->id_persona}}', '{{$sm->id_curso}}', '{{$sm->persona->nombre}}', '{{$sm->persona->apellido}}', '{{$sm->curso->nombre}}')
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

<div class="modal fade" id="ModalSubmateria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar submateria</h5>
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

        <div class="form-group has-success">
            <label for="cc-name" class="control-label mb-1">Docente</label>
            <select name="selectDocenteModal" id="selectDocenteModal" class="form-control">
                <option value="0">Seleccione...</option>
                @foreach ($docentes as $d)
                    <option value="{{$d->id_persona}}">{{$d->nombre}} {{$d->apellido}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group has-success">
            <label for="cc-name" class="control-label mb-1">Curso</label>
            <select name="selectCursoHijo" id="selectCursoHijo" class="form-control" onchange="if(this.value!=0){$('#divSubmateria').fadeIn()} else{$('#divSubmateria').fadeOut()}">
                
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="AgregarSubmaterias()">Agregar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalSubmateriaEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar submateria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="cc-payment" class="control-label mb-1">Codigo</label>
            <input id="codigo_sub_materia" type="text" class="form-control" aria-required="true" aria-invalid="false">
        </div>

        <div class="form-group has-success">
            <label for="cc-name" class="control-label mb-1">Nombre</label>
            <input id="nombre_sub_materia" type="text" class="form-control cc-name valid" data-val="true" data-val-required="Por favor digite el telefono"
                autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error">
            <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
        </div>

        <div class="form-group has-success">
            <label for="cc-name" class="control-label mb-1">Docente</label>
            <select name="selectDocenteModalEdit" id="selectDocenteModalEdit" class="form-control">
                <option value="0">Seleccione...</option>
                @foreach ($docentes as $d)
                    <option value="{{$d->id_persona}}">{{$d->nombre}} {{$d->apellido}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group has-success">
            <label for="cc-name" class="control-label mb-1">Curso</label>
            <select name="selectCursoHijoEdit" id="selectCursoHijoEdit" class="form-control">
                
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="ModificarSubMateria()">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>

{{ Form::open(array('method' => 'post', 'id' => "formEditarAsignatura")) }}
{{ Form::close() }}

<script>
    var sub_materias = [];
    var sub_cursos_escogidos = [];

    function AgregarSubmaterias() {
        var codigo = $("#codigo").val()
        var nombre = $("#nombre").val()
        var nombre_completo = $("select[name='selectDocenteModal'] option:selected").text()
        var nombre_docente = nombre_completo.split(" ")[0]
        var apellido_docente = nombre_completo.split(" ")[1]
        var id_docente = $("#selectDocenteModal").val()
        var nombre_curso_hijo = $("select[name='selectCursoHijo'] option:selected").text()
        var id_curso_hijo = $("#selectCursoHijo").val()

       

        var subMateria = {
            "id_asignatura":0,
            "codigo":codigo,
            "nombre":nombre,
            "id_persona" : id_docente,
            "nombre_docente" : nombre_docente,
            "apellido_docente":apellido_docente,
            "id_curso" : id_curso_hijo,
            "nombre_curso_hijo" : nombre_curso_hijo
        }




        $("#codigo").val("")
        $("#nombre").val("")
        sub_materias.push(subMateria)
        console.log(sub_materias)
        sub_cursos_escogidos.push(parseInt(id_curso_hijo))
        ActualizarCursosHijosSelect()
        MostrarTabla()
    }

    function MostrarTabla() {
        $("#bodytable").html('')
        var posicion = 0;
        sub_materias.forEach(function (sub_materia) {
            var fila = "<tr>"+
                        "<td>"+sub_materia.codigo+"</td>"+
                        "<td>"+sub_materia.nombre+"</td>"+
                        "<td>"+sub_materia.nombre_docente +" "+sub_materia.apellido_docente+"</td>"+
                        "<td>"+sub_materia.nombre_curso_hijo+"</td>"+
                        "<td><i class='fa fa-pencil-square-o' onclick='AbrirModalEdit("+posicion+")'></i> <i class='fa fa-trash' onclick='QuitarSubMateria("+posicion+", "+sub_materia.id_asignatura+")'></i></td>"+
                        "</tr>"
            $("#bodytable").append(fila)
            posicion++
        })
    }

    function AgregarSubMateriasExistentes(id_asignatura, codigo, nombre, id_persona, id_curso, nombre_docente, apellido_docente, nombre_curso_hijo) {

        var subMateria = {
            "id_asignatura":id_asignatura,
            "codigo":codigo,
            "nombre":nombre,
            "id_persona":id_persona,
            "id_curso":id_curso,
            "nombre_docente":nombre_docente,
            "apellido_docente":apellido_docente,
            "nombre_curso_hijo":nombre_curso_hijo
        }
        sub_materias.push(subMateria)
        sub_cursos_escogidos.push(parseInt(id_curso))
        ActualizarCursosHijosSelect()       
        MostrarTabla()
    }

    function AbrirModal(){
        $("#selectCursoHijo").html('<option value="0">Seleccione...</option>')
        $("#ModalSubmateria").modal("show")
        var id_curso_padre = $("#selectCursoPadre").val()

        var url = "../../curso/consultar_sub_cursos/"+id_curso_padre
        $.get(url, function(response){
            response.forEach((sub_cursos)=>{
                if(sub_cursos_escogidos.includes(sub_cursos.id_curso) == false){
                    var opcion = "<option value='"+sub_cursos.id_curso+"'>"+sub_cursos.nombre+"</option>"
                    $("#selectCursoHijo").append(opcion)
                }
            })
        })
    }

    function QuitarSubMateria(posicion, id_asignatura) {
        Swal.fire({
          title: '¿Esta seguro que desea eliminar?',
          text: "La asignatura se eliminara de forma permanente!",
          icon: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
        if (result.value) {
            if(sub_materias[posicion].id_asignatura != 0){
                var url="../../asignatura/eliminar_sub_materia/"+id_asignatura
                $.get(url, function(response) {
                    if(response.error == false){
                        Swal.fire(
                          'Eliminado!',
                          response.mensaje,
                          'success'
                        ).then((result) => {
                              if (result.value) {
                                sub_materias.splice(posicion, 1)
                                sub_cursos_escogidos.splice(posicion, 1)
                                MostrarTabla()
                              }
                            })
                    }else{
                        Swal.fire(
                          'Error!',
                          response.mensaje,
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
                          'Asignatura eliminada exitosamente',
                          'success'
                        ).then((result) => {
                              if (result.value) {
                                sub_materias.splice(posicion, 1)
                                sub_cursos_escogidos.splice(posicion, 1)
                                MostrarTabla()
                              }
                })
            }
          }
        })                   
    }

    function GuardarCambios() {
        var data_form = $("#formEditarAsignatura").serialize()
        var token = data_form.split("&")[0].split("=")[1]
        var materia_padre = {
            "id_asignatura" : $("#id_asignatura").val(),
            "codigo" : $("#codigo_padre").val(),
            "nombre" : $("#nombre_padre").val(),
            "id_persona" : $("#selectDocente").val(),
            "nombre_docente" : $("select[name='selectDocente'] option:selected").text(),
            "id_curso" : $("#selectCursoPadre").val(),
            "nombre_curso_padre" : $("select[name='selectCursoPadre'] option:selected").text()
        }

        var url = "{{route('asignatura/editar_asignatura', $asignatura->id_asignatura)}}"
        var request = {
            "_token" : token,
            "materia_padre" : materia_padre,
            "sub_materias" : sub_materias
        }

        $.post(url, request, function(response){
            if (response.error == false) {
                swal.fire("Proceso Exitoso",response.mensaje,"success").then((result)=>{
                    if(result.value==true) location.href="{{ route('asignatura/listar_asignaturas') }}"
                }) 
            }
        })
    }

    function AbrirModalEdit(posicion){
        $("#ModalSubmateriaEditar").modal("show")
        $("#selectCursoHijoEdit").html('<option value="0">Seleccione...</option>')

        var id_curso_padre = $("#selectCursoPadre").val()
        var url = "../../curso/consultar_sub_cursos/"+id_curso_padre
        $.get(url, function(response){
            response.forEach((sub_cursos)=>{
                if(sub_cursos_escogidos.includes(sub_cursos.id_curso) == false || sub_cursos.id_curso == sub_materias[posicion].id_curso){
                    if(sub_cursos.id_curso == sub_materias[posicion].id_curso){
                    var opcion = "<option selected value='"+sub_cursos.id_curso+"'>"+sub_cursos.nombre+"</option>"
                    }else{
                    var opcion = "<option value='"+sub_cursos.id_curso+"'>"+sub_cursos.nombre+"</option>"
                    }
                $("#selectCursoHijoEdit").append(opcion)
                }
            })
        })

        var posicion = posicion
        posicion_asignatura_editar = posicion
        var nombre = sub_materias[posicion].nombre
        var codigo = sub_materias[posicion].codigo
        var id_docente = sub_materias[posicion].id_persona
        var id_curso = sub_materias[posicion].id_curso
        var nombre_docente = sub_materias[posicion].nombre_docente
        var apellido_docente = sub_materias[posicion].apellido_docente
        var nombre_curso_hijo = sub_materias[posicion].nombre_curso_hijo
        $("#nombre_sub_materia").val(nombre)
        $("#codigo_sub_materia").val(codigo)
        $("#selectDocenteModalEdit").val(id_docente)
        $("#selectCursoHijoEdit").val(id_curso)
        $("#selectDocenteModalEdit option[value="+id_docente+"]").attr("selected",true)
        $("#selectCursoHijoEdit option[value="+id_curso+"]").attr("selected",true)
        $("select[name='selectDocenteModalEdit'] option:selected").text(nombre_docente+" "+apellido_docente)
    }

    function ModificarSubMateria(){
        sub_materias[posicion_asignatura_editar].codigo = $("#codigo_sub_materia").val()
        sub_materias[posicion_asignatura_editar].nombre = $("#nombre_sub_materia").val()
        sub_materias[posicion_asignatura_editar].id_persona = $("#selectDocenteModalEdit").val()
        sub_materias[posicion_asignatura_editar].id_curso = $("#selectCursoHijoEdit").val()
        var nombre_completo = $("select[name='selectDocenteModalEdit'] option:selected").text()
        var nombre_docente = nombre_completo.split(" ")[0]
        var apellido_docente = nombre_completo.split(" ")[1]
        sub_materias[posicion_asignatura_editar].nombre_docente = nombre_docente
        sub_materias[posicion_asignatura_editar].apellido_docente = apellido_docente
        sub_materias[posicion_asignatura_editar].nombre_curso_hijo = $("select[name='selectCursoHijoEdit'] option:selected").text()
        MostrarTabla()
    }

    function ActualizarCursosHijosSelect(){
        $("#selectCursoHijoEdit").html('<option value="0">Seleccione...</option>')
        var id_curso_padre = $("#selectCursoPadreEdit").val()

        var url = "../../curso/consultar_sub_cursos/"+id_curso_padre
        $.get(url, function(response){
            response.forEach((sub_cursos)=>{
                console.log(sub_cursos.id_curso)
                if(sub_cursos_escogidos.includes(sub_cursos.id_curso) == false){
                    var opcion = "<option value='"+sub_cursos.id_curso+"'>"+sub_cursos.nombre+"</option>"
                    $("#selectCursoHijoEdit").append(opcion)
                } 
            })
        })
    }
</script>
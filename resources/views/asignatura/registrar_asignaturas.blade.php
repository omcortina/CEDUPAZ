<title>Registrar Asignatura</title>
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
                    <h3 class="text-center title-2">Registrar asignatura</h3>
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
                        <input id="codigo_padre" value="{{$asignatura->codigo}}" type="text" class="form-control" aria-required="true" aria-invalid="false">
                    </div>

                    <div class="form-group has-success">
                        <label for="cc-name" class="control-label mb-1">Nombre</label>
                        <input id="nombre_padre" name="nombre" value="{{$asignatura->nombre}}" type="text" class="form-control cc-name valid" data-val="true" data-val-required="Por favor digite el telefono"
                            autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error">
                        <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                    </div>

                    <div class="form-group has-success" style="display: none">
                        <label for="cc-name" class="control-label mb-1">Docente</label>
                        <select name="selectDocente" id="selectDocente" class="form-control">
                            <option value="0">Seleccione...</option>
                            @foreach ($docentes as $d)
                                <option value="{{$d->id_persona}}">{{$d->nombre}} {{$d->apellido}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group has-success">
                        <label for="cc-name" class="control-label mb-1">Curso</label>
                        <select name="selectCursoPadre" id="selectCursoPadre" class="form-control" onchange="if(this.value!=0){$('#divSubmateria').fadeIn()} else{$('#divSubmateria').fadeOut()}">
                            <option value="0">Seleccione...</option>
                            @foreach ($cursos_padres as $cp)
                                <option value="{{$cp->id_curso}}">{{$cp->nombre}}</option>
                            @endforeach
                        </select>
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
                    <div class="col-lg-6">Submaterias</div>
                    <div class="col-lg-6" id="divSubmateria" style="display: none"><button class="btn btn-info pull-right" style="margin-bottom: 5px" onclick="AbrirModal()">Agregar submateria</button></div>
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

{{ Form::open(array('method' => 'post', 'id' => 'formRegistrarAsignatura')) }}
{{ Form::close() }}

<script>
    var sub_materias = [];
    var sub_cursos_escogidos = [];

    function AgregarSubmaterias() {
        var codigo = $("#codigo").val()
        var nombre = $("#nombre").val()
        var nombre_docente = $("select[name='selectDocenteModal'] option:selected").text()
        var id_docente = $("#selectDocenteModal").val()
        var nombre_curso_hijo = $("select[name='selectCursoHijo'] option:selected").text()
        var id_curso_hijo = $("#selectCursoHijo").val()

        var subMateria = {
            "codigo":codigo,
            "nombre":nombre,
            "id_persona" : id_docente,
            "nombre_docente" : nombre_docente,
            "id_curso" : id_curso_hijo,
            "nombre_curso_hijo" : nombre_curso_hijo
        }

        sub_materias.push(subMateria)
        sub_cursos_escogidos.push(parseInt(id_curso_hijo))
        console.log(sub_cursos_escogidos)
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
                        "<td>"+sub_materia.nombre_docente+"</td>"+
                        "<td>"+sub_materia.nombre_curso_hijo+"</td>"+
                        "<td><i class='fa fa-trash' onclick='QuitarSubMateria("+posicion+")'></i></td>"+
                        "</tr>"
            $("#bodytable").append(fila)
            posicion++
        })
    }

    function QuitarSubMateria(posicion) {
        var id_curso_a_eliminar = sub_materias[posicion].id_curso
        var posicion_sub_curso = 0
        var bandera = false
        while(bandera == false){
            if(id_curso_a_eliminar == sub_cursos_escogidos[posicion_sub_curso]){
                sub_cursos_escogidos.splice(posicion_sub_curso, 1)
                bandera = true
            }
            posicion_sub_curso++
        }
        sub_materias.splice(posicion, 1)
        
        MostrarTabla()
    }

    function Registrar() {
        var data_form = $("#formRegistrarAsignatura").serialize()
        var token = data_form.split("&")[0].split("=")[1]
        var materia_padre = {
            "codigo" : $("#codigo_padre").val(),
            "nombre" : $("#nombre_padre").val(),
            "id_persona" : $("#selectDocente").val(),
            "nombre_docente" : $("select[name='selectDocente'] option:selected").text(),
            "id_curso" : $("#selectCursoPadre").val(),
            "nombre_curso_padre" : $("select[name='selectCursoPadre'] option:selected").text()
        }

        var url = "{{route('asignatura/registrar_asignaturas')}}"
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

    function AbrirModal(){
        $("#selectCursoHijo").html('<option value="0">Seleccione...</option>')
        $("#ModalSubmateria").modal("show")
        var id_curso_padre = $("#selectCursoPadre").val()

        var url = "../curso/consultar_sub_cursos/"+id_curso_padre
        $.get(url, function(response){
            response.forEach((sub_cursos)=>{
                if(sub_cursos_escogidos.includes(sub_cursos.id_curso) == false){
                    var opcion = "<option value='"+sub_cursos.id_curso+"'>"+sub_cursos.nombre+"</option>"
                    $("#selectCursoHijo").append(opcion)
                } 
            })
        })
    }

    function ActualizarCursosHijosSelect(){
        $("#selectCursoHijo").html('<option value="0">Seleccione...</option>')
        var id_curso_padre = $("#selectCursoPadre").val()

        var url = "../curso/consultar_sub_cursos/"+id_curso_padre
        $.get(url, function(response){
            response.forEach((sub_cursos)=>{
                console.log(sub_cursos.id_curso)
                if(sub_cursos_escogidos.includes(sub_cursos.id_curso) == false){
                    var opcion = "<option value='"+sub_cursos.id_curso+"'>"+sub_cursos.nombre+"</option>"
                    $("#selectCursoHijo").append(opcion)
                } 
            })
        })
    }
</script>





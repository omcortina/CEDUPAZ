<title>Listado Asignaturas</title>
@extends('layouts.main')
@section('content')
<div class="row">
<div class="col-lg-1">
</div>
	<div class="col-lg-12">
	<div class="card">
            <div class="card-header">Listado de asignaturas</div>
            <div class="card-body">
            <div class="row">
	            <div class="col-lg-7">
                    <a class="btn btn-primary" href="{{ route('asignatura/registrar_asignaturas')}}">
                        <i>Nuevo</i>
                    </a>
	            </div>
	            <div class="col-lg-5">
	            <div class="input-group">
                    <div class="input-group-btn">
                        <button class="btn btn-primary" style="margin-right: 5px; margin-top: 4px">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <input type="text" id="filtro" placeholder="Consulte aqui..." class="form-control">
                </div>
	            </div>
            </div>

            <br>

            @if (session('mensaje_asignatura'))
                	<div id="msg" class="alert alert-success" >
                		
                			<li>{{session('mensaje_asignatura')}}</li>
                	</div>

                	<script>
                		setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                	</script>
                @endif
            <div class="row">
            <div class="col-lg-12">
            	
            
            	<div class="table-responsive table--no-card m-b-30">
            		<table class="table table-borderless table-striped table-earning">
				<thead>
					<tr>
                        <th>Id</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Submaterias</th>
					</tr>
				</thead>
				<tbody id="bodytable">
				    @foreach ($asignaturas as $a)
				    	<tr onclick="location.href = '{{route('asignatura/editar_asignatura' ,$a->id_asignatura)}}'">
                        <td>{{$a->id_asignatura}}</td>
                        <td>{{$a->codigo}}</td>
                        <td>{{$a->nombre}}</td>
                        <td>{{count($a->subMaterias)}}</td>
					   </tr>
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
@endsection


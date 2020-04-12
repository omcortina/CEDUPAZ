<title>Listado Cursos</title>
@extends('layouts.main')
@section('content')
<div class="row">
<div class="col-lg-1">
</div>
	<div class="col-lg-12">
	<div class="card">
            <div class="card-header">Listado de cursos</div>
            <div class="card-body">
            <div class="row">
	            <div class="col-lg-7">
                    <a class="btn btn-primary" href="{{ route('curso/registrar_cursos')}}">
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

            @if (session('mensaje_curso'))
                	<div id="msg" class="alert alert-success" >
                		
                			<li>{{session('mensaje_curso')}}</li>
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
                                <th>Subcursos</th>
        					</tr>
        				</thead>
        				<tbody id="bodytable">
        				    @foreach ($cursos as $c)
        				    	<tr onclick="location.href = '{{route('curso/editar_curso' ,$c->id_curso)}}'">
                                <td>{{$c->id_curso}}</td>
                                <td>{{$c->codigo}}</td>
                                <td>{{$c->nombre}}</td>
                                <td>{{count($c->subCursos)}}</td>
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


<script>
   
</script>
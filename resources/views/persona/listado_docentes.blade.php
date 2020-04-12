<title>Listado Docentes</title>
@extends('layouts.main')
@section('content')
<div class="row">
<div class="col-lg-1">
</div>
	<div class="col-lg-12">
	<div class="card">
            <div class="card-header">Listado de docentes</div>
            <div class="card-body">
            <div class="row">
	            <div class="col-lg-7">
                    <a class="btn btn-primary" href="{{ route('persona/registrar_docentes')}}">
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

            @if (session('mensaje_persona'))
            	<div id="msg" class="alert alert-success" >
            		
            			<li>{{session('mensaje_persona')}}</li>
            	</div>

            	<script>
            		setTimeout(function(){ $('#msg').fadeOut() }, 4000);
            	</script>
            @endif

            @if (session('error_mensaje_persona'))
                <div id="msg" class="alert alert-danger" >
                    
                        <li>{{session('error_mensaje_persona')}}</li>
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
                        <th>Identificacion</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
						<th>Email</th>
                        <th>Telefono</th>
                        <th>Sexo</th>
                        <th>Username</th>
                        <th>Password</th>
					</tr>
				</thead>
				<tbody id="bodytable">
				    @foreach ($docentes as $d)
				    	<tr onclick="location.href = '{{ route('persona/editar_docente' ,$d->id_persona) }}'">
                        <td>{{$d->id_persona}}</td>
                        <td>{{$d->identificacion}}</td>
                        <td>{{$d->nombre}}</td>
                        <td>{{$d->apellido}}</td>
                        <td>{{$d->email}}</td>
                        <td>{{$d->telefono}}</td>
						<td>{{$d->sexo->nombre}}</td>
						<td>{{$d->username}}</td>
						<td>{{$d->password}}</td>
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


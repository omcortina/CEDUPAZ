<title>Editar Curso</title>
@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6">Listado de estudiantes por curso</div>
                </div>
            </div>
                <div class="card-body">    
    
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
                        <th>Accion</th>
					</tr>
				</thead>
				<tbody id="bodytable">
				    @foreach ($estudiantes as $e)
				    	<tr>
                        <td>{{$e->id_persona}}</td>
                        <td>{{$e->identificacion}}</td>
                        <td>{{$e->nombre}}</td>
                        <td>{{$e->apellido}}</td>
                        <td>{{$e->email}}</td>
                        <td>{{$e->telefono}}</td>
						<td>{{$e->sexo->nombre}}</td>
						<td>{{$e->username}}</td>
						<td>{{$e->password}}</td>
						<td><i class="fa fa-trash"></i></td>
					   </tr>
				    @endforeach
				</tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
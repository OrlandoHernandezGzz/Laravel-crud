<!-- Establecemos la plantilla layaout -->
@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Condición para saber cuando mostrar un mensaje -->
    @if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <!-- Si por parametros se manda un mensaje entonces se mostrara en los formularios -->
        {{ Session::get('mensaje') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif



    <!-- Haciendo el enlace para ir al apartado de agregar. -->
    <a href="{{ url('empleado/create')}}" class="btn btn-success mb-4">Registrar nuevo empleado</a>

    <!-- # Mostrar la lista de empleados. -->
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $empleado)
            <tr>
                <td>{{$empleado->id}}</td>
                <td>
                    <img class="img-thumbnail img-fluid" src="{{asset('storage'). '/' . $empleado->foto}}" alt="foto_empleado" width="100">
                </td>
                <td>{{$empleado->nombre}}</td>
                <td>{{$empleado->apellidoPaterno}}</td>
                <td>{{$empleado->apellidoMaterno}}</td>
                <td>{{$empleado->correo}}</td>
                <td>
                    <a href="{{ url('/empleado/'. $empleado->id . '/edit') }}" class="btn btn-warning">Editar</a>
                
                |
                    <!-- LLamamos la ruta empleado con el id que se va editar -->
                    <form action="{{ url('/empleado/'. $empleado->id) }}" class="d-inline" method="post">
                        @csrf
                        <!-- Hacemos que este método sea para eliminar -->
                        {{ method_field("DELETE") }}
                        <input type="submit" value="borrar" class="btn btn-danger" onclick="return confirm('¿Quieres borrar?')">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

{{$empleados->links()}}

</div>
@endsection
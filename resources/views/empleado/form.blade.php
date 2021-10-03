<h1>{{$modo}} Empleado</h1>

<!-- Algoritmo para poner una alerta de los campos que faltan por llenar -->
@if(count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<!-- # Formulario que tendra datos en comun con create y edit. -->
<div class="form-group">
    <label for="nombre">Nombre:</label>
    <!-- El old('nombre') es para recuperar los datos cuando no digitaste unos-->
    <input type="text" class="form-control" name="nombre" value="{{isset($empleado->nombre)?$empleado->nombre:old('nombre')}}" id="nombre" >
</div>

<div class="form-group">
    <label for="apellidoPaterno">Apellido Paterno:</label>
    <input type="text" class="form-control" name="apellidoPaterno" id="apellidoPaterno" value="{{isset($empleado->apellidoPaterno)? $empleado->apellidoPaterno:old('apellidoPaterno')}}">
</div>

<div class="form-group">
    <label for="apellidoMaterno">Apellido Materno:</label>
    <input type="text" class="form-control" name="apellidoMaterno" id="apellidoMaterno" value="{{isset($empleado->apellidoMaterno)? $empleado->apellidoMaterno:old('apellidoMaterno')}}">
</div>

<div class="form-group">
    <label for="correo">Correo:</label>
    <input type="email" class="form-control" name="correo" id="correo" value="{{isset($empleado->correo)? $empleado->correo:old('correo')}}">
</div>

<div class="form-group">
    <label for="foto">Foto:</label>
    @if(isset($empleado->foto))
    <img src="{{asset('storage'). '/' . $empleado->foto}}" class="img-thumbnail img-fluid"  width="100" alt="foto_empleado">
    @endif
    <input type="file" class="form-control" name="foto" id="foto">
</div>


<input type="submit" class="btn btn-success" value="{{$modo}}">

<!-- Haciendo el enlace para ir al apartado de agregar.s -->
<a href="{{ url('empleado')}}" class="btn btn-primary">Regresar</a>
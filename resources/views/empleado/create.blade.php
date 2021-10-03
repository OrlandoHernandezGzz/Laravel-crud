<!-- Establecemos la plantilla layaout -->
@extends('layouts.app')

@section('content')
<div class="container">

<!-- Formulario de creación de empleado. -->

<!-- Para enviar imagenes se usa la tercera propiedad -->
<form action="{{ url('empleado') }}" method="post" enctype="multipart/form-data">
<!-- LLave de seguridad para los formularios -->
@csrf 
<!-- Importamos nuestro formulario que esta en el archivo form.blade.php -->
@include('empleado.form', ['modo'=>'Crear'])
</form>

</div>
@endsection
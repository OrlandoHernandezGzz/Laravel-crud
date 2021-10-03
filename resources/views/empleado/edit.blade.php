<!-- Establecemos la plantilla layaout -->
@extends('layouts.app')

@section('content')
<div class="container">
<!-- # Formulario de edición de empleado. -->

<!-- Importamos nuestro formulario que esta en el archivo form.blade.php -->
<form action="{{ url('/empleado/' . $empleado->id ) }}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- Instruccion que hará que podamos actualizar los datos modificados -->
    {{ method_field('PATCH')}}
    @include('empleado.form', ['modo'=>'Editar'])
</form>

</div>
@endsection
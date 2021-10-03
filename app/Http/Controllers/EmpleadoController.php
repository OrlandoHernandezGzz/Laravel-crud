<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //Obtenemos los datos de nuestra base de datos
        $datos['empleados'] = Empleado::paginate(5);

        //Se le esta dando al controlador la información de la vista.
        return view('empleado.index', $datos); //Le pasamos los datos a nuestra vista.
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Se le esta dando al controlador la información de la vista.
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Guarda todas las solicitudes de los campos.
        // $datosEmpleados = request()->all();

        $campos = [
            'nombre' => 'required|string|max:100',
            'apellidoPaterno' => 'required|string|max:100',
            'apellidoMaterno' => 'required|string|max:100',
            'correo' => 'required|email',
            'foto' => 'required|max:10000|mimes:jpeg,png,jpg'
        ];

        $mensaje = [
            //El :attribute es un comodin para poner los campos que no existan
            'required' => 'El :attribute es requerido',
            'foto.required' => "La foto es requerida"
        ];

        //Para validar los datos que nos estan enviando.
        $this->validate($request, $campos, $mensaje);

        $datosEmpleados = request()->except('_token');

        //Condicion para agregar si hay una fotografia.
        if($request->hasFile('foto')){
            //alteramos el campo datos empleado en su foto, asignandole la foto y su ruta.
            $datosEmpleados['foto'] = $request->file('foto')->store('uploads', 'public');
        }

        //Insertamos los datos que enviamos a nuestra base de datos
        Empleado::insert($datosEmpleados);

        //Va responder mostrando los datos con tipo json.
        // return response()->json($datosEmpleados);      
        
        //Para mandar un mensaje cuando se guarde nuestro formulario.
        return redirect('empleado')->with('mensaje', 'Empleado agregado con exito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Buscamos el id que vamos a editar
        $empleado = Empleado::find($id);
        //Retornamos la vista y sus datos del empleado.
        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campos = [
            'nombre' => 'required|string|max:100',
            'apellidoPaterno' => 'required|string|max:100',
            'apellidoMaterno' => 'required|string|max:100',
            'correo' => 'required|email',
        ];

        $mensaje = [
            //El :attribute es un comodin para poner los campos que no existan
            'required' => 'El :attribute es requerido',
        ];

        if($request->hasFile('foto')){
            $campos = ['foto' => 'required|max:10000|mimes:jpeg,png,jpg'];
            $mensaje = ['foto.required' => 'La foto es requerida'];
        }

        //Para validar los datos que nos estan enviando.
        $this->validate($request, $campos, $mensaje);

        //Le decimos que nos de todas las solicitudes, menos el token y el metodo PATCH
        $datosEmpleados = request()->except(['_token', '_method']);

        //Condicion para agregar si hay una fotografia.
        if($request->hasFile('foto')){
            $empleado = Empleado::find($id);
            Storage::delete(['public/'.$empleado->foto]);
            //alteramos el campo datos empleado en su foto, asignandole la foto y su ruta.
            $datosEmpleados['foto'] = $request->file('foto')->store('uploads', 'public');
        }

        //Actualizar siempre y cuando el id coincida.
        Empleado::where('id','=',$id)->update($datosEmpleados);
        $empleado = Empleado::find($id);
        
        return redirect('empleado')->with('mensaje', 'Empleado Modificado con exito!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        //Busca al empleado con el id que le pasamos por parametros
        $empleado = Empleado::find($id);
        //Condicion para eliminar si es que se encuentra almacenada la foto
        if(Storage::delete('public/' . $empleado->foto)){
            // el id pasa del parametro del form: action="{{ url('/empleado/'. $empleado->id) }}"
            Empleado::destroy($id);
        }

        return redirect('empleado')->with('mensaje', 'Empleado borrado con exito!');
    }
}

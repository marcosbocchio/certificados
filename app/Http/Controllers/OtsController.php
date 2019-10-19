<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\OtsRequest;
use App\Repositories\Ots\OtsRepository;
use Illuminate\Support\Collection as Collection;
use App\Ots;
use App\Clientes;
use App\Contactos;
use App\Epps;
use App\Riegos;
use Illuminate\Support\Facades\DB;
use App\OtServicios;
use App\User;
use App\Provincias;
use App\Localidades;
use Illuminate\Support\Facades\Auth;


class OtsController extends Controller
{
    Protected $ot;

    public function __construct(OtsRepository $otRepository)
    {
      $this->ot = $otRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
             return ots::with('cliente')->orderBy('created_at','DESC')->paginate(5); 
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $accion = 'create';      
        $user = auth()->user()->name;
        $header_titulo = "Orden de trabajo";
        $header_descripcion ="Crear";  
        return view('ots.index', compact('user','accion','header_titulo','header_descripcion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OtsRequest $request)
    {       
        return $this->ot->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $header_titulo = "Orden de trabajo";
        $header_descripcion ="Editar";      
        $accion = 'edit';      
        $user = auth()->user()->name;
        $ot = $this->ot->find($id);
        $cliente = Clientes::find($ot->cliente_id);    
        

        $ot_servicios = (new OtServiciosController)->show($ot->id);
        $ot_productos = (new OtProductosController)->show($ot->id);
        $ot_epps = (new OtEppsController)->show($ot->id);
        $ot_riesgos = (new OtRiesgosController)->show($ot->id);
        $ot_calidad_placas = (new OtCalidadPlacasController)->show($ot->id);  
        
      
        $ot_servicios = Collection::make($ot_servicios);
        $ot_calidad_placas = Collection::make($ot_calidad_placas);
        $ot_productos = Collection::make($ot_productos);
        $ot_epps = Collection::make($ot_epps);
        $ot_riesgos = Collection::make($ot_riesgos);
        $ot_contacto1 = Contactos::find($ot->contacto1_id);
        $ot_contacto2 = Contactos::find($ot->contacto2_id);
        $ot_contacto3 = Contactos::find($ot->contacto3_id);
        
        $ot_localidad = Localidades::find($ot->localidad_id);
        $ot_provincia = Provincias::find($ot_localidad->provincia_id);
        $responsable_ot = User::find($ot->responsable_ot_id);       
     
        
        if ($ot_contacto2 == null)
                $ot_contacto2 = new Contactos();
        if ($ot_contacto3 == null)
                $ot_contacto3 = new Contactos();

        return view('ots.edit',compact('ot',
                                        'cliente',
                                        'user',
                                        'ot_servicios',
                                        'ot_calidad_placas',
                                        'ot_productos',
                                        'ot_epps',
                                        'ot_riesgos',
                                        'accion',
                                        'ot_contacto1',
                                        'ot_contacto2',
                                        'ot_contacto3',
                                        'responsable_ot',
                                        'ot_provincia',
                                        'ot_localidad',
                                        'header_titulo',
                                        'header_descripcion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OtsRequest $request, $id)
    {
       
        
        return $this->ot->updateOt($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function firmar($id){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }

        $ot = Ots::findOrFail($id);
        $ot->firma =  $user_id;
        $ot->save();

        return $ot;

    } 
}
